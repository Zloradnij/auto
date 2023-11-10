<?php

use yii\db\Migration;

/**
 * Class m231110_143921_books_init
 */
class m231110_143921_books_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id'            => $this->primaryKey(),
            'username'      => $this->string(50)->unique()->notNull(),
            'email'         => $this->string(255)->unique()->notNull(),
            'password_hash' => $this->string(60)->notNull(),
            'phone'         => $this->string(16)->unique()->notNull(),
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%book}}', [
            'id'           => $this->primaryKey(),
            'title'        => $this->string(255)->notNull(),
            'release'      => $this->integer()->notNull(),
            'description'  => $this->text(),
            'isbn'         => $this->string(13)->notNull(),
            'image'        => $this->string(100),
            'status'       => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at'   => $this->integer()->notNull(),
            'updated_at'   => $this->integer()->notNull(),
            'created_user' => $this->integer()->notNull(),
            'updated_user' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%author}}', [
            'id'           => $this->primaryKey(),
            'name'         => $this->string(255)->notNull(),
            'surname'      => $this->string(255)->notNull(),
            'patronymic'   => $this->string(),
            'status'       => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at'   => $this->integer()->notNull(),
            'updated_at'   => $this->integer()->notNull(),
            'created_user' => $this->integer()->notNull(),
            'updated_user' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%book_author}}', [
            'id'           => $this->primaryKey(),
            'book_id'      => $this->integer()->notNull(),
            'author_id'    => $this->integer()->notNull(),
            'created_at'   => $this->integer()->notNull(),
            'updated_at'   => $this->integer()->notNull(),
            'created_user' => $this->integer()->notNull(),
            'updated_user' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%subscription}}', [
            'id'           => $this->primaryKey(),
            'user_id'      => $this->integer()->notNull(),
            'author_id'    => $this->integer()->notNull(),
            'created_at'   => $this->integer()->notNull(),
            'updated_at'   => $this->integer()->notNull(),
            'created_user' => $this->integer()->notNull(),
            'updated_user' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%book}}');
        $this->dropTable('{{%author}}');
        $this->dropTable('{{%book_author}}');
        $this->dropTable('{{%subscription}}');
    }
}
