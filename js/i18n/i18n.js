(function () {

	"use strict";

	var	app = angular.module('RbsChangeWebInstaller');

	app.service('RbsChange.i18n', function ($rootScope)
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

		$rootScope.localeIs = function localeIsFn (lc) {
			return locale === lc;
		};

		return {
			getLocale : getLocale,
			trans : trans,
			setStrings : setStrings
		};
	});

	/**
	 * Usage: <span i18n="my.localization.key"></span>
	 */
	app.directive('i18n', ['RbsChange.i18n', function (i18n)
	{
		return {
			'restrict' : 'A',
			'link' : function (scope, iElement, iAttrs) {
				iElement.html(i18n.trans(iAttrs.i18n));
			}
		};
	}]);

	/**
	 * Usage: <input ... placeholder="{{ 'my.localization.key' | i18n }}">
	 */
	app.filter('i18n', ['RbsChange.i18n', function (i18n)
	{
		return function (input) {
			return i18n.trans(input);
		};
	}]);

})();