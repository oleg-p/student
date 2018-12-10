<?php
/**
 * Трейт для словаря
 */

namespace common\dictionaries;


trait DictionaryTrait
{
    /**
     * Возвращает значение словаря
     * @param int $key
     * @return mixed
     */
    public static function getValue($key){
        if(!isset(static::items()[$key])){
            return 'Не определёно';
        }

        return static::items()[$key];
    }
}