<?php
/**
 * Словарь состояний (статусов)
 */

namespace common\dictionaries;


class Status extends Dictionary
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in progress';
    const STATUS_DONE = 'done';

    /**
     * @return array
     */
    public static function items()
    {
        return [
            static::STATUS_NEW          => 'Новый',
            static::STATUS_IN_PROGRESS  => 'В работе',
            static::STATUS_DONE         => 'Сделано',
        ];
    }

}