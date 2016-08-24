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

    public function actionIndex($sleep = 10)
    {
        $num = 1;
        while(true) {
            $entities = array_keys(self::$rawData);
            $rand_key = array_rand($entities);
            $rand_key =$entities[$rand_key];
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
                $stackModel = new \testtask\entitieslist\models\StackOfEntities();
                $stackModel->entity_id = $model->id;
                if(!$stackModel->save()) {
                    $status = $this->ansiFormat('WARNING', Console::FG_YELLOW);
                }
            } else {
                $status = $this->ansiFormat('FAILED', Console::FG_RED);
            }

            $this->stdout("".get_class($model)." ........ [".$status."]\n");

            sleep($sleep);

            if($num++ >= 5) {
                $num = 1;
            }
        }

        return 0;
    }

    public function actionDelete()
    {
        \testtask\entitieslist\models\Entity::deleteAll();

        return 0;
    }
}