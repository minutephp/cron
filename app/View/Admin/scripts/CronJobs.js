/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var JobListController = (function () {
        function JobListController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.actions = function (item) {
                var gettext = _this.gettext;
                var actions = [
                    { 'text': gettext('Edit..'), 'icon': 'fa-edit', 'hint': gettext('Edit job'), 'href': '/admin/cron-jobs/edit/' + item.cron_job_id },
                    { 'text': gettext('Logs..'), 'icon': 'fa-list', 'hint': gettext('View cron logs'), 'href': '/admin/cron-jobs/logs/' + item.cron_job_id },
                    { 'text': gettext('Clone'), 'icon': 'fa-copy', 'hint': gettext('Clone job'), 'click': 'ctrl.clone(item)' },
                    { 'text': gettext('Run'), 'icon': 'fa-bolt', 'hint': gettext('Run this job'), 'click': 'ctrl.run(item)' },
                    { 'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this job'), 'click': 'item.removeConfirm("Removed")' },
                ];
                _this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.name, _this.$scope, { item: item, ctrl: _this });
            };
            this.run = function (job) {
                window.open('/admin/cron-jobs/run/' + job.cron_job_id, 'popup', 'width=640,height=480');
            };
            this.clone = function (job) {
                var gettext = _this.gettext;
                _this.$ui.prompt(gettext('Enter job name'), gettext('new-job-name')).then(function (name) {
                    job.clone().attr('name', name).save(gettext('Job duplicated'));
                });
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
        return JobListController;
    }());
    Admin.JobListController = JobListController;
    angular.module('jobListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('jobListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', JobListController]);
})(Admin || (Admin = {}));
