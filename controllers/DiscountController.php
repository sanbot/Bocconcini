<?php

namespace app\controllers;

use Yii;
use app\models\Discount;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Discountproduct;
use app\models\Product;

/**
 * DiscountController implements the CRUD actions for Discount model.
 */
class DiscountController extends Controller {

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
                'only' => ['index', 'create', 'update', 'view', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete', 'view'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Discount models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Discount::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Discount model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $modelDiscountproduct = new Discountproduct();
        
        $queryProduct = Product::find()
                ->join('left join' , 'tbldiscountproduct', 'tblproduct.id = tbldiscountproduct.prductid')
                ->where('tbldiscountproduct.prductid is null')->all();
        
        $query = Discountproduct::find()
                ->select('tblproduct.*, tbldiscount.*, tbldiscountproduct.*, tblproduct.price * (1- (tbldiscount.percent / 100)) as value')
                ->joinWith(['product'])
                ->joinWith(['discount'])
                ->where('tbldiscount.id = '.$id);
        $dataProviderProducts = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'modelDiscountproduct' => $modelDiscountproduct,
                    'queryProduct' => $queryProduct, 
                    'dataProviderProducts' => $dataProviderProducts,
        ]);
    }

    /**
     * Creates a new Discount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Discount();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            Yii::$app->session->setFlash('error', $model->getErrors());
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Discount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Discount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Discount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Discount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Discount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
