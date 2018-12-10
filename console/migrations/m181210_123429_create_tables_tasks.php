<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181210_123429_create_tables_tasks
 */
class m181210_123429_create_tables_tasks extends Migration
{
    const NAME_TABLE = 'task';
    const NAME_TABLE_PARENT = 'user';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT 'Задания'";
        }

        $this->createTable(self::NAME_TABLE, [
            'id' => Schema::TYPE_PK,
            'manager_id'  =>  Schema::TYPE_INTEGER . " COMMENT 'Менеджер'",
            'executor_id'  =>  Schema::TYPE_INTEGER . " COMMENT 'Исполнитель'",

            'name'  =>  Schema::TYPE_STRING . " COMMENT 'Наименование'",
            'comment'  =>  Schema::TYPE_TEXT . " COMMENT 'Комментарий'",
            'link_lecture'  =>  Schema::TYPE_STRING . " COMMENT 'Ссылка на лекцию'",
            'file'  =>  Schema::TYPE_STRING . " COMMENT 'Файл'",
            'status'  =>  "ENUM('new', 'in progress', 'done') NOT NULL COMMENT 'Состояние'",

            'created_at' => Schema::TYPE_DATETIME . " COMMENT 'Дата создания'",
            'updated_at' => Schema::TYPE_DATETIME . " COMMENT 'Дата обновления'",
        ], $tableOptions);

        $this->createIndex('manager_id', self::NAME_TABLE, 'manager_id');
        $this->createIndex('executor_id', self::NAME_TABLE, 'executor_id');
        $this->createIndex('status', self::NAME_TABLE, 'status');

        $this->addForeignKey(
            'FK_' . self::NAME_TABLE. '_manager',
            self::NAME_TABLE,
            'manager_id',
            self::NAME_TABLE_PARENT,
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'FK_' . self::NAME_TABLE. '_executor',
            self::NAME_TABLE,
            'executor_id',
            self::NAME_TABLE_PARENT,
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::NAME_TABLE);
    }
}
