<div class="content-wrapper ng-cloak" ng-app="logListApp" ng-controller="logListController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1><span translate="">Cron logs</span> <small><span translate="">for </span> {{job.name}}</small></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li><a href="" ng-href="/admin/cron-jobs"><i class="fa fa-dashboard"></i> <span translate="">Cron jobs</span></a></li>
                <li><a href="" ng-href="/admin/cron-jobs/edit/{{job.cron_job_id}}"><i class="fa fa-dashboard"></i> {{job.name}}</a></li>
                <li class="active"><i class="fa fa-log"></i> <span translate="">Cron logs</span></li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span translate="">Recent activity</span>
                    </h3>

                    <div class="box-tools">
                        <a class="btn btn-sm btn-danger btn-flat btn-xs" ng-click="mainCtrl.truncate()">
                            <i class="fa fa-trash"></i> <span translate="">Clear all logs</span>
                        </a>
                    </div>
                </div>

                <div class="box-body">
                    <div class="list-group">
                        <div class="list-group-item list-group-item-bar list-group-item-bar-{{log.result === 'pass' && 'success' || 'danger'}}"
                             ng-repeat="log in logs" ng-click-container="mainCtrl.zoom(log)">
                            <div class="pull-left">
                                <h4 class="list-group-item-heading">{{(log.output || 'No output') | truncate:50}}</h4>
                                <p class="list-group-item-text hidden-xs">
                                    <span translate="">Created:</span> {{log.created_at | timeAgo}}.
                                    <span translate="">Result:</span> <span class="label label-{{log.result === 'pass' && 'success' || 'danger'}}">{{log.result}}</span>
                                </p>
                            </div>
                            <div class="md-actions pull-right">
                                <a class="btn btn-default btn-flat btn-sm" ng-click="log.removeConfirm()">
                                    <i class="fa fa-trash"></i> <span translate="">Remove</span>
                                </a>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-push-6">
                            <minute-pager class="pull-right" on="logs" no-results="{{'No logs found' | translate}}"></minute-pager>
                        </div>
                        <div class="col-xs-12 col-md-6 col-md-pull-6">
                            <minute-search-bar on="logs" columns="result, output" label="{{'Search logs..' | translate}}"></minute-search-bar>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script type="text/ng-template" id="/zoom.html">
        <div class="box">
            <div class="box-header with-border">
                <b class="pull-left"><span translate="">View log #{{log.cron_log_id}}</span></b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                <div class="clearfix"></div>
            </div>

            <div class="box-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span translate="">Result:</span></label>
                        <div class="col-sm-9">
                            <p class="help-block" translate="">{{log.result}}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span translate="">Run time:</span></label>
                        <div class="col-sm-9">
                            <p class="help-block" translate="">{{log.run_time}} secs</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="output">
                            <span translate="">Output:</span>
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="4" readonly title="output" ng-model="log.output"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="output">
                            <span translate="">Errors:</span>
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="4" readonly ng-model="log.error" title="errors"></textarea>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </script>

</div>
