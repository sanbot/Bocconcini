<?php

namespace app\controllers;

use Yii;
use app\models\Inventory;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Product;
use yii\web\UploadedFile;

/**
 * InventoryController implements the CRUD actions for Inventory model.
 */
class InventoryController extends Controller {

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
                'only' => ['index', 'create', 'update', 'view', 'delete', 'downloadinventory', 'uploadinventory'],
                'rules' => [
                    [
                        'allow' => Yii::$app->user->isGuest ? false : Yii::$app->user->identity->roleid == 1 ? true : false,
                        'actions' => ['index', 'create', 'update', 'view', 'delete', 'downloadinventory', 'uploadinventory'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionDownloadinventory(){
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Bocconcini Application")
                ->setLastModifiedBy("Bocconcini Application")
                ->setTitle("Bocconcini - Inventory")
                ->setSubject("Bocconcini - Inventory")
                ->setDescription("Bocconcini - Inventory");
        
        $inv = new Inventory();
        $data = $inv->getInventory();
        $row = 1;
        
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->SetCellValue('A'.$row, 'Código');
        $sheet->SetCellValue('B'.$row, 'Nombre');
        $sheet->SetCellValue('C'.$row, 'Disponible');
        $sheet->SetCellValue('D'.$row, 'Precio Compra');
        $sheet->SetCellValue('E'.$row, 'Precio Venta');
        $sheet->SetCellValue('F'.$row, 'Observaciones');
        $row++;
        foreach($data as $model){
            
            $sheet->SetCellValue('A'.$row, $model['id']);
            $sheet->SetCellValue('B'.$row, $model['name']);
            $sheet->SetCellValue('C'.$row, $model['quantity']);
            $sheet->SetCellValue('D'.$row, $model['cost']);
            $sheet->SetCellValue('E'.$row, $model['price']);
            $sheet->SetCellValue('F'.$row, $model['observation']);
            $row++;
        }
        
        foreach(range('A','F') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $sheet->setTitle('Inventario');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Bocconcini Inventory.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    
    public function actionUploadinventory(){
        $model = new Inventory();
        if ($model->load(Yii::$app->request->post())) {
             $model->excelFile = UploadedFile::getInstance($model, 'excelFile');
             if ($model->upload()) {
                $objPHPExcel = \PHPExcel_IOFactory::load('./uploads/inventory/BocconciniInventory.xlsx');
                $sheet =  $objPHPExcel->getActiveSheet();
                $endRows = $sheet->getHighestRow();
                for ($row = 2; $row < $endRows; $row++) {
                    $inv = new Inventory();
                    $model = $inv->findModelByProduct((int)$sheet->getCell('A'.$row)->getValue());
                    if(!empty($model) && !is_null($model)){
                        $model->quantity = (int)$sheet->getCell('C'.$row)->getValue();
                        $model->observation = $sheet->getCell('F'.$row)->getValue();
                        $model->save();
                    }else{
                        $inv->productid = (int)$sheet->getCell('A'.$row)->getValue();
                        $inv->quantity = (int)$sheet->getCell('C'.$row)->getValue();
                        $inv->observation = $sheet->getCell('F'.$row)->getValue();
                        $inv->save();
                    }
                    $product = Product::findOne((int)$sheet->getCell('A'.$row)->getValue());
                    
                    if(!empty($product) && !is_null($product)){
                        $product->name = $sheet->getCell('B'.$row)->getValue();
                        $product->cost = (double)$sheet->getCell('D'.$row)->getValue();
                        $product->price = (double)$sheet->getCell('E'.$row)->getValue();
                        $product->save();
                    }
                    
                }
             }
            return $this->redirect(['index']);
        }else{
            return $this->render('upload', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Lists all Inventory models.
     * @return mixed
     */
    public function actionIndex() {
        $query = Inventory::find()
                ->joinWith(['product']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Inventory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Inventory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Inventory();

        if ($model->load(Yii::$app->request->post())) {
            $aux = $model->findModelByProduct($model->productid);
            if(empty($aux) || is_null($aux)){
                $model->save();
            }else{
                $aux->quantity = $model->quantity;
                $aux->observation = $model->observation;
                $model->id = $aux->id;
                $aux->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $queryProduct = Product::find()->all();
            return $this->render('create', [
                        'model' => $model,
                        'queryProduct' => $queryProduct,
            ]);
        }
    }

    /**
     * Updates an existing Inventory model.
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
            return $this->render('update', [
                        'model' => $model,
                        'queryProduct' => $queryProduct,
            ]);
        }
    }

    /**
     * Deletes an existing Inventory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->quantity = 0;
        $model->observation = '';
        $model->save();
        return $this->redirect(['view', 'id'=>$model->id]);
    }

    /**
     * Finds the Inventory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Inventory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        $inv = new Inventory();
        $model = $inv->findModelInventory($id);
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
