<?php

namespace app\models;

class SignupAction extends \yii2mod\user\actions\SignupAction
{
    /**
     * @var string name of the view, which should be rendered
     */
    public $view = 'signup';

    /**
     * @var string signup form class
     */
    public $modelClass = 'app\models\SignupForm';
}
