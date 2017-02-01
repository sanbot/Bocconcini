<?php

namespace app\controllers;

use Yii;
use app\models\Discountproduct;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Discount;
use app\models\Product;

/**
 * DiscountproductController implements the CRUD actions for Discountproduct model.
 */
class DiscountproductController extends Controller {

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
                'only' => ['index', 'create', 'update', 'view', 'delete', 'add', 'remove'],
                'rules' => [
                    [
                        'allow' => Yii::$app->user->isGuest ? false : Yii::$app->user->identity->roleid == 1 ? true : false,
                        'actions' => ['index', 'create', 'update', 'delete', 'view', 'add', 'remove'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Discountproduct models.
     * @return mixed
     */
    public function actionIndex() {
        $query = Discountproduct::find()
                ->joinWith(['product'])
                ->joinWith(['discount']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Discountproduct model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Discountproduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Discountproduct();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $queryProduct = Product::find()->all();
            $querydiscount = Discount::find()->where('curdate() between initialdate and finaldate')->all();
            return $this->render('create', [
                        'model' => $model,
                        'queryProduct' => $queryProduct,
                        'querydiscount' => $querydiscount,
            ]);
        }
    }
    
    public function actionAdd() {
        $model = new Discountproduct();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['discount/view', 'id' => $model->discountid]);
        } else {
            return $this->redirect(['discount/view', 'id' => $model->discountid]);
        }
    }
    
    public function actionRemove($id, $discountid) {
        $this->findModel($id)->delete();

        return $this->redirect(['discount/view', 'id'=>$discountid]);
    }

    /**
     * Updates an existing Discountproduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $queryProduct = Product::find()->all();
            $querydiscount = Discount::find()->where('curdate() between initialdate and finaldate')->all();
            return $this->render('update', [
                        'model' => $model,
                        'queryProduct' => $queryProduct,
                        'querydiscount' => $querydiscount,
            ]);
        }
    }

    /**
     * Deletes an existing Discountproduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Discountproduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Discountproduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Discountproduct::find()->joinWith(['product', 'discount'])->where('tbldiscountproduct.id = ' . $id)->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
