<?php

namespace testtask\entitieslist\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use testtask\entitieslist\models\EntitySearch;
use testtask\entitieslist\models\Entity;

/**
 * AttributeController implements the CRUD actions for EavAttribute model.
 */
class DefaultController extends Controller
{
    public $layout = 'main';

    /**
     * Home page.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => [
                'created_at' => SORT_DESC,
            ]
        ];
        $dataProvider->pagination = [
            'pageSize' => 10,
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Stat action.
     * @return mixed
     */
    public function actionStat()
    {
        $this->layout = 'empty';

        $resultTotal = Yii::$app->db->createCommand("SELECT count(*) as `total` FROM `entitieslist_stack_of_entities`")->queryScalar();
        $resultToday = Yii::$app->db->createCommand("
          SELECT
            count(*) as `total`,
            sum(if(`e`.`type`='film',1,0)) + 0 as `films`,
            sum(if(`e`.`type`='music',1,0)) + 0 as `musics`,
            sum(if(`e`.`type`='event',1,0)) + 0 as `events`
          FROM `entitieslist_entity` as `e`
          JOIN `entitieslist_stack_of_entities` as `soe` ON `soe`.`entity_id` = `e`.`id`
          WHERE DATE(`soe`.`created_at`)=CURDATE()")->queryOne();

        print $this->render('stat', [
            'total'=>$resultTotal,
            'totalToday'=>$resultToday['total'],
            'totalTodayFilms'=>$resultToday['films'],
            'totalTodayMusics'=>$resultToday['musics'],
            'totalTodayEvents'=>$resultToday['events'],
        ]);
    }
}