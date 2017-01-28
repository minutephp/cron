<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MCronLog extends ModelEx {
        protected $table      = 'm_cron_logs';
        protected $primaryKey = 'cron_log_id';
    }
}