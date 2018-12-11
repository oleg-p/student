<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181211_090941_create_table_auth
 */
class m181211_090941_create_table_auth extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('auth', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),

            'created_at' => Schema::TYPE_DATETIME . " COMMENT 'Дата создания'",
            'updated_at' => Schema::TYPE_DATETIME . " COMMENT 'Дата обновления'",
        ]);

        $this->addForeignKey('fk-auth-user_id-user-id', 'auth', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('auth');
    }
}
