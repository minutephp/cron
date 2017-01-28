<div class="content-wrapper ng-cloak" ng-app="jobEditApp" ng-controller="jobEditController as mainCtrl" ng-init="init()">
    <div class="admin-content" minute-hot-keys="{'ctrl+s':mainCtrl.save}">
        <section class="content-header">
            <h1>
                <span translate="" ng-show="!job.cron_job_id">Create new</span>
                <span translate="" ng-show="!!job.cron_job_id">Edit</span>
                <span translate="">job</span>
            </h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li><a href="" ng-href="/admin/cron-jobs"><i class="fa fa-job"></i> <span translate="">Jobs</span></a></li>
                <li class="active"><i class="fa fa-edit"></i> <span translate="">Edit job</span></li>
            </ol>
        </section>

        <section class="content">
            <form class="form-horizontal" name="jobForm" ng-submit="mainCtrl.save()">
                <div class="box box-{{jobForm.$valid && 'success' || 'danger'}}">
                    <div class="box-header with-border">
                        <span translate="" ng-show="!job.cron_job_id">New job</span>
                        <span ng-show="!!job.cron_job_id"><span translate="">Edit</span> {{job.name}}</span>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name"><span translate="">Name:</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" placeholder="Enter Name" ng-model="job.name" ng-required="true">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="description"><span translate="">Description:</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="description" placeholder="Enter Description" ng-model="job.description" ng-required="false">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span translate="">Job type:</span></label>
                            <div class="col-sm-10">
                                <label class="radio-inline" ng-repeat="(key, value) in data.types">
                                    <input type="radio" ng-model="job.type" ng-value="key" ng-change="job.path = ''"> {{value}}
                                </label>
                            </div>
                        </div>

                        <div class="form-group" ng-if="job.type==='action'">
                            <label class="col-sm-2 control-label"><span translate="">Controller:</span></label>
                            <div class="col-sm-10">
                                <ol class="nya-bs-select form-control" ng-model="job.path" data-live-search="true" size="15">
                                    <li nya-bs-option="option in session.vars.controllers group by option.type" value="option.value">
                                        <span class="dropdown-header"><b>{{$group}}</b></span>
                                        <a>
                                            <span>{{ option.name }}</span>
                                            <!-- this content will be search first -->
                                            <span class="small">{{ option.subtitle }}</span>
                                            <!-- if the name failed, this will be used -->
                                            <span class="glyphicon glyphicon-ok check-mark"></span>
                                        </a>
                                    </li>
                                </ol>

                                <p class="help-block text-small">(Controllers in <code>app\Controller\Cron</code> folder are visible here)</p>
                            </div>
                        </div>

                        <div class="form-group" ng-if="job.type==='script'">
                            <label class="col-sm-2 control-label" for="path"><span translate="">Script path:</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="path" placeholder="Enter Absolute Script Path on Server" ng-model="job.path" ng-required="true">
                                <p class="help-block"><span translate="">(Type full path, e.g. /var/bin/myscript or c:\bin\myscript.bat)</span></p>
                            </div>
                        </div>

                        <div class="form-group" ng-if="job.type==='route'">
                            <label class="col-sm-2 control-label" for="url"><span translate="">URL to ping:</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="url" placeholder="Enter URL to ping (can be relative or absolute)" ng-model="job.path" ng-required="true">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="timing">Timings:</label>

                            <div class="col-sm-10">
                                <div class="row inline-row" ng-repeat="schedule in job.schedules_json">
                                    <div class="col-md-2">
                                        <label>Minute</label>
                                        <input class="form-control" type="text" ng-model="schedule.min" ng-required="true" placeholder="*" />
                                    </div>
                                    <div class="col-md-2">
                                        <label>Hour</label>
                                        <input class="form-control" type="text" ng-model="schedule.hour" ng-required="true" placeholder="*" />
                                    </div>
                                    <div class="col-md-2">
                                        <label>Day of month</label>
                                        <input class="form-control" type="text" ng-model="schedule.daymonth" ng-required="true" placeholder="*" />
                                    </div>
                                    <div class="col-md-2">
                                        <label>Month</label>
                                        <input class="form-control" type="text" ng-model="schedule.month" ng-required="true" placeholder="*" />
                                    </div>
                                    <div class="col-md-2">
                                        <label>Day of week</label>
                                        <input class="form-control" type="text" ng-model="schedule.dayweek" ng-required="true" placeholder="*" />
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="close" ng-click="job.schedules_json.splice($index, 1)" ng-show="job.schedules_json.length > 1">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>

                                <p class="help-block">
                                    <a href="http://alvinalexander.com/linux/unix-linux-crontab-every-minute-hour-day-syntax" target="_blank">Crontab quick reference</a>
                                </p>
                                <p class="help-block">
                                    <button type="button" class="btn btn-default btn-flat btn-sm" ng-click="job.schedules_json.push({})">Add schedule</button>
                                </p>
                            </div>
                        </div>

                        <div ng-show="job.advanced">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="arguments">{{job.type==='route'&&'Run as user'||'Arguments'}}:</label>

                                <div class="col-sm-10">
                                    <textarea class="form-control" ng-model="job.arguments" id="arguments" rows="2"
                                              placeholder="{{job.type==='route'&&'E-mail or user_id (for ' + session.site.domain+' relative URLs only)'||
                                              (job.type==='action'&&'JSON encoded arguments to pass to controller'||'Arguments to pass to script')}}"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="output_to"><span translate="">Output to:</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="output_to" placeholder="Enter email address or Absolute URL" ng-model="job.output_to" ng-required="false">
                                    <p class="help-block"><span translate="">Can be an email address or Absolute URL</span></p>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="jitter">Jitter:</label>

                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="number" class="form-control" ng-model="job.jitter" id="jitter" placeholder="Jitter" />
                                        <div class="input-group-addon">secs</div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <label class="checkbox-inline">
                                    <input type="checkbox" ng-model="job.enabled"> <span translate="">Job enabled</span>
                                </label>

                                <label class="checkbox-inline">
                                    <input type="checkbox" ng-model="job.advanced"> <span translate="">Show advanced options</span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer with-border">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-flat btn-primary" ng-disabled="!job.path || !job.schedules_json.length">
                                    <span translate="" ng-show="!job.cron_job_id">Create</span>
                                    <span translate="" ng-show="!!job.cron_job_id">Update</span>
                                    <span translate="">job</span>
                                    <i class="fa fa-fw fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </section>
    </div>
</div>
