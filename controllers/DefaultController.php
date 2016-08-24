<?php

namespace testtask\entitieslist\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use testtask\entitieslist\models\EntitySearch;

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
                'id' => SORT_DESC,
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
    
}