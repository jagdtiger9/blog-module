<?php
return [
    'mod_config' => [
        // Доступность в списке модулей админки
        'isVisible' => true,

        // Наименование модуля
        'moduleTitle' => 'Блоги',

        // Список автоматически создаваемых директорий модуля, доступных для записи
        // Каждый элемент массива - путь, относительно DOCUMENT_ROOT/vardata/modules/<moduleName>
        'vardata' => ['log', 'data'],

        // Директории дампируемых данных. Каждый элемент массива - путь к директории, относительно DOCUMENT_ROOT
        'dumpFiles' => [],
    ],

    'tables' => [
        'category' => 'blog__category',
        'records' => 'blog__records',
    ],

    'dataDir' => '/vardata/modules/blog/data',
    'userDataDir' => '/vardata/modules/blog/data/%userid%',
    'userPreviewDir' => '/vardata/modules/blog/data/%userid%/preview',

    'settings' => include 'design/config/blog_ini.php'
];
/**
 * SportelementBot
 *
 * Done! Congratulations on your new bot. You will find it at t.me/SportelementBot.
 * You can now add a description, about section and profile picture for your bot, see /help for a list of commands.
 * By the way, when you've finished creating your cool bot,
 * ping our Bot Support if you want a better username for it.
 * Just make sure the bot is fully operational before you do this.
 *
 * Use this token to access the HTTP API:
 * 390716297:AAEmglbPgc82rw70xYzXPuCU-0Q4JnNG2tU
 *
 * For a description of the Bot API, see this page: https://core.telegram.org/bots/api
 *
 * Entities/Message: line: 60
 *  'reply_to_message'  => ReplyToMessage::class,
 */
