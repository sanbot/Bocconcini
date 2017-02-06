<?php

namespace app\controllers;

use Yii;
use app\models\Sales;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SalesController implements the CRUD actions for Sales model.
 */
class SalesController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => Yii::$app->user->isGuest ? false : Yii::$app->user->identity->roleid == 1 ? true : false,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Sales models.
     * @return mixed
     */
    public function actionIndex() {
        $model = new Sales();
        $query = Sales::find();
        if ($model->load(Yii::$app->request->post())) {
            $query->where('date between \''. $model->startdate.'\' and \''. $model->enddate.'\'');
        } else {
            $query->where('date(date) = date(now())');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

}
