<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Bocconcini';
$PT = 'Modificar ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->name];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="users-update">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_formprofile', [
        'model' => $model,
    ]) ?>

</div>
