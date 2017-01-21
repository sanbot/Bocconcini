<?php

namespace app\controllers;

use Yii;
use app\models\Useraddress;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Municipality;
use app\models\Users;
use yii\filters\AccessControl;

/**
 * UseraddressController implements the CRUD actions for Useraddress model.
 */
class UseraddressController extends Controller {

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
                'only' => ['index', 'create', 'update', 'view', 'delete', 'addtoprofile', 'updatefromprofile', 'removefromprofile'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'view', 'delete', 'addtoprofile', 'updatefromprofile', 'removefromprofile'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Useraddress models.
     * @return mixed
     */
    public function actionIndex() {
        $query = Useraddress::find()
                ->joinWith(['municipality','users']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Useraddress model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Useraddress model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Useraddress();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $queryMunicipality = Municipality::find()->all();
            $queryUser = Users::find()->all();
            return $this->render('create', [
                        'model' => $model,
                        'queryMunicipality' => $queryMunicipality,
                        'queryUser' => $queryUser,
            ]);
        }
    }
    
    public function actionAddtoprofile() {
        $model = new Useraddress();
        $model->userid = Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['users/profile']);
        } else {
            $queryMunicipality = Municipality::find()->all();
            return $this->render('profile', [
                        'model' => $model,
                        'queryMunicipality' => $queryMunicipality,
            ]);
        }
    }

    /**
     * Updates an existing Useraddress model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $queryMunicipality = Municipality::find()->all();
            $queryUser = Users::find()->all();
            return $this->render('update', [
                        'model' => $model,
                        'queryMunicipality' => $queryMunicipality,
                        'queryUser' => $queryUser,
            ]);
        }
    }
    
    public function actionUpdatefromprofile($id) {
        $model = $this->findModel($id);
        if($model->userid == Yii::$app->user->identity->id){

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['users/profile']);
            } else {
                $queryMunicipality = Municipality::find()->all();
                return $this->render('profile', [
                            'model' => $model,
                            'queryMunicipality' => $queryMunicipality,
                ]);
            }
        }else{
            return $this->redirect(['users/profile']);
        }
    }

    /**
     * Deletes an existing Useraddress model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionRemovefromprofile($id) {
        if($this->findModel($id)->userid == Yii::$app->user->identity->id){
            $this->findModel($id)->delete();
        }
        return $this->redirect(['users/profile']);
    }

    /**
     * Finds the Useraddress model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Useraddress the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Useraddress::find()->joinWith(['municipality','users'])->where('tbluseraddress.id = '.$id)->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
