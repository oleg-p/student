<?php

use yii\db\Migration;
use console\migrations\ListUsers;
use common\models\User;

/**
 * Class m181210_145604_filling__test_users
 */
class m181210_145604_filling__test_users extends Migration
{
    const NAME_TABLE = 'user';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach (ListUsers::getManagers() as $item) {
            $model = new User([
                'id' => $item['id'],
                'username' => $item['username'],
                'email' => $item['email'],
                'password' => $item['password'],
                'role' => $item['role'],
            ]);

            $model->generateAuthKey();
            $model->save();
        }

        foreach (ListUsers::getExecuters() as $item) {
            $model = new User([
                'id' => $item['id'],
                'username' => $item['username'],
                'email' => $item['email'],
                'password' => $item['password'],
                'role' => $item['role'],
            ]);

            $model->generateAuthKey();
            $model->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(self::NAME_TABLE, 'id > 1');
    }
}
