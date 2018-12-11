<?php
/**
 * Класс для заполнения тестовых данных
 */

namespace console\migrations;


class ListUsers
{
    const PREFIX_MANAGER  = 'manager';
    const PREFIX_EXECUTOR = 'executor';

    /**
     * Возвращает список менеджеров
     * @return array
     */
    public static function getManagers()
    {
        $items = [];
        foreach (range(1,9) as $number) {
            $name = self::PREFIX_MANAGER . $number;
            $items [] = [
                'id' => 10 +  $number,
                'username' => $name,
                'email' => $name . '@student.app',
                'password' => $name,
                'role' => 'manager',
            ];
        }

        return $items;
    }

    /**
     * Возвращает список исполнителей
     * @return array
     */
    public static function getExecuters()
    {
        $items = [];
        foreach (range(1,9) as $number) {
            $name = self::PREFIX_EXECUTOR . $number;
            $items [] = [
                'id' => 100 +  $number,
                'username' => $name,
                'email' => $name . '@student.app',
                'password' => $name,
                'role' => 'executor',
            ];
        }

        return $items;
    }
}