<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 11/5/2016
 * Time: 11:04 AM
 */
namespace Minute\Todo {

    use App\Controller\Admin\CronJobs;
    use Minute\Config\Config;
    use Minute\Event\ImportEvent;

    class CronTodo {
        /**
         * @var TodoMaker
         */
        private $todoMaker;
        /**
         * @var Config
         */
        private $config;

        /**
         * MailerTodo constructor.
         *
         * @param TodoMaker $todoMaker - This class is only called by TodoEvent (so we assume TodoMaker is be available)
         * @param Config $config
         */
        public function __construct(TodoMaker $todoMaker, Config $config) {
            $this->todoMaker = $todoMaker;
            $this->config    = $config;
        }

        public function getTodoList(ImportEvent $event) {
            $time    = time() - $this->config->get(CronJobs::cronKey . '/lastRun', 0);
            $running = $time < 3600;
            $todos[] = ['name' => 'Check cron job are running', 'description' => $running ? "" : "Cron daemon is not running properly (ignore during development)",
                        'status' => $running ? 'complete' : 'incomplete', 'link' => '/admin/cron-jobs'];

            $event->addContent(['Cron' => $todos]);
        }
    }
}