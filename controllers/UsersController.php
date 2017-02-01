<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Role;
use app\models\LoginForm;
use app\models\Useraddress;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller {

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
                'only' => ['index', 'create', 'update', 'view', 'delete', 'profile', 'updateprofile', 'changepassword'],
                'rules' => [
                    [
                        'allow' => Yii::$app->user->isGuest ? false : Yii::$app->user->identity->roleid == 1 ? true : false,
                        'actions' => ['index', 'create', 'update', 'view', 'delete'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['profile', 'updateprofile', 'changepassword'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['singup'],
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex() {

        $model = new Users();
        $query = Users::find()
                ->joinWith('role');

        if ($model->load(Yii::$app->request->post())) {
            $query->where('tbluser.name like \'%' . $model->name . '%\'');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    public function actionProfile() {
        $id = Yii::$app->user->identity->id;
        $queryAddress = Useraddress::find()
                ->joinWith(['municipality'])
                ->where('tbluseraddress.userid = '.$id);
        $dataProviderAddress = new ActiveDataProvider([
            'query' => $queryAddress,
        ]);
        
        $model = $this->findModel($id);
        $model->password = '';
        return $this->render('profile', [
                    'model' => $model,
            'dataProviderAddress' => $dataProviderAddress,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Users();
        $queryRole = Role::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->password = md5($model->password);
            $model->password_repeat = md5($model->password_repeat);
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                            'queryRole' => $queryRole,
                ]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'queryRole' => $queryRole,
            ]);
        }
    }

    public function actionSingup() {
        $model = new Users();

        if ($model->load(Yii::$app->request->post())) {
            $model->roleid = 2;
            $password = $model->password;
            $model->password = md5($model->password);
            $model->password_repeat = md5($model->password_repeat);
            if ($model->save()) {
                $modelLogin = new LoginForm();
                $modelLogin->username = $model->username;
                $modelLogin->password = $password;
                $modelLogin->login();
                return $this->redirect(['site/index']);
            } else {
                $model->password = '';
                $model->password_repeat = '';
                return $this->render('singup', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->render('singup', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $queryRole = Role::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->password = md5($model->password);
            $model->password_repeat = md5($model->password_repeat);
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $model->password = '';
                return $this->render('update', [
                            'model' => $model,
                            'queryRole' => $queryRole,
                ]);
            }
        } else {
            $model->password = '';
            return $this->render('update', [
                        'model' => $model,
                        'queryRole' => $queryRole,
            ]);
        }
    }

    public function actionUpdateprofile() {
        $model = $this->findModel(Yii::$app->user->identity->id);
        $queryRole = Role::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->password = md5($model->password);
            $model->password_repeat = md5($model->password_repeat);
            if ($model->save()) {
                return $this->redirect(['profile', 'id' => $model->id]);
            } else {
                $model->password = '';
                return $this->render('updateprofile', [
                            'model' => $model,
                            'queryRole' => $queryRole,
                ]);
            }
        } else {
            $model->password = '';
            return $this->render('updateprofile', [
                        'model' => $model,
                        'queryRole' => $queryRole,
            ]);
        }
    }
    
    public function actionChangepassword() {
        $model = $this->findModel(Yii::$app->user->identity->id);

        if ($model->load(Yii::$app->request->post())) {
            $model->password = md5($model->password);
            $model->password_repeat = md5($model->password_repeat);
            if ($model->save()) {
                Yii::$app->session->setFlash('change_password', 'Se logró cambiar la contraseña.');
                return $this->redirect(['profile', 'id' => $model->id]);
            } else {
                $model->password = '';
                return $this->render('updateprofile', [
                            'model' => $model,
                ]);
            }
        } else {
            $model->password = '';
            return $this->render('updateprofile', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Users::find()->joinWith(['role'])->where('tbluser.id = ' . $id)->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
