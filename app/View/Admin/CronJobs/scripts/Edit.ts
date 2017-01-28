/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class JobEditController {
        constructor(public $scope:any, public $minute:any, public $ui:any, public $timeout:ng.ITimeoutService,
                    public gettext:angular.gettext.gettextFunction, public gettextCatalog:angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');

            $scope.job = $scope.jobs[0] || $scope.jobs.create().attr('enabled', true).attr('type', 'action').attr('schedules_json', [{}]).attr('advanced', false);
            $scope.data = {types: {action: 'PHP Controller', script: 'PHP Script', route: 'Ping route (URL)'}};
        }

        save = () => {
            this.$scope.job.save(this.gettext('Job saved successfully'));
        };
    }

    angular.module('jobEditApp', ['MinuteFramework', 'AdminApp', 'gettext', 'nya.bootstrap.select'])
        .controller('jobEditController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', JobEditController]);
}
