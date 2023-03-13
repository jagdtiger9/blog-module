<?php

namespace Aljerom\Blog\Models;

use MagicPro\Database\Model\Model;

class Record extends Model
{
    /**
     * Таблица модели
     *
     * @var string
     */
    protected $table = 'blog__records';

    /**
     * Первичный ключ
     *
     * @var string
     */
    protected $primaryKey = 'uid';

    protected $fieldMap = [
        'uid' => 0,
        'categoryId' => 0,
        'redirectLink' => '',
        'subscrStatus' => 0,
        'title' => '',
        'content' => '',
        'userId' => 0,
        'login' => '',
        'dateCreate' => 0,
        'dateModify' => 0,
        'visibility' => 'off',
        'printPlace' => 'private',
        'ip' => '',
        'tags' => '',
        'keywords' => '',
        'autoKeywords' => 0,
        'metaTitle' => '',
        'metaDescr' => '',
        'startLog' => 0,
        'lastLog' => 0,
        'viewCount' => 0,
    ];

    public function setVisibility($visibility = 'off')
    {
        $this->visibility = in_array($visibility, ['off', 'all']) ? $visibility : 'off';

        return $this;
    }

    public function setPrintPlace($printPlace = 'general')
    {
        $this->printPlace = in_array($printPlace, ['general', 'category', 'private']) ? $printPlace : 'general';

        return $this;
    }

    public function setUser(int $userId, string $login)
    {
        if (!$this->userId) {
            $this->userId = $userId;
            $this->login = $login;
        }

        return $this;
    }

    public function save()
    {
        if (!$this->title) {
            throw new \InvalidArgumentException('Название записи не может быть пустым');
        }
        if (!$this->dateCreate) {
            $this->dateCreate = time();
        }
        $this->dateModify = time();

        return parent::save();
    }
}
