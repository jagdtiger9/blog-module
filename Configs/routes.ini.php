<?php

use Aljerom\Blog\Controllers\MainAdmin;

return [
    /**
     * Добавление-редактирование записи блога:
     *
     * @return API, Redirect
     */
    'POST:add' => [
        'controller' => [MainAdmin::class, 'add'],
        'params' => [
            'uid' => ['value' => 0, 'filter' => FILTER_VALIDATE_INT, 'comment' => 'ID редактируемой записи'],
            'title' => ['value' => '', 'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 'comment' => 'Заголовок записи'],
            'content' => ['value' => '', 'filter' => FILTER_DEFAULT, 'comment' => 'Содержимое записи'],
            'visibility' => ['value' => 'off', 'filter' => ['all', 'off'], 'comment' => 'Видимость'],
            'printPlace' => ['value' => 'general', 'filter' => ['general', 'category', 'private'], 'comment' => 'Где выводить'],
            'category' => ['value' => 0, 'filter' => FILTER_VALIDATE_INT, 'comment' => 'Идентификатор категории'],
        ]
    ],
    /**
     * Добавление-редактирование записи блога:
     *
     * @return API, Redirect
     */
    'GET:delRecord' => [
        'controller' => [MainAdmin::class, 'delRecord'],
        'params' => [
            'uid' => ['value' => 0, 'filter' => FILTER_VALIDATE_INT, 'comment' => 'ID удаляемой записи'],
        ]
    ],
];
