<?php

/** @var Binding $binding */
use Minute\Event\AdminEvent;
use Minute\Event\Binding;
use Minute\Event\TodoEvent;
use Minute\Menu\CronMenu;
use Minute\Todo\CronTodo;

$binding->addMultiple([
    //cron
    ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [CronMenu::class, 'adminLinks']],

    //tasks
    ['event' => TodoEvent::IMPORT_TODO_ADMIN, 'handler' => [CronTodo::class, 'getTodoList']],
]);