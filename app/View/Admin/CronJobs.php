<div class="content-wrapper ng-cloak" ng-app="jobListApp" ng-controller="jobListController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1><span translate="">List of jobs</span></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li class="active"><i class="fa fa-job"></i> <span translate="">Job list</span></li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-default">
                <div class="alert alert-danger alert-dismissible" role="alert" ng-if="session.vars.lastRun > 3600"  ng-show="session.site.version !== 'debug'">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <p translate="">It looks like the <code>cron manager</code> isn't running. It has been more than {{session.vars.lastRun / 60 | number:0}} minutes since it was last run!</p>
                    <p translate="">Please make sure you've added <code>{{session.vars.baseDir}}/vendor/bin/cron-runner</code> file to your crontab (task scheduler on Windows).</p>
                </div>

                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span translate="">All jobs</span>
                    </h3>

                    <div class="box-tools">
                        <a class="btn btn-sm btn-primary btn-flat" ng-href="/admin/cron-jobs/edit">
                            <i class="fa fa-plus-circle"></i> <span translate="">Create new job</span>
                        </a>
                    </div>
                </div>

                <div class="box-body">
                    <div class="list-group">
                        <div class="list-group-item list-group-item-bar list-group-item-bar-{{job.logs.result === 'pass' && 'success' || 'danger'}}"
                             ng-repeat="job in jobs" ng-click-container="mainCtrl.actions(job)">
                            <div class="pull-left">
                                <h4 class="list-group-item-heading">
                                    {{job.name | ucfirst}} - <small>{{job.description}}</small>
                                    <small ng-show="!job.logs.result" class="text-danger" translate="">(Never run)</sup></small>
                                </h4>
                                <p class="list-group-item-text hidden-xs" ng-show="!!job.metadata.nextRun">
                                    <span translate="">Next run:</span> {{job.metadata.nextRun | timeAgo}} ({{job.metadata.nextRun}}).
                                </p>
                                <p class="list-group-item-text hidden-xs" ng-show="!!job.logs.result">
                                    <span translate="">Last run:</span> {{job.logs.created_at | timeAgo}}.
                                    <span translate="">Last result:</span>
                                    <span class="label {{job.logs.result === 'pass' && 'label-success' || 'label-danger'}}">{{job.logs.result}}</span>
                                </p>
                            </div>
                            <div class="md-actions pull-right">
                                <a class="btn btn-default btn-flat btn-sm" ng-href="/admin/cron-jobs/logs/{{job.cron_job_id}}">
                                    <i class="fa fa-list"></i> <span translate="">View logs</span>
                                </a>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-push-6">
                            <minute-pager class="pull-right" on="jobs" no-results="{{'No jobs found' | translate}}"></minute-pager>
                        </div>
                        <div class="col-xs-12 col-md-6 col-md-pull-6">
                            <minute-search-bar on="jobs" columns="name, description" label="{{'Search job..' | translate}}"></minute-search-bar>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
