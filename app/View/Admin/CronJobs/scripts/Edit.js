/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var JobEditController = (function () {
        function JobEditController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.save = function () {
                _this.$scope.job.save(_this.gettext('Job saved successfully'));
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.job = $scope.jobs[0] || $scope.jobs.create().attr('enabled', true).attr('type', 'action').attr('schedules_json', [{}]).attr('advanced', false);
            $scope.data = { types: { action: 'PHP Controller', script: 'PHP Script', route: 'Ping route (URL)' } };
        }
        return JobEditController;
    }());
    Admin.JobEditController = JobEditController;
    angular.module('jobEditApp', ['MinuteFramework', 'AdminApp', 'gettext', 'nya.bootstrap.select'])
        .controller('jobEditController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', JobEditController]);
})(Admin || (Admin = {}));
