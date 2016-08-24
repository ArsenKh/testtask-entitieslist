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

            $randCreatedAt = strtotime("-".rand(0, 30)." day");
            $randReleasedAt = strtotime("+".rand(5, 10)." day", $randCreatedAt);
            /// * for events
            $randEndedAt = strtotime("+".rand(1,7)." day", $randReleasedAt);

            switch($rand_key) {
                case 'film':
                    $model = new \testtask\entitieslist\models\EntityFilm();
                    $model->name = "Some Film Entity #".$num;
                    break;
                case 'music':
                    $model = new \testtask\entitieslist\models\EntityMusic();
                    $model->name = "Some Music Entity #".$num;
                    break;
                case 'event':
                    $model = new \testtask\entitieslist\models\EntityEvent();
                    $model->name = "Some Event Entity #".$num;
                    $model->defineEavAttribute('ended_at', date("Y-m-d H:i:s", $randEndedAt));
                    break;
            }

            $model->released_at = date("Y-m-d H:i:s", $randReleasedAt);

            foreach($rawData as $attribute => $value) {
                $model->defineEavAttribute($attribute, sprintf($value, $num));
            }

            if($model->save()) {
                $status = $this->ansiFormat('OK', Console::FG_GREEN);
                $stackModel = new \testtask\entitieslist\models\StackOfEntities();
                $stackModel->entity_id = $model->id;
                $stackModel->created_at = date("Y-m-d H:i:s", $randCreatedAt);
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