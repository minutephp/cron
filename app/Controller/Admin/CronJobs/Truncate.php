<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Admin\CronJobs {

    use App\Model\MCronLog;

    class Truncate {

        public function index(string $cron_job_id) {
            MCronLog::where('cron_job_id', '=', $cron_job_id)->delete();

            return 'OK';
        }
    }
}