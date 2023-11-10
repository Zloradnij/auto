<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends \yii2mod\user\models\LoginForm
{
    /**
     * @var string phone
     */
    public $phone;

    public function rules()
    {
        return
            parent::rules() +
            [
                [['phone'], 'required'],
                ['phone', 'string', 'length' => [7, 16]],
                ['phone', 'filter', 'filter' => function ($value) {
                    return preg_replace('\D', '', $value);
                }],
            ];
    }
}
