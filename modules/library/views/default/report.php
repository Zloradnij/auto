<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\library\models\Author $authors */
/** @var int $year */

$this->title = 'Most fertile authors';
$this->params['breadcrumbs'][] = 'Report - ' . $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="book-search">

        <?php $form = ActiveForm::begin([
            'action' => ['report'],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]); ?>

        <div class="row">
            <div class="col-3">
                <div class="form-group field-booksearch-title">
                    <label class="control-label" for="booksearch-title">Title</label>
                    <input type="text" id="year" class="form-control" name="year" value="<?= $year?>">

                    <div class="help-block"></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="row">
        <div class="row">
            <div class="col-7">Author name</div>
            <div class="col-5">Books count</div>
        </div>
        <?php
        foreach ($authors as $author) {?>
            <div class="row">
                <div class="col-7"><?= $author->fullName?></div>
                <div class="col-5"><?= $author->countBook?></div>
            </div><?php
        }
        ?>
    </div>
</div>
