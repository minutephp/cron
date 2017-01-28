<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Admin\CronJobs {

    use App\Config\BootLoader;
    use Minute\Routing\RouteEx;
    use Minute\Shell\Shell;
    use Minute\View\Helper;
    use Minute\View\View;

    class Run {
        /**
         * @var BootLoader
         */
        private $bootLoader;
        /**
         * @var Shell
         */
        private $shell;

        /**
         * Run constructor.
         *
         * @param BootLoader $bootLoader
         * @param Shell $shell
         */
        public function __construct(BootLoader $bootLoader, Shell $shell) {
            $this->bootLoader = $bootLoader;
            $this->shell      = $shell;
        }

        public function index($jobs) {
            header('Content-type: text/plain');

            if ($cron_job = $jobs[0] ?? null) {
                if (!empty($cron_job->cron_job_id)) {
                    $script  = realpath(sprintf('%s/vendor/bin/script-runner', $this->bootLoader->getBaseDir()));
                    $run_cmd = sprintf('%s --input="%d"', $script, $cron_job->cron_job_id);
                    $output  = $this->shell->capture($run_cmd);

                    echo $output;
                }
            }
        }
    }
}