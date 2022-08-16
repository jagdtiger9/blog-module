<?php

# Таблица записей блогов
# --- `name` varchar(255) NOT NULL default '' COMMENT 'Псевдоним для навигации, урлов',
# --- UNIQUE KEY `name` (`name`)
$sql = "CREATE TABLE IF NOT EXISTS `blog__records` (
  `uid` int(11) unsigned NOT NULL auto_increment COMMENT 'Идентификатор',
  `categoryId` int(11) unsigned NOT NULL COMMENT 'Идентификатор категории',

  `redirectLink` varchar(255) NOT NULL default '' COMMENT 'Редирект при клике на запись в списке',
  `subscrStatus` tinyint(1) not null default 0 COMMENT 'Признак: запись отправлена по рассылке или нет',

  `title` varchar(255) NOT NULL default '' COMMENT 'Название записи',
  `content`	text NOT NULL,
  `userId` int(11) NOT NULL default '0' COMMENT 'Идентификатор пользователя',
  `login` varchar(255) NOT NULL default '' COMMENT 'Логин пользователя, на случай его удаления',
  `dateCreate`	integer NOT NULL default '0',
  `dateModify` integer NOT NULL default '0',
  `visibility` enum('off','all','friends') NOT NULL default 'off',
  `printPlace` enum('general','category','private') NOT NULL default 'private',
  `ip` varchar(16) NOT NULL default '' COMMENT 'IP пользователя',
  `tags`	varchar(255) NOT NULL default '' COMMENT 'Список тегов, разделенных запятой',
  `keywords` varchar(255) NOT NULL default '' COMMENT 'Список keywords для мета-тегов',
  `autoKeywords` tinyint(1) NOT NULL default '0' COMMENT 'Признак: брать пользовательские ключевые слова или генерить автоматом',
  `metaTitle` varchar(255) NOT NULL default '' COMMENT 'Заголовок для Мета-тегов',
  `metaDescr` varchar(255) NOT NULL default '' COMMENT 'Описание для Мета-тегов',
  `startLog` integer NOT NULL default '0' COMMENT 'Первая дата показа статьи',
  `lastLog` integer NOT NULL default '0' COMMENT 'Последняя дата показа статьи',
  `viewCount` integer NOT NULL default '0' COMMENT '',
  PRIMARY KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
\dumpsite\Models\Dump::createTable('blog__records', $sql);

# Таблица категорий блогов
$sql = "CREATE TABLE IF NOT EXISTS `blog__category` (
  `uid` int(11) unsigned NOT NULL auto_increment COMMENT 'Идентификатор',
  `name` char(40) NOT NULL default '' COMMENT 'Символьный ключ для редакторов',
  `title` varchar(255) NOT NULL default '' COMMENT 'Тазвание категории',
  `type` enum('novice','advance','admin') default 'novice',
  `keywordsList` text NOT NULL COMMENT 'Список ключевых слов, используемых при автоматической генерации',
  `listTpl` varchar(255) NOT NULL default '' COMMENT 'Шаблон вывода списка записей богов',
  `articleTpl` varchar(255) NOT NULL default '' COMMENT 'Шаблон вывода записи блога',
  `formTpl` varchar(255) NOT NULL default '' COMMENT 'Шаблон вывода формы добавления записи в блог',
  PRIMARY KEY `uid` (`uid`),
  UNIQUE `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
\dumpsite\Models\Dump::createTable('blog__category', $sql);
