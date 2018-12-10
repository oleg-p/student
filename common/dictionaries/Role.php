<?php
/**
 * Словарь состояний (статусов)
 */

namespace common\dictionaries;


class Role extends Dictionary
{
    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';
    const ROLE_EXECUTOR = 'executor';

    /**
     * @return array
     */
    public static function items()
    {
        return [
            static::ROLE_ADMIN      => 'Администратор',
            static::ROLE_MANAGER  => 'Менеджер',
            static::ROLE_EXECUTOR => 'Исполнитель',
        ];
    }

}