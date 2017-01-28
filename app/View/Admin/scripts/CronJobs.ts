/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class JobListController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }

        actions = (item) => {
            let gettext = this.gettext;
            let actions = [
                {'text': gettext('Edit..'), 'icon': 'fa-edit', 'hint': gettext('Edit job'), 'href': '/admin/cron-jobs/edit/' + item.cron_job_id},
                {'text': gettext('Logs..'), 'icon': 'fa-list', 'hint': gettext('View cron logs'), 'href': '/admin/cron-jobs/logs/' + item.cron_job_id},
                {'text': gettext('Clone'), 'icon': 'fa-copy', 'hint': gettext('Clone job'), 'click': 'ctrl.clone(item)'},
                {'text': gettext('Run'), 'icon': 'fa-bolt', 'hint': gettext('Run this job'), 'click': 'ctrl.run(item)'},
                {'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this job'), 'click': 'item.removeConfirm("Removed")'},
            ];

            this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.name, this.$scope, {item: item, ctrl: this});
        };

        run = (job) => {
            window.open('/admin/cron-jobs/run/' + job.cron_job_id, 'popup', 'width=640,height=480');
        };

        clone = (job) => {
            let gettext = this.gettext;
            this.$ui.prompt(gettext('Enter job name'), gettext('new-job-name')).then(function (name) {
                job.clone().attr('name', name).save(gettext('Job duplicated'));
            });
        }
    }

    angular.module('jobListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('jobListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', JobListController]);
}
