<?php

namespace Aljerom\Blog\ViewHelpers;

use Aljerom\Blog\Models\Category;
use Aljerom\Blog\Models\Record;
use MagicPro\Contracts\User\SessionUserInterface;
use MagicPro\Tools\Stringer;
use MagicPro\View\ViewHelper\AbstractViewHelper;

/**
 * Одна или список записей блога.
 */
class BlogRecord extends AbstractViewHelper
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
                'comment' => 'Идентификатор запрашиваемой записи',
                'filter' => FILTER_VALIDATE_INT
            ],
            'count' => [
                'value' => '20',
                'comment' => 'Кол-во выводиых записей',
                'filter' => FILTER_VALIDATE_INT
            ],
            'page' => [
                'value' => '1',
                'comment' => 'Текущая страница',
                'filter' => FILTER_VALIDATE_INT
            ],
            'hidden' => [
                'value' => 0,
                'comment' => 'Показывать скрытые?',
                'filter' => [0, 1]
            ],
            'printPlace' => [
                'value' => '',
                'comment' => '[\'general\', \'category\', \'private\']',
                'filter' => ['general', 'category', 'private']
            ],
            'user' => [
                'value' => 0,
                'comment' => 'Вывод записей пользователя',
                'filter' => FILTER_VALIDATE_INT
            ],
            'category' => [
                'value' => '',
                'comment' => 'Список выводимых категорий',
                'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
            ],
        ];
    }

    /**
     * @return array
     */
    public function getData()
    {
        $record = new Record();
        if ($this->params['uid']) {
            $total = 1;
            if (false !== $result = $record->find($this->params['uid'])) {
                if (!$record->visibility && $record->userId !== $this->user->uid() && !$this->user->isAdmin()) {
                    $result = [];
                    $total = 0;
                }
            } else {
                $result = [];
                $total = 0;
            }
        } else {
            $query = $record->orderBy('dateCreate', 'desc');
            if ($this->params['user']) {
                $query->where('userId', $this->params['user']);
            }
            if ($this->params['printPlace']) {
                $query->where('printPlace', $this->params['printPlace']);
            }

            if ($this->params['hidden'] && ($this->user->isAdmin() || $this->params['user'] === $this->user->uid())) {
                //
            } else {
                $query->where('visibility', 'all');
            }

            if ($this->params['category'] && (null !== $category = Category::where('name', $this->params['category'])->first())) {
                $query->where('categoryId', $category->uid);
            }

            $total = $query->count();
            $result = $query->forPage($this->params['page'], $this->params['count'])
                ->get();

            array_walk(
                $result,
                function (&$item) {
                    $item['announce'] = Stringer::tagContent($item['content'], 'announce');
                }
            );
        }

        return ['data' => $result, 'total' => $total];
    }

    public function getPresetTemplates(): array
    {
        return [
            'recordList',
            'singleRecord',
        ];
    }
}
