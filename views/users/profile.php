<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\BaseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Bocconcini';
$PT = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="users-view">

    <h1><?= Html::encode($PT) ?></h1>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 bocconcini-profile">
            <div class="row">
                <div class="col-md-12"><h3 class="title-profile">Datos personales</h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            'name',
                            'username',
                            'email:email',
                            //'password',
                            'role.name',
                        ],
                        'template' => '<div class="row"><div class="col-md-3"><p class="item-label"><b>{label}</b></p></div><div class="col-md-9"><p class="item-value">{value}</p></div></div>',
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"><?= Html::a('Modificar', ['updateprofile'], ['class' => 'btn btn-primary btn-block']) ?></div>
            </div>
        
            <div class="row">
                <div class="col-md-12"><h3 class="title-profile">Direcciones</h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= GridView::widget([
                        'dataProvider' => $dataProviderAddress,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            //'users.name',
                            'alias',
                            'municipality.name',
                            'district',
                            'address',
                            // 'commentary',


                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header'=>'Acciones',
                                'template'=>'{view}{update}{delete}',
                                'urlCreator' => function ($action, $model, $key, $index) {
                                    if($action == 'delete'){
                                        $action = 'removefromprofile';
                                    }else{
                                        $action = 'updatefromprofile';
                                    }
                                    $url = BaseUrl::base().'/index.php?r=useraddress/'.$action.'&id='.$model->id;
                                    return $url;
                                }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"><?= Html::a('Agregar Dirección', ['useraddress/addtoprofile'], ['class' => 'btn btn-primary btn-block']) ?></div>
            </div>
            
            <div class="row">
                <div class="col-md-12"><h3 class="title-profile">Pedidos</h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                </div>
            </div>
        </div>
    </div>

</div>
