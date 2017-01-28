<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CronInitialMigration extends AbstractMigration
{
    public function change()
    {
        // Automatically created phinx migration commands for tables from database minute

        // Migration for table m_cron_jobs
        $table = $this->table('m_cron_jobs', array('id' => 'cron_job_id'));
        $table
            ->addColumn('created_at', 'datetime', array())
            ->addColumn('updated_at', 'datetime', array())
            ->addColumn('name', 'string', array('limit' => 255))
            ->addColumn('description', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('type', 'enum', array('default' => 'script', 'values' => array('script','action','route')))
            ->addColumn('path', 'string', array('limit' => 255))
            ->addColumn('schedules_json', 'text', array('null' => true, 'limit' => MysqlAdapter::TEXT_LONG))
            ->addColumn('output_to', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('jitter', 'integer', array('null' => true, 'limit' => 11))
            ->addColumn('arguments', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('advanced', 'enum', array('null' => true, 'default' => 'false', 'values' => array('true','false')))
            ->addColumn('enabled', 'enum', array('default' => 'true', 'values' => array('true','false')))
            ->addColumn('running', 'enum', array('null' => true, 'default' => 'false', 'values' => array('true','false')))
            ->addIndex(array('enabled'), array())
            ->create();


        // Migration for table m_cron_logs
        $table = $this->table('m_cron_logs', array('id' => 'cron_log_id'));
        $table
            ->addColumn('cron_job_id', 'integer', array('limit' => 11))
            ->addColumn('created_at', 'datetime', array())
            ->addColumn('last_run_at', 'date', array('null' => true))
            ->addColumn('result', 'enum', array('default' => 'pending', 'values' => array('pending','pass','fail')))
            ->addColumn('run_time', 'float', array('default' => '0'))
            ->addColumn('output', 'text', array('null' => true, 'limit' => MysqlAdapter::TEXT_LONG))
            ->addColumn('error', 'text', array('null' => true, 'limit' => MysqlAdapter::TEXT_LONG))
            ->addIndex(array('cron_job_id', 'last_run_at', 'result'), array('unique' => true))
            ->create();


    }
}