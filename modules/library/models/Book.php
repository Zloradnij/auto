<?php

namespace app\modules\library\models;


use app\modules\queue\models\NewBook;
use Biblys\Isbn\Formatter;
use Biblys\Isbn\IsbnParsingException;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title
 * @property int $release
 * @property string|null $description
 * @property string $isbn
 * @property string|null $image
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_user
 * @property int $updated_user
 *
 * @property UploadedFile $picture
 * @property array $authors
 */
class Book extends Library
{
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public $picture;
    public $authors;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['isbn', 'filter', 'filter' => function ($value) {
                /**
                 * Faker\Calculator\Isbn вроде только 10-изначные коды проверять умеет,
                 * поэтому сторонний прикрутил, хоть и не особо удобный он
                */
                try {
                    $value = preg_replace("/[^0-9]/", '', $value);
                    $expected = Formatter::formatAsIsbn13($value);
                    $expectedOnlyNumbers = preg_replace("/[^0-9]/", '', $expected);

                    if ($expectedOnlyNumbers == $value) {
                        return $expectedOnlyNumbers;
                    }

                    $expected = Formatter::formatAsIsbn10($value);
                    $expectedOnlyNumbers = preg_replace("/[^0-9]/", '', $expected);

                    return $expectedOnlyNumbers == $value ? $expectedOnlyNumbers : null;
                } catch (IsbnParsingException $e) {
                    return null;
                }
            }],
            ['isbn', 'required', 'message' => 'isbn is empty or invalid format'],
            [['title', 'release', 'authors'], 'required'],
            [['release', 'status', 'created_at', 'updated_at', 'created_user', 'updated_user'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 13],
            [['image'], 'string', 'max' => 100],
            ['picture', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            ['authors', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'title'        => 'Title',
            'release'      => 'Release',
            'description'  => 'Description',
            'isbn'         => 'Isbn',
            'image'        => 'Image',
            'status'       => 'Status',
            'created_at'   => 'Created At',
            'updated_at'   => 'Updated At',
            'created_user' => 'Created User',
            'updated_user' => 'Updated User',
            'picture'      => 'Image',
            'authors'      => 'Authors',
        ];
    }

    public function getAllAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('book_author', ['book_id' => 'id']);
    }

    public function upload()
    {
        if (!$this->validate()) {
            return false;
        }

        if (!empty($this->image)) {
            unlink("{$_SERVER['DOCUMENT_ROOT']}/{$this->image}");
        }

        $fileName = Yii::$app->security->generateRandomString();
        $folder = substr($fileName, 0, 2);
        $subFolder = substr($fileName, 2, 2);

        if (!file_exists("{$_SERVER['DOCUMENT_ROOT']}/uploads/{$folder}/{$subFolder}/")) {
            mkdir("{$_SERVER['DOCUMENT_ROOT']}/uploads/{$folder}/{$subFolder}/", 0755, true);
        }

        $this->image = "uploads/{$folder}/{$subFolder}/{$fileName}.{$this->picture->extension}";
        $this->picture->saveAs($this->image);
        $this->picture = null;

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        BookAuthor::deleteAll(['book_id' => $this->id]);

        foreach ($this->authors as $authorId) {
            (new BookAuthor(['book_id' => $this->id, 'author_id' => $authorId]))->save();
        }

        if ($insert) {
            Yii::$app->queue->push(
                new NewBook([
                    'bookId' => $this->id,
                ])
            );
        }
    }
}
