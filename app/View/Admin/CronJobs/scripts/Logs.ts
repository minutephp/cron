/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class LogListController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public $http: ng.IHttpService, public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');

            $scope.job = $scope.jobs[0];
            $scope.logs = $scope.job.logs;
        }

        truncate = () => {
            this.$ui.confirm(this.gettext('Are you sure?')).then(() => {
                this.$http.post('/admin/cron-jobs/truncate/' + this.$scope.job.cron_job_id, {}).then(() => {
                    this.$ui.toast(this.gettext('Logs cleared successfully!'));
                    this.$scope.jobs.reloadAll(true);
                });
            });
        };

        zoom = (log) => {
            this.$ui.popupUrl('/zoom.html', false, null, {log: log, ctrl: this});
        }
    }

    angular.module('logListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('logListController', ['$scope', '$minute', '$ui', '$timeout', '$http', 'gettext', 'gettextCatalog', LogListController]);
}
