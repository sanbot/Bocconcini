<?php

namespace app\controllers;

use Yii;
use app\models\Productcommentary;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Product;
use app\models\Users;
use yii\filters\AccessControl;

/**
 * ProductcommentaryController implements the CRUD actions for Productcommentary model.
 */
class ProductcommentaryController extends Controller {

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
                'only' => ['index', 'create', 'update', 'view', 'delete', 'add', 'showcomments'],
                'rules' => [
                    [
                        'allow' => Yii::$app->user->isGuest ? false : Yii::$app->user->identity->roleid == 1 ? true : false,
                        'actions' => ['index', 'create', 'update', 'view', 'delete'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['add', 'showcomments'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['add', 'showcomments'],
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Productcommentary models.
     * @return mixed
     */
    public function actionIndex() {
        $query = Productcommentary::find()
                ->joinWith(['product', 'users']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Productcommentary model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionShowcomments($id) {
        $pc = new ProductCommentary();
        $model = $this->findModel($id);

        $comments = $pc->findComments($id);

        $producto = Product::find()->where('tblproduct.id = ' . $model->productid)->one();
        if($model->userid != null || $model->userid != ''){
            $user = Users::find()->where('tbluser.id = ' . $model->userid)->one();
        }else{
            $user = new \stdClass();
            $user->name = '';
        }
        

        $modelProductCommentary = new Productcommentary();

        return $this->render('showcomments', [
                    'model' => $model,
                    'comments' => $comments,
                    'product' => $producto,
                    'user' => $user,
                    'modelProductCommentary' => $modelProductCommentary,
        ]);
    }

    /**
     * Creates a new Productcommentary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Productcommentary();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $queryProduct = Product::find()->all();
            $queryUsers = Users::find()->all();
            return $this->render('create', [
                        'model' => $model,
                        'queryProduct' => $queryProduct,
                        'queryUsers' => $queryUsers,
            ]);
        }
    }

    public function actionAdd() {
        $model = new Productcommentary();

        if ($model->load(Yii::$app->request->post())) {

            $model->userid = (!Yii::$app->user->isGuest) ? Yii::$app->user->identity->id : null;
            $model->visible = 1;
            if ($model->save()) {
                if($model->parentcommentaryid != null){
                    return $this->redirect(['productcommentary/showcomments', 'id' => $model->parentcommentaryid]);
                }else{
                    return $this->redirect(['product/view', 'id' => $model->productid]);
                }
                
            }
        }
        return $this->redirect(['product/index']);
    }

    /**
     * Updates an existing Productcommentary model.
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
            $queryUsers = Users::find()->all();
            return $this->render('update', [
                        'model' => $model,
                        'queryProduct' => $queryProduct,
                        'queryUsers' => $queryUsers,
            ]);
        }
    }

    /**
     * Deletes an existing Productcommentary model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Productcommentary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Productcommentary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Productcommentary::find()->joinWith(['product', 'users'])->where('tblproductcommentary.id = ' . $id)->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
