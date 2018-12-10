<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m181210_121250_add_first_user
 */
class m181210_121250_add_first_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $model = new User([
            'id' => 1,
            'username' => 'admin',
            'email' => 'admin@student.app',
            'password' => 'admin',
        ]);
        $model->generateAuthKey();
        $model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('user', ['id' => 1]);

        return true;
    }
}
