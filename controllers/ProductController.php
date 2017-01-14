<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Productcategory;
use yii\filters\AccessControl;
use app\models\Productimage;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller {

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
                    [
                        'allow' => true,
                        'actions' => ['view', 'index'],
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex() {
        
        $model = new Product();
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->roleid == 1) {
            $query = Product::find();
            $query->joinWith(['productcategory']);
            
            if ($model->load(Yii::$app->request->post())) {
                $query->orWhere('tblproduct.name like \'%' . $model->description . '%\'');
                $query->orWhere('tblproduct.description like \'%' . $model->description . '%\'');
            }

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);

            return $this->render('index', [
                        'dataProvider' => $dataProvider,
                        'model' => $model,
            ]);
        } else {
            if ($model->load(Yii::$app->request->post())) {
                $products = $model->findProductsHomePage($model->description);
            }else{
                $products = $model->findProductsHomePage('');
            }
            
            return $this->render('main', [
                        'model' => $model,
                        'products' => $products,
            ]);
        }
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $modelProductImage = new Productimage();
        $pi = new Productimage();
        $banner = $pi->findImagesProduct($id);
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'modelProductImage' => $modelProductImage,
                    'banner' => $banner,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Product();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->imagen = $model->URLImage();
            if ($model->save()) {
                $model->upload($model->id);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $queryProductCategory = Productcategory::find()->all();
            return $this->render('create', [
                        'model' => $model,
                        'queryProductCategory' => $queryProductCategory,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->imagen = $model->URLImage();
            if ($model->save()) {
                $model->upload($model->id);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $queryProductCategory = Productcategory::find()->all();
            return $this->render('update', [
                        'model' => $model,
                        'queryProductCategory' => $queryProductCategory,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        unlink('uploads/products/' . $id . '.' . $this->findModel($id)->imagen);
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Product::find()->joinWith(['productcategory'])->where('tblproduct.id = ' . $id)->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
