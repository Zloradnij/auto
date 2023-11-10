<?php

use app\modules\library\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ListView;
/** @var yii\web\View $this */
/** @var app\modules\library\models\search\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (!Yii::$app->user->isGuest) {
        ?>

        <p>
            <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
        </p><?php
    }
    ?>

    <?php Pjax::begin(); ?>
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView'     => '_book',
            'viewParams'   => [
                'fullView' => true,
            ],
            'layout' => "{pager}\n{items}\n{summary}",
            'options'      => [
                'tag'   => 'div',
                'class' => 'list-wrapper row',
                'id'    => 'list-wrapper',
            ],
            'itemOptions' => [
                'tag' => false,
            ],
        ]);
        ?>
    </div>

    <?php Pjax::end(); ?>

</div>
