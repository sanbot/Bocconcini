<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = 'Bocconcini | Admin';
$PT = 'Crear';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="role-create">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
