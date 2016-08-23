<?php

namespace testtask\entitieslist\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * This is the command line Test Entities generator.
 *
 */

class GenerateController extends Controller
{
    static public $rawData = [
        'film' => [
            'cover'=>'/images/film-cover%d.jpg'
        ],
        'music' => [
            'cover'=>'/images/music-cover%d.jpg',
            'album'=>'Album #%d',
            'artist'=>'Artist #%d'
        ],
        'event' => [
            'cover'=>'/images/event-cover%d.jpg',
            'place'=>'Place #%d',
        ],
    ];

    public function actionIndex()
    {
        while(true) {
            $entities = array_keys(self::$rawData);
            $rand_key = array_rand($entities);
            $rand_key =$entities[$rand_key];
            $num = rand(1,5);
            $rawData = self::$rawData[$rand_key];

            switch($rand_key) {
                case 'film':
                    $model = new \testtask\entitieslist\models\EntityFilm();
                    $model->name = "Film #".$num;
                    $model->created_at = date("Y-m-d H:i:s");
                    break;
                case 'music':
                    $model = new \testtask\entitieslist\models\EntityMusic();
                    $model->name = "Music #".$num;
                    $model->created_at = date("Y-m-d H:i:s");
                    break;
                case 'event':
                    $model = new \testtask\entitieslist\models\EntityEvent();
                    $model->name = "Event #".$num;
                    $model->created_at = date("Y-m-d H:i:s");
                    $model->defineEavAttribute('end_date', date("Y-m-d H:i:s", strtotime("+".$num." day")));
                    break;
            }

            foreach($rawData as $attribute => $value) {
                $model->defineEavAttribute($attribute, sprintf($value, $num));
            }

            if($model->save()) {
                $status = $this->ansiFormat('OK', Console::FG_GREEN);
            } else {
                $status = $this->ansiFormat('FAILED', Console::FG_RED);
            }

            $this->stdout("".get_class($model)." ........ [".$status."]\n");

            sleep(1);
        }

        return 0;
    }
}