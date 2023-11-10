<?php

use app\modules\library\models\Author;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\library\models\Book $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'release')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'picture')->fileInput() ?>

    <?= $form->field($model, 'authors')->dropDownList(
        ArrayHelper::map(Author::find()->active()->all(), 'id', 'fullName'),
        ['multiple' => true]
    ) ?>

    <?= $form->field($model, 'status')->dropDownList(
        [
            Yii::$app->params['statusActive']   => 'Активный',
            Yii::$app->params['statusDisabled'] => 'Отключен',
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
