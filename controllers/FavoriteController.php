<?php

namespace app\controllers;

use Yii;
use app\models\Favorite;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\BaseUrl;
use app\models\Product;

/**
 * FavoriteController implements the CRUD actions for Favorite model.
 */
class FavoriteController extends Controller {

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
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete', 'view', 'add', 'remove'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Favorite models.
     * @return mixed
     */
    public function actionIndex() {
        $action = 'favorite';
        $model = new Product();
        $model->load(Yii::$app->request->post());
        $products = $model->listFavotiteProduct(Yii::$app->user->identity->id, $model->description);

        return $this->render('index', [
                    'products' => $products,
                    'action' => $action,
                    'model' => $model,
        ]);
    }

    /**
     * Displays a single Favorite model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Favorite model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Favorite();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionAdd($productid) {
        $modelFavorite = new Favorite();
        $modelFavorite->userid = Yii::$app->user->identity->id;
        $modelFavorite->productid = $productid;
        
        if ($modelFavorite->findFavorite($modelFavorite->userid, $modelFavorite->productid) == null) {
            if ($modelFavorite->save()) {
                Yii::$app->session->setFlash('success_favorite', 'Se agregó el producto a favoritos.');
                 
            } else {
                Yii::$app->session->setFlash('error_favorite', 'No se logró agregar el producto a favoritos.');
            }
        } else {
            Yii::$app->session->setFlash('success_favorite', 'Ya se encuentra agregado a favoritos.');
        }
        
        $action = 'favorite';
        $model = new Product();
        $model->load(Yii::$app->request->post());
        $products = $model->listFavotiteProduct(Yii::$app->user->identity->id, $model->description);
        
        return $this->render('index', [
                    'products' => $products,
                    'action' => $action,
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Favorite model.
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
     * Deletes an existing Favorite model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionRemove($productid) {
        $model = new Favorite();
        $id = $model->findId(Yii::$app->user->identity->id, $productid);
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success_favorite', 'Se removió el producto de favoritos.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Favorite model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Favorite the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Favorite::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
