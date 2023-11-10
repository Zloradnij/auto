<?php

use yii\db\Migration;

/**
 * Class m231110_181324_subscription_update
 */
class m231110_181324_subscription_update extends Migration
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

        $this->dropTable('{{%subscription}}');

        $this->createTable('{{%subscription}}', [
            'id'           => $this->primaryKey(),
            'phone'        => $this->string(16)->notNull(),
            'author_id'    => $this->integer()->notNull(),
            'created_at'   => $this->integer()->notNull(),
            'updated_at'   => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subscription}}');
    }
}
