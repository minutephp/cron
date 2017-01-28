<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MCronJob extends ModelEx {
        protected $table      = 'm_cron_jobs';
        protected $primaryKey = 'cron_job_id';
    }
}