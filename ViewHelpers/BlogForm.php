<?php

namespace Aljerom\Blog\ViewHelpers;

use Aljerom\Blog\Models\Category;
use Aljerom\Blog\Models\Record;
use MagicPro\Contracts\User\SessionUserInterface;
use MagicPro\View\ViewHelper\AbstractViewHelper;

/**
 * Форма добавления записей в блог
 */
class BlogForm extends AbstractViewHelper
{
    public function __construct(
        private SessionUserInterface $user,
    ) {
    }

    /**
     * Список параметров, которые принимает ViewHelper с указанием соответствующих дефолтных значений
     * @return array
     */
    public function defaultParams(): array
    {
        return [
            'uid' => [
                'value' => '0',
                'comment' => 'Идентификатор редактируемой записи',
                'filter' => FILTER_VALIDATE_INT
            ],
        ];
    }

    /**
     * @return array
     */
    public function getData()
    {
        $msg = '';
        if ($this->params['uid']) {
            if (null === $record = Record::find($this->params['uid'])) {
                $record = new Record();
            } elseif ($record->userId !== \app('session')->get('userid') && !$this->user->isAdmin()) {
                $msg = $msg ? : 'Что-то пошло не так';
                $record = new Record();
            }
        } else {
            $record = new Record();
        }

        $data = [
            'msg' => $msg,
            'form' => [
                'action' => '/api/blog/add/',
                'method' => 'POST',
                'fields' => [
                    'uid' => ['name' => 'uid', 'type' => 'hidden', 'value' => $record->uid],
                    'content' => ['name' => 'content', 'type' => 'textarea', 'value' => $record->content],
                    'title' => ['name' => 'title', 'type' => 'text', 'value' => $record->title],
                    'visibility' => [
                        'name' => 'visibility',
                        'type' => 'select',
                        'value' => $record->visibility,
                        'options' => ['off', 'all']
                    ],
                    'printPlace' => [
                        'name' => 'printPlace',
                        'type' => 'select',
                        'value' => $record->printPlace,
                        'options' => ['general', 'category', 'private'],
                    ],
                    'category' => [
                        'name' => 'category',
                        'type' => 'select',
                        'value' => $record->categoryId,
                        'options' => (new Category())->get(['uid', 'title'])
                    ]
                ]
            ],
        ];

        return $data;
    }

    public function getPresetTemplates(): array
    {
        return [
            'form',
            'initEditor'
        ];
    }
}
