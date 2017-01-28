<?php

namespace app\controllers;

use Yii;
use app\models\Productcategory;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * ProductcategoryController implements the CRUD actions for Productcategory model.
 */
class ProductcategoryController extends Controller {

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
                        'actions' => ['index', 'create', 'update', 'view', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Productcategory models.
     * @return mixed
     */
    public function actionIndex() {
        $query = new Productcategory();
        $dataProvider = new ActiveDataProvider([
            'query' => $query->listCategories(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Productcategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Productcategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Productcategory();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if(isset($model->imageFile->extension)){$model->imagen = $model->URLImage();}
            if($model->save()){
                if(isset($model->imageFile->extension)){$model->upload($model->id);}
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $queryCategory = Productcategory::find()->all();
                return $this->render('create', [
                    'model' => $model,
                    'queryCategory' => $queryCategory,
                ]); 
            }
        } else {
            $queryCategory = Productcategory::find()->all();
            return $this->render('create', [
                'model' => $model,
                'queryCategory' => $queryCategory,
            ]);
        }
    }

    /**
     * Updates an existing Productcategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if(isset($model->extension)){$model->extension = $model->URLImage();}
            if($model->save()){
                if(isset($model->extension)){$model->upload($model->id);}
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $queryCategory = Productcategory::find()->all();
                return $this->render('create', [
                    'model' => $model,
                    'queryCategory' => $queryCategory,
                ]); 
            }
        } else {
            $queryCategory = Productcategory::find()->all();
            return $this->render('update', [
                'model' => $model,
                'queryCategory' => $queryCategory,
            ]);
        }
    }

    /**
     * Deletes an existing Productcategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Productcategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Productcategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        $pc = new Productcategory();
        if (($model = $pc->findModel($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
