<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\library\models\search\BookSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-3">
            <?= $form->field($model, 'title') ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'release') ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'isbn') ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
