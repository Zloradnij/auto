<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var app\modules\library\models\Book $model */

?>

<div class="book-item col-3" data-key="<?= $model->id; ?>">
    <a href="<?= Url::toRoute(['book/view', 'id' => $model->id]); ?>">
        <div class="forImage">
            <img src="/<?= $model->image?>" />
        </div>
        <div class="forTitle text-center">
            <?= $model->title?>
        </div>
        <div class="forAuthors text-center">
            <?= implode(', ', ArrayHelper::map($model->allAuthors, 'id', 'fullName')); ?>
        </div>
    </a>
</div>
