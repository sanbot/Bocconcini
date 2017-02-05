<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use kartik\select2\Select2; // or kartik\select2\Select2
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Inventory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <!--<?= $form->field($model, 'productid')->dropDownList(ArrayHelper::map($queryProduct, 'id', 'name')) ?>-->
                <?= $form->field($model, 'productid')->widget(Select2::classname(), [
                    'initValueText' => '', // set the initial display text
                    'options' => ['placeholder' => 'Buscar un  producto...'],
                    'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'No se encontraron resultados...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['product/productlist']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(product) { return product.text; }'),
                    'templateSelection' => new JsExpression('function (product) { return product.text; }'),
                ],
                ]);?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'quantity')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?= $form->field($model, 'observation')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div classs="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Modificar', ['class' => 'btn btn-block btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    var URL_INVENTORY_QUANTITY = '<?= Url::to(['quantitybyproduct'])?>';
</script>
