<?php

namespace app\controllers;

use Yii;
use app\models\Productimage;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Product;
use yii\filters\AccessControl;

/**
 * ProductimageController implements the CRUD actions for Productimage model.
 */
class ProductimageController extends Controller {

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
                        'allow' => Yii::$app->user->isGuest ? false : Yii::$app->user->identity->roleid == 1 ? true : false,
                        'actions' => ['index', 'create', 'update', 'view', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Productimage models.
     * @return mixed
     */
    public function actionIndex() {

        $model = new Productimage();
        $queryProduct = Product::find()->all();

        $query = Productimage::find()
                ->joinWith('product');

        if ($model->load(Yii::$app->request->post())) {
            $query->where('productid = ' . $model->productid);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                    'queryProduct' => $queryProduct,
        ]);
    }

    /**
     * Displays a single Productimage model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Productimage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Productimage();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->ext = $model->URLImage();
            if ($model->save()) {
                $model->upload($model->id, $model->productid);
                return $this->redirect(['product/view', 'id' => $model->productid]);
            }
        } else {
            $queryProduct = Product::find()->all();
            return $this->render('create', [
                        'model' => $model,
                        'queryProduct' => $queryProduct,
            ]);
        }
    }

    /**
     * Updates an existing Productimage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->ext = $model->URLImage();
            if ($model->save()) {
                $model->upload($model->id, $model->productid);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $queryProduct = Product::find()->all();
            return $this->render('update', [
                        'model' => $model,
                        'queryProduct' => $queryProduct,
            ]);
        }
    }

    /**
     * Deletes an existing Productimage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        unlink('uploads/products/' . $this->findModel($id)->productid . '/' . $id . '.' . $this->findModel($id)->ext);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Productimage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Productimage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Productimage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
