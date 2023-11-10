<?php

namespace app\models;

use yii\web\IdentityInterface;
use yii2mod\user\models\UserModel;

/**
 * Class User
 * @package app\models
 *
 * @property string $phone
 */
class User extends UserModel implements IdentityInterface
{
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                ['phone', 'unique', 'message' => 'Такой нумер уже есть в читалке'],
                [['phone'], 'required'],
                ['phone', 'string', 'length' => [7, 16]],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [['phone' => 'Нумер']]);
    }
}
