<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\Productcommentary */

$this->title = 'Bocconcini';
$PT = $product->name;
$this->params['breadcrumbs'][] = ['label' => 'Comentarios'];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="productcommentary-view">


    <div class="row">
        <div class="col-md-10 col-md-offset-1 bocconcini-profile">
            <div class="row">
                <div class="col-md-12"><h3 class="title-profile">Producto: <?= Html::encode($product->name) ?></h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php $form = ActiveForm::begin(['action' => BaseUrl::base().'/index.php?r=productcommentary/add']); ?>
                    <div class="row">
                        <div class="col-md-8">
                            <?= $form->field($modelProductCommentary, 'commentary')->textarea(['maxlength' => true, 'row' => 7]) ?>
                        </div>
                        <div class="hidden">
                            <?= $form->field($modelProductCommentary, 'productid')->input('text', ['value' => $product->id]) ?>
                            <?= $form->field($modelProductCommentary, 'parentcommentaryid')->input('text', ['value' => $model->id]) ?>
                        </div>
                        <div class="col-md-4">
                            <label></label>
                            <div class="form-group">
                                <?= Html::submitButton('Comentar', ['class' => 'btn btn-block btn-primary']) ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="thumbnail">
                                <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                            </div><!-- /thumbnail -->
                        </div><!-- /col-sm-1 -->

                        <div class="col-md-10">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <strong><?= $user->name; ?></strong> <span class="text-muted">commented <?= $model->date ?></span>
                                </div>
                                <div class="panel-body">
                                    <?= $model->commentary ?>
                                </div><!-- /panel-body -->
                            </div><!-- /panel panel-default -->
                        </div><!-- /col-sm-5 -->
                    </div><!-- /row -->
                    <?php foreach ($comments as $comment) { ?>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="thumbnail">
                                    <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                                </div><!-- /thumbnail -->
                            </div><!-- /col-sm-1 -->

                            <div class="col-md-10">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <strong><?= $comment['usuario'] ?></strong> <span class="text-muted">commented <?= $comment['date'] ?></span>
                                    </div>
                                    <div class="panel-body">
                                        <?= $comment['commentary'] ?>
                                    </div><!-- /panel-body -->
                                </div><!-- /panel panel-default -->
                            </div><!-- /col-sm-5 -->
                        </div><!-- /row -->
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

</div>
