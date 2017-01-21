<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Useraddress */

$this->title = 'Bocconcini | Admin';
$PT = 'Crear';
$this->params['breadcrumbs'][] = ['label' => 'Direcciones de usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="useraddress-create">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'queryMunicipality' => $queryMunicipality,
        'queryUser' => $queryUser,
    ]) ?>

</div>
