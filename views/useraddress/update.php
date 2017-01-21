<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Useraddress */

$this->title = 'Bocconcini | Admin ';
$PT = 'Modificar ' . $model->alias;
$this->params['breadcrumbs'][] = ['label' => 'Direcciones de usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="useraddress-update">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'queryMunicipality' => $queryMunicipality,
        'queryUser' => $queryUser,
    ]) ?>

</div>
