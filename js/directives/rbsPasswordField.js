(function () {

	"use strict";

	var	app = angular.module('RbsChangeWebInstaller');

	app.directive('rbsPasswordField', ['RbsChange.i18n', function (i18n)
	{
		function checkPassword (password)
		{
			var score = 0;
			if (! password || password.length < 4) {
				return 0;
			}
			if (password.length >= 6) {
				score++;
			}
			if (password.length >= 8) {
				score++;
			}
			if (password.match(/\d+/)) {
				score++;
			}
			if (password.match(/[a-z]/) && password.match(/[A-Z]/)) {
				score++;
			}
			if (password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,£,(,)]/)) {
				score++;
			}
			return score;
		}

		var	thresholds = [ 'danger', 'warning', 'warning', 'warning', 'info', 'success'],
			statuses   = [ i18n.trans('bad'), i18n.trans('medium'), i18n.trans('medium'), i18n.trans('medium'), i18n.trans('good'), i18n.trans('very good') ];

		return {
			'restrict' : 'A',
			'require'  : 'ngModel',
			'templateUrl' : 'js/directives/rbsPasswordField.php',

			'scope' : true,

			'compile' : function (tElement, tAttrs)
			{
				if (tAttrs.inputName) {
					tElement.find('[role=password]').attr('name', tAttrs.inputName);
				}
				if (tAttrs.inputId) {
					tElement.find('[role=password]').attr('id', tAttrs.inputId);
				}
				if (tAttrs.required) {
					tElement.find('[role=password]').attr('required', tAttrs.required);
				}

				return function link (scope, iElement, iAttrs, ngModel)
				{
					function validatePassword (password)
					{
						if (scope.password !== scope.confirmation) {
							ngModel.$setValidity('confirmation', false);
							ngModel.$setViewValue(undefined);
							iElement.find('input').addClass('has-error');
						}
						else {
							ngModel.$setValidity('confirmation', true);
							ngModel.$setViewValue(password);
							iElement.find('input').removeClass('has-error');
						}
					}

					scope.$watch('password', function () {
						validatePassword();
						var score = checkPassword(scope.password);
						scope.percent = Math.min(100, (score + 1) * 16.67);
						scope.pbStyle = thresholds[score];
						scope.pbText = statuses[score];
					}, true);
					scope.$watch('confirmation', validatePassword, true);
				};
			}
		};
	}]);

})();