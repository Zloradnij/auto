<?php

namespace app\modules\library\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

abstract class Library extends ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class'              => BlameableBehavior::class,
                'createdByAttribute' => 'created_user',
                'updatedByAttribute' => 'updated_user',
            ],
        ];
    }
}
