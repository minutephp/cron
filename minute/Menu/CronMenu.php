<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/8/2016
 * Time: 7:57 PM
 */
namespace Minute\Menu {

    use Minute\Event\ImportEvent;

    class CronMenu {
        public function adminLinks(ImportEvent $event) {
            $links = [
                'cron' => ['title' => 'Cron jobs', 'icon' => 'fa-clock-o', 'priority' => 5, 'parent' => 'expert', 'href' => '/admin/cron-jobs']
            ];

            $event->addContent($links);
        }
    }
}