/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var LogListController = (function () {
        function LogListController($scope, $minute, $ui, $timeout, $http, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.$http = $http;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.truncate = function () {
                _this.$ui.confirm(_this.gettext('Are you sure?')).then(function () {
                    _this.$http.post('/admin/cron-jobs/truncate/' + _this.$scope.job.cron_job_id, {}).then(function () {
                        _this.$ui.toast(_this.gettext('Logs cleared successfully!'));
                        _this.$scope.jobs.reloadAll(true);
                    });
                });
            };
            this.zoom = function (log) {
                _this.$ui.popupUrl('/zoom.html', false, null, { log: log, ctrl: _this });
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.job = $scope.jobs[0];
            $scope.logs = $scope.job.logs;
        }
        return LogListController;
    }());
    App.LogListController = LogListController;
    angular.module('logListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('logListController', ['$scope', '$minute', '$ui', '$timeout', '$http', 'gettext', 'gettextCatalog', LogListController]);
})(App || (App = {}));
