<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Admin {

    use App\Config\BootLoader;
    use Cron\CronExpression;
    use Minute\Config\Config;
    use Minute\Error\ViewError;
    use Minute\View\View;

    class CronJobs {
        const cronKey = 'private/cron';
        /**
         * @var Config
         */
        private $config;
        /**
         * @var BootLoader
         */
        private $bootLoader;

        /**
         * CronJobs constructor.
         *
         * @param Config $config
         * @param BootLoader $bootLoader
         */
        public function __construct(Config $config, BootLoader $bootLoader) {
            $this->config     = $config;
            $this->bootLoader = $bootLoader;
        }

        public function index($_jobs) {
            $lastRun = $this->config->get(self::cronKey . '/lastRun', 0);

            foreach ($_jobs as $job) {
                $schedules = json_decode($job->schedules_json);

                foreach ($schedules as $schedule) {
                    $str  = @join(' ', [$schedule->min, $schedule->hour, $schedule->daymonth, $schedule->month, $schedule->dayweek]);
                    $cron = CronExpression::factory($str);
                    $next = $cron->getNextRunDate()->format('Y-m-d H:i:s');

                    if (empty($settings['schedules'][$job->cron_job_id]) || (strtotime($settings['schedules'][$job->cron_job_id]) > strtotime($next))) {
                        $job->metadata = ['nextRun' => $next];
                    }
                }
            }

            return (new View())->set('lastRun', time() - $lastRun)->set('baseDir', $this->bootLoader->getBaseDir());
        }
    }
}