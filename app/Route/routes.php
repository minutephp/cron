<?php

/** @var Router $router */
use Minute\Model\Permission;
use Minute\Routing\Router;

$router->get('/admin/cron-jobs', 'Admin/CronJobs', 'admin', 'm_cron_jobs[5] as jobs', 'm_cron_log[jobs.cron_job_id] as logs order by created_at desc')
       ->setReadPermission('jobs', 'admin')->setDefault('jobs', '*');
$router->post('/admin/cron-jobs', null, 'admin', 'm_cron_jobs as jobs')
       ->setAllPermissions('jobs', 'admin');

$router->get('/admin/cron-jobs/edit/{cron_job_id}', 'Admin/CronJobs/Edit', 'admin', 'm_cron_jobs[cron_job_id] as jobs')
       ->setReadPermission('jobs', 'admin')->setDefault('cron_job_id', '0');
$router->post('/admin/cron-jobs/edit/{cron_job_id}', null, 'admin', 'm_cron_jobs as jobs')
       ->setAllPermissions('jobs', 'admin')->setDefault('cron_job_id', '0');

$router->get('/admin/cron-jobs/logs/{cron_job_id}', null, 'admin', 'm_cron_jobs[cron_job_id] as jobs', 'm_cron_logs[jobs.cron_job_id][5] as logs')
       ->setReadPermission('jobs', 'admin')->setDefault('jobs', '*');
$router->post('/admin/cron-jobs/logs/{cron_job_id}', null, 'admin', 'm_cron_logs as logs')
       ->setAllPermissions('logs', 'admin');

$router->post('/admin/cron-jobs/truncate/{cron_job_id}', 'Admin/CronJobs/Truncate', 'admin');

$router->get('/admin/cron-jobs/run/{cron_job_id}', 'Admin/CronJobs/Run.php', 'admin', 'm_cron_jobs[cron_job_id] as jobs')
       ->setReadPermission('jobs', 'admin')->setDefault('_noView', true);