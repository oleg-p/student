<?php

use yii\db\Migration;

/**
 * Class m181210_144434_add_field_role_in_user
 */
class m181210_144434_add_field_role_in_user extends Migration
{
    const NAME_TABLE = 'user';
    const NAME_FIELD = 'role';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            self::NAME_TABLE,
            self::NAME_FIELD,
            "ENUM('admin', 'manager', 'executor') COMMENT 'Роль'"
        );

        $this->update(self::NAME_TABLE, [
            self::NAME_FIELD => 'admin',
        ],[
            'id' => 1,
        ] );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::NAME_TABLE, self::NAME_FIELD);
    }
}
