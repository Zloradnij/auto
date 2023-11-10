<?php

namespace app\modules\library\models\query;

use app\modules\library\models\Book;
use app\modules\library\models\BookAuthor;

/**
 * This is the ActiveQuery class for [[\app\modules\library\models\Author]].
 *
 * @see \app\modules\library\models\Author
 */
class AuthorQuery extends \yii\db\ActiveQuery
{
    public function top(int $year)
    {
        return $this
            ->select(['author.*', 'COUNT(book_author.book_id) AS countBook'])
            ->join('LEFT JOIN', BookAuthor::tableName(), 'book_author.author_id = author.id')
            ->join('LEFT JOIN', Book::tableName(), 'book_author.book_id = book.id')
            ->groupBy('author.id')
            ->orderBy(['countBook' => SORT_DESC])
            ->andWhere(['book.release' => $year]);
    }

    public function active()
    {
        return $this->andWhere(['author.status' => \Yii::$app->params['statusActive']]);
    }

    /**
     * @inheritdoc
     * @return \app\modules\library\models\Author[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\library\models\Author|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
