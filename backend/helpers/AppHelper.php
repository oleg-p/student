<?php
/**
 * Помощник приложения
 */

namespace backend\helpers;

use common\models\User;
use Yii;
use common\dictionaries\Role;

class AppHelper
{
    /**
     * @var User
     */
    private static $modelUser = false;

    /**
     * @return User|null
     */
    public static function getModelUser()
    {
        if(static::$modelUser === false){
            if(Yii::$app->user->isGuest){
                static::$modelUser = null;
            } else {
                static::$modelUser = User::findOne(Yii::$app->user->id);
            }
        }

        return static::$modelUser;
    }

    /**
     * Возвращает роль текущего пользователя
     * @return mixed|null
     */
    public static function getRole()
    {
        if(empty(static::getModelUser())){
            return null;
        }

        return static::getModelUser()->role;
    }

    /**
     * Возвращает true, если пользователь администратор
     * @return bool
     */
    public static function isAdmin()
    {
        return static::getRole() === Role::ROLE_ADMIN;
    }

    /**
     * Возвращает true, если пользователь менеджер
     * @return bool
     */
    public static function isManager()
    {
        return static::getRole() === Role::ROLE_MANAGER;
    }

    /**
     * Возвращает true, если пользователь исполнитель
     * @return bool
     */
    public static function isExecutor()
    {
        return static::getRole() === Role::ROLE_EXECUTOR;
    }
}