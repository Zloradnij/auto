<?php

namespace app\modules\library\models;


/**
 * This is the model class for table "book_author".
 *
 * @property int $id
 * @property int $book_id
 * @property int $author_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_user
 * @property int $updated_user
 */
class BookAuthor extends Library
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'author_id'], 'required'],
            [['book_id', 'author_id', 'created_at', 'updated_at', 'created_user', 'updated_user'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'book_id'      => 'Book ID',
            'author_id'    => 'Author ID',
            'created_at'   => 'Created At',
            'updated_at'   => 'Updated At',
            'created_user' => 'Created User',
            'updated_user' => 'Updated User',
        ];
    }
}
