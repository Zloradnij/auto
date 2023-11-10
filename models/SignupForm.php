<?php

namespace app\models;


/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class SignupForm extends \yii2mod\user\models\SignupForm
{
    /**
     * @var string phone
     */
    public $phone;

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                ['phone', 'required'],
                ['phone', 'trim'],
                ['phone', 'string', 'length' => [7, 16]],
                ['phone', 'filter', 'filter' => function ($value) {
                    return preg_replace("/[^0-9]/", '', $value);
                }],
            ]
        );
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->user = new User();
        $this->user->setAttributes($this->attributes);
        $this->user->setPassword($this->password);
        $this->user->setLastLogin(time());
        $this->user->generateAuthKey();

        return $this->user->save() ? $this->user : null;
    }
}
