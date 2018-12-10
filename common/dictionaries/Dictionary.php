<?php
/**
 * Словарь Абстрактный
 */

namespace common\dictionaries;


abstract class Dictionary
{
    use DictionaryTrait;

    /**
     * @return array
     */
    static function items(){
        return [];
    }
}