<?php

namespace Aljerom\Blog;

use MagicPro\PluginModules\Module\AbstractModule;

class BlogModule extends AbstractModule
{
    public function modulePath(): string
    {
        return __DIR__;
    }

    public function getName(): string
    {
        return 'blog';
    }

    public function getTitle(): string
    {
        return 'Блоги';
    }

    public function getIconPath(): string
    {
        return realpath($this->modulePath . '/' . AbstractModule::MODULE_ICON);
    }
}
