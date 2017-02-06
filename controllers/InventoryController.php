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
use app\models\Sales;
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
                    'quantitybyproduct' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'view', 'delete', 'downloadinventorytemplate', 'uploadinventory', 'quantitybyproduct', 'downloadinventory', 'downloadsalestemplate', 'uploadsales'],
                'rules' => [
                    [
                        'allow' => Yii::$app->user->isGuest ? false : Yii::$app->user->identity->roleid == 1 ? true : false,
                        'actions' => ['index', 'create', 'update', 'view', 'delete', 'downloadinventorytemplate', 'uploadinventory', 'quantitybyproduct', 'downloadinventory', 'downloadsalestemplate', 'uploadsales'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionDownloadinventorytemplate(){
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Bocconcini Application")
                ->setLastModifiedBy("Bocconcini Application")
                ->setTitle("Bocconcini - Inventory")
                ->setSubject("Bocconcini - Inventory")
                ->setDescription("Bocconcini - Inventory");
        
        $inv = new Inventory();
        $data = $inv->getInventoryTemplate();
        $row = 1;
        
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->SetCellValue('A'.$row, 'Código Interno');
        $sheet->SetCellValue('B'.$row, 'Código Único');
        $sheet->SetCellValue('C'.$row, 'Nombre');
        $sheet->SetCellValue('D'.$row, 'Disponible');
        $sheet->SetCellValue('E'.$row, 'Precio Compra');
        $sheet->SetCellValue('F'.$row, 'Precio Venta');
        $sheet->SetCellValue('G'.$row, 'Observaciones');
        $sheet->getStyle("A$row:G$row")->getFont()->setBold(true);
        $row++;
        foreach($data as $model){
            
            $sheet->SetCellValue('A'.$row, $model['id']);
            $sheet->SetCellValue('B'.$row, $model['code']);
            $sheet->SetCellValue('C'.$row, $model['name']);
            $sheet->SetCellValue('D'.$row, $model['quantity']);
            $sheet->SetCellValue('E'.$row, $model['cost']);
            $sheet->SetCellValue('F'.$row, $model['price']);
            $sheet->SetCellValue('G'.$row, $model['observation']);
            $row++;
        }
        
        foreach(range('A','G') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $sheet->setTitle('Inventario');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Bocconcini Inventory Template.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
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
        $totals = $inv->getTotals();
        $row = 1;
        
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->SetCellValue('A'.$row, 'Código Interno');
        $sheet->SetCellValue('B'.$row, 'Código Único');
        $sheet->SetCellValue('C'.$row, 'Nombre');
        $sheet->SetCellValue('D'.$row, 'Disponible');
        $sheet->SetCellValue('E'.$row, 'Precio Compra');
        $sheet->SetCellValue('F'.$row, 'Precio de Compra Total');
        $sheet->SetCellValue('G'.$row, 'Precio Venta');
        $sheet->SetCellValue('H'.$row, 'Precio de Venta Total');
        $sheet->SetCellValue('I'.$row, 'Observaciones');
        $sheet->getStyle("A$row:I$row")->getFont()->setBold(true);
        $row++;
        foreach($data as $model){
            
            $sheet->SetCellValue('A'.$row, $model['id']);
            $sheet->SetCellValue('B'.$row, $model['code']);
            $sheet->SetCellValue('C'.$row, $model['name']);
            $sheet->SetCellValue('D'.$row, $model['quantity']);
            $sheet->SetCellValue('E'.$row, $model['cost']);
            $sheet->SetCellValue('F'.$row, $model['totalCost']);
            $sheet->SetCellValue('G'.$row, $model['price']);
            $sheet->SetCellValue('H'.$row, $model['totalPrice']);
            $sheet->SetCellValue('I'.$row, $model['observation']);
            $row++;
        }
        $sheet->SetCellValue('F'.$row, $totals['totalCost']);
        $sheet->SetCellValue('H'.$row, $totals['totalPrice']);
        $sheet->getStyle("D2:H$row")->getNumberFormat()->setFormatCode("#,##");
        foreach(range('A','I') as $columnID) {
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
                        $model->quantity = (int)$sheet->getCell('D'.$row)->getValue();
                        $model->observation = $sheet->getCell('G'.$row)->getValue();
                        $model->save();
                    }else{
                        $inv->productid = (int)$sheet->getCell('A'.$row)->getValue();
                        $inv->quantity = (int)$sheet->getCell('D'.$row)->getValue();
                        $inv->observation = $sheet->getCell('G'.$row)->getValue();
                        $inv->save();
                    }
                    $product = Product::findOne((int)$sheet->getCell('A'.$row)->getValue());
                    
                    if(!empty($product) && !is_null($product)){
                        $product->code = $sheet->getCell('B'.$row)->getValue();
                        $product->name = $sheet->getCell('C'.$row)->getValue();
                        $product->cost = (double)$sheet->getCell('E'.$row)->getValue();
                        $product->price = (double)$sheet->getCell('F'.$row)->getValue();
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
    
    public function actionDownloadsalestemplate(){
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Bocconcini Application")
                ->setLastModifiedBy("Bocconcini Application")
                ->setTitle("Bocconcini - Inventory")
                ->setSubject("Bocconcini - Inventory")
                ->setDescription("Bocconcini - Inventory");
        
        $inv = new Inventory();
        $data = $inv->getInventoryTemplate();
        $row = 1;
        
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->SetCellValue('A'.$row, 'Código Interno');
        $sheet->SetCellValue('B'.$row, 'Código Único');
        $sheet->SetCellValue('C'.$row, 'Nombre');
        $sheet->SetCellValue('D'.$row, 'Cantidad');
        $sheet->SetCellValue('E'.$row, 'Observaciones');
        $sheet->getStyle("A$row:E$row")->getFont()->setBold(true);
        $row++;
        foreach($data as $model){
            
            $sheet->SetCellValue('A'.$row, $model['id']);
            $sheet->SetCellValue('B'.$row, $model['code']);
            $sheet->SetCellValue('C'.$row, $model['name']);
            $sheet->SetCellValue('D'.$row, '0');
            $sheet->SetCellValue('E'.$row, '');
            $row++;
        }
        
        foreach(range('A','E') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $sheet->setTitle('Ventas');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Bocconcini Ventas Template.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    
    public function actionUploadsales(){
        $model = new Inventory();
        if ($model->load(Yii::$app->request->post())) {
             $model->excelFile = UploadedFile::getInstance($model, 'excelFile');
             if ($model->uploadSales()) {
                $objPHPExcel = \PHPExcel_IOFactory::load('./uploads/inventory/BocconciniSales.xlsx');
                $sheet =  $objPHPExcel->getActiveSheet();
                $endRows = $sheet->getHighestRow();
                for ($row = 2; $row < $endRows; $row++) {
                    $inv = new Inventory();
                    $model = $inv->findModelByProduct((int)$sheet->getCell('A'.$row)->getValue());
                    if(!empty($model) && !is_null($model)){
                        if( (int)$sheet->getCell('D'.$row)->getValue() > 0){
                            $model->quantity = $model->quantity - (int)$sheet->getCell('D'.$row)->getValue();
                            $model->save();

                            $sales = new Sales();
                            $sales->productid = $model->productid;
                            $sales->quantity = (int)$sheet->getCell('D'.$row)->getValue();
                            $sales->observation = (is_null($sheet->getCell('E'.$row)->getValue()) ? 'Ventas de otras fuentes' : $sheet->getCell('E'.$row)->getValue() );
                            $sales->save();
                        }
                    }
                    
                }
             }
            return $this->redirect(['index']);
        }else{
            return $this->render('upload_sales', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Lists all Inventory models.
     * @return mixed
     */
    public function actionIndex() {
        $model = new Inventory();
        $query = $model->listInventory();
        $totals = $model->getTotals();
        $totalPrice = $totals['totalPrice'];
        $totalCost = $totals['totalCost'];
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'totalPrice' => $totalPrice,
                    'totalCost' => $totalCost,
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
        $query = Inventory::find()
                ->joinWith(['product']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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
                        'dataProvider' => $dataProvider,
            ]);
        }
    }
    
    public function actionSet() {
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
            return $this->redirect(['product/view', 'id' => $model->productid]);
        } 
        return $this->redirect(['product/view', 'id' => $model->productid]);
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
    
    public function actionQuantitybyproduct(){
        $resp = new \stdClass();
        if(isset($_POST['productid']) && !empty($_POST['productid']) && !is_null($_POST['productid'])){
            $model = new Inventory();
            $aux = $model->findModelByProduct($_POST['productid']);
            $resp->error = false;
            if(!empty($aux) && !is_null($aux)){
                $resp->quantity = $aux->quantity;
                $resp->observation = $aux->observation;
            }else{
                $resp->quantity = 0;
                $resp->observation = '';
            }
            return json_encode($resp);
        }else{
            $resp->error = true;
            $resp->message = 'Se esperaba el parametro productid';
        }
        return json_encode($resp);
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
