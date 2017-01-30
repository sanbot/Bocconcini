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
use app\models\Categoryproducts;
use app\models\Discount;
use app\models\Productcommentary;

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
                'only' => ['index', 'create', 'update', 'view', 'delete', 'searchbycategory'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete', 'view', 'searchbycategory'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view', 'index', 'searchbycategory'],
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
        $action = 'product';
        $model = new Product();
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->roleid == 1) {
            $query = $model->findProductsAdmin();

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
                        'action' => $action,
            ]);
        } else {
            if ($model->load(Yii::$app->request->post())) {
                $products = $model->findProducts($model->description);
            } else {
                $products = $model->findProducts('');
            }

            return $this->render('main', [
                        'model' => $model,
                        'products' => $products,
                        'action' => $action,
            ]);
        }
    }
    
    public function actionSearchbycategory($categoryid) {
        $action = 'product/searchbycategory&categoryid='.$categoryid;
        $model = new Product();
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->roleid == 1) {
            $query = $model->findProductsAdminByCategory($categoryid);

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
                        'action' => $action,
            ]);
        } else {
            if ($model->load(Yii::$app->request->post())) {
                $products = $model->findProductsByCategory($model->description, $categoryid);
            } else {
                $products = $model->findProductsByCategory('', $categoryid);
            }

            return $this->render('main', [
                        'model' => $model,
                        'products' => $products,
                        'action' => $action,
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
        $modelProductCommentary = new Productcommentary();
        $modelCategoryproducts = new Categoryproducts();

        $pi = new Productimage();
        $banner = $pi->findImagesProduct($id, $this->findModel($id)->imagen);
        
        $category = new Productcategory();
        $queryCategory = $category->listCategoriesProduct($this->findModel($id)->category);
        
        $categoryproducts = new Categoryproducts();
        $queryCategoryproducts = $categoryproducts->listCategoryProducts($id);
        $dataProviderCategoryproducts = new ActiveDataProvider([
            'query' => $queryCategoryproducts,
        ]);

        $comments = $modelProductCommentary->findCommentsProduct($id);
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'modelProductImage' => $modelProductImage,
                    'banner' => $banner,
                    'modelProductCommentary' => $modelProductCommentary,
                    'comments' => $comments,
                    'dataProviderCategory' => $dataProviderCategoryproducts,
                    'modelCategoryproducts' => $modelCategoryproducts,
                    'queryCategory' => $queryCategory,
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
            if (isset($model->imageFile)) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if (isset($model->imageFile->extension)) {
                    $model->imagen = $model->URLImage();
                }
            }
            if ($model->save()) {
                if (isset($model->imageFile->extension)) {
                    $model->upload($model->id);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $queryProductCategory = Productcategory::find()->where('id <> 1')->all();
                Yii::$app->session->setFlash('error_image', 'La imágen es obligatoria para la creación de un producto.');
                return $this->render('create', [
                            'model' => $model,
                            'queryProductCategory' => $queryProductCategory,
                ]);
            }
        } else {
            $queryProductCategory = Productcategory::find()->where('id <> 1')->all();
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
            if (isset($model->imageFile->extension)) {
                $model->imagen = $model->URLImage();
            }
            if ($model->save()) {
                if (isset($model->imageFile->extension)) {
                    $model->upload($model->id);
                }
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
        $model = Product::find()->joinWith(['productcategory'])->where(['tblproduct.id' => $id])->one();

        if ($model !== null) {
            $modelDis = Discount::find()
                    ->joinWith(['discountproducts'])
                    ->where(['tbldiscountproduct.prductid' => $id])
                    ->andWhere('curdate() between tbldiscount.initialdate and tbldiscount.finaldate')
                    ->one();
            if ($modelDis !== null) {
                $model->price = $model->price * ( 1 - ($modelDis->percent / 100));
            }
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
