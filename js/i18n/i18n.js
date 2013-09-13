(function () {

	"use strict";

	var	app = angular.module('RbsChangeWebInstaller');

	app.service('RbsChange.i18n', function ()
	{
		var	locale = document.getElementsByTagName('html')[0].lang,
			strings;

		function trans (key) {
			return strings.hasOwnProperty(key) ? strings[key] : key;
		}

		function getLocale () {
			return locale;
		}

		function setStrings (s) {
			strings = s;
		}

		return {
			getLocale : getLocale,
			trans : trans,
			setStrings : setStrings
		};
	});

	app.run(['RbsChange.i18n', '$rootScope', function (i18n, $rootScope)
	{
		$rootScope.localeIs = function localeIsFn (lc) {
			return i18n.getLocale() === lc;
		};
	}]);

	app.directive('i18n', ['RbsChange.i18n', function (i18n)
	{
		return {
			'restrict' : 'A',
			'link' : function (scope, iElement, iAttrs) {
				iElement.html(i18n.trans(iAttrs.i18n));
			}
		};
	}]);

	app.filter('i18n', ['RbsChange.i18n', function (i18n)
	{
		return function (input) {
			return i18n.trans(input);
		};
	}]);

})();