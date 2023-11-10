<?php

namespace app\models;

use app\modules\alarm\models\SMSPilot;
use app\modules\library\models\Author;
use app\modules\library\models\Subscription;
use Yii;
use yii\base\Model;

/**
 * Class SubscriptionForm
 * @package app\models
 *
 * @property string $phone
 * @property int[] $authorIds
 */
class SubscriptionForm extends Model
{
    private const MESSAGE_OK = 'You\'re subscribe';

    private const MESSAGE_LOCK = 'You\'re already subscribe';

    private const MESSAGE_ERROR = 'Error subscribing';

    /**
     * @var string phone
     */
    public $phone;

    /**
     * @var int[] authorIds
     */
    public $authorIds;

    public function rules()
    {
        return [
            ['authorIds', 'required'],
            ['authorIds', 'safe'],
            ['phone', 'filter', 'filter' => function ($value) {
                return preg_replace("/[^0-9]/", '', $value);
            }],
        ];
    }

    public function subscribe()
    {
        if (!$this->validate()) {
            return null;
        }

        if (!Yii::$app->user->isGuest) {
            $subscriber = User::findOne(Yii::$app->user->getId());
            $this->phone = $subscriber->phone;
        }

        if (empty($this->phone)) {
            return null;
        }

        foreach ($this->authorIds as $authorId) {
            $subscribe = Subscription::find()
                ->where(['author_id' => $authorId, 'phone' => $this->phone])
                ->one();

            if ($subscribe) {
                return static::MESSAGE_LOCK;
            }

            $subscribe = new Subscription([
                'author_id' => $authorId,
                'phone'     => $this->phone,
            ]);

            if (!$subscribe->save()) {
                return static::MESSAGE_ERROR;
            }

            $author = Author::findOne($authorId);
            $sms = new SMSPilot();
            $sms->send($this->phone, "Вы подписались на {$author->fullName}");
        }

        return static::MESSAGE_OK;
    }
}
