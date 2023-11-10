<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\library\models\Book $model */
/** @var app\modules\library\models\Subscription $subscriptionFormModel */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (!Yii::$app->user->isGuest) {
        ?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(
                'Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data'  => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method'  => 'post',
                ],
            ]
            ) ?>
        </p><?php
    }?>

    <div class="row">
        <div class="col-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title',
                    'release',
                    'description:ntext',
                    'isbn',
                    [
                        'label' => 'status',
                        'value' => $model->status == Yii::$app->params['statusActive'] ? 'Активный' : 'Отключен',
                    ],
                    [
                        'label' => 'created_at',
                        'value' => (new \DateTime())->setTimestamp($model->created_at)->format('Y-m-d'),
                    ],
                    [
                        'label' => 'updated_at',
                        'value' => (new \DateTime())->setTimestamp($model->updated_at)->format('Y-m-d'),
                    ],
                    [
                        'label'     => 'authors',
                        'attribute' => 'allAuthors',
                        'format'    => 'raw',
                        'value'     => function ($data) {
                            $str = '';

                            foreach ($data->allAuthors ?? [] as $author) {
                                $str .= $author->fullName . '<br />';
                            }

                            return $str;
                        },
                    ],
                ],
            ]) ?>
        </div>
        <div class="col-6">
            <img src="/<?= $model->image?>" />
        </div>
    </div>
    <div class="row">
        <div class="col-6">
        </div>
        <div class="col-6">
            <h5><?= \Yii::$app->session->getFlash(\Yii::$app->params['subscribeKey']);?></h5>

            <?php $form = ActiveForm::begin([
                'action' => Url::toRoute(['/library/book/subscribe', 'id' => $model->id])
            ]); ?>

            <?php
            if (\Yii::$app->user->isGuest) {
                print $form
                    ->field($subscriptionFormModel, 'phone')
                    ->textInput(['placeholder' => "+7-999-111-22-33"]);
            }
            ?>

            <?php
            foreach ($model->allAuthors ?? [] as $author) {
                print $form
                    ->field($subscriptionFormModel, 'authorIds[]', ["template" => "{input}\n{hint}\n{error}"])
                    ->hiddenInput(['value' => $author->id]);
            }?>

            <div class="form-group">
                <?= Html::submitButton('Subscribe to author', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
