<?php

namespace app\modules\queue\models;

use app\modules\alarm\models\SMSPilot;
use app\modules\library\models\Author;
use app\modules\library\models\Book;
use app\modules\library\models\BookAuthor;
use app\modules\library\models\Subscription;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class NewBook extends BaseObject implements JobInterface
{
    protected const BATCH_SIZE = 10;

    public $bookId;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function execute($queue)
    {
        $sms = new SMSPilot();

        $book = Book::findOne($this->bookId);

        $authors = Author::find()
            ->select('author.*')
            ->join('LEFT JOIN', BookAuthor::tableName(), 'book_author.author_id = author.id')
            ->where(['book_id' => $this->bookId])
            ->all();

        foreach ($authors as $author) {
            $this->sendMessage($sms, $author, $book);
        }
    }

    private function sendMessage(SMSPilot $sms, Author $author, Book $book)
    {
        $message = "У {$author->fullName} новая книга - {$book->title}";

        foreach (Subscription::find()->where(['author_id' => $author->id])->batch(self::BATCH_SIZE) as $subscribers) {
            /** @var Subscription $subscriber */
            foreach ($subscribers as $subscriber) {
                $sms->send($subscriber->phone, $message);
            }
        }
    }
}
