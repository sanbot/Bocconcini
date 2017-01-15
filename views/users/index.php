<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\BaseUrl;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Usuarios';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="users-index">

    <h1><?= Html::encode($PT) ?></h1>

    <div class="row">
        <div class="users-form">
            <?php $form = ActiveForm::begin(['action' => BaseUrl::base().'/index.php?r=users']); ?>
                <div class="col-md-8">
                    <?= $form->field($model, 'name')->textInput()->label('Buscar') ?>
                </div>
                <div class="col-md-2">
                    <br>
                    <div class="form-group">
                        <?= Html::submitButton('Search', ['class' => 'btn btn-primary btn-block']) ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <p>
        <?= Html::a('Crear Usuario', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'username',
            'email:email',
            //'password',
            'role.name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
