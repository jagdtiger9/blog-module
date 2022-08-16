<?php

namespace Aljerom\Blog\Models;

use MagicPro\Database\Model\Model;

class Category extends Model
{
    /**
     * Таблица модели
     *
     * @var string
     */
    protected $table = 'blog__category';

    /**
     * Первичный ключ
     *
     * @var string
     */
    protected $primaryKey = 'uid';

    protected $fieldMap = [
        'uid' => 0,
        'name' => '',
        'title' => '',
        'type' => 'novice',
        'keywordsList' => '',
        'listTpl' => '',
        'articleTpl' => '',
        'formTpl',
    ];
}
