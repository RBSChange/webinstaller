(function () {

	"use strict";

	var	app = angular.module('RbsChangeWebInstaller', ['ngRoute']),
		availDbEngines = [];

	app.config(['$routeProvider', function ($routeProvider)
	{
		$routeProvider
			. when('/settings', { templateUrl : 'tpl/settings.php', reloadOnSearch : false })
			. when('/checks', { templateUrl : 'tpl/checks.php', reloadOnSearch : false })
			. when('/welcome', { templateUrl : 'tpl/welcome.php', reloadOnSearch : false })
			. when('/end', { templateUrl : 'tpl/end.php', reloadOnSearch : false })
			.otherwise({ redirectTo: '/welcome'})
		;
	}]);


	function checkResults (results)
	{
		var errors = [];
		if (! results['php_version']) {
			errors.push('php_version');
		}
		angular.forEach(results['php_ext'], function (value, name) {
			if (name.substr(0, 4) === 'pdo_') {
				if (value) {
					availDbEngines.push(name.substr(4));
				}
			}
			else if (! value) {
				errors.push(name);
			}
		});
		if (! availDbEngines.length) {
			errors.push('no-db-engines');
		}
		if (errors.length) {
			return errors;
		}
		return null;
	}


	app.controller('RbsChange_WebInstaller_Welcome', function ($scope)
	{
	});


	app.controller('RbsChange_WebInstaller_CheckSystem', function ($scope, $http)
	{
		$scope.busy = true;
		$http.get('rest/check-system.php').then(function (results) {
			$scope.errors = checkResults(results.data);
			$scope.busy = false;
		});
	});


	app.controller('RbsChange_WebInstaller_Settings', function ($scope, $http, $location, $q)
	{
		$scope.busy = false;
		$scope.dbEngines = [];
		if (! availDbEngines.length) {
			availDbEngines = ['mysql', 'sqlite'];
		}
		angular.forEach(availDbEngines, function (engine) {
			$scope[engine] = {};
			$scope.dbEngines.push({
				'id' : engine,
				'label' : engine
			});
		});

		$scope.dbEngine = $scope.dbEngines[0].id;
		$scope.dbDefaultFile = 'Sqlite.db';

		$scope.mysql = {
			port : 3306,
			host : '127.0.0.1'
		};
		$scope.sqlite = {
			file : $scope.dbDefaultFile
		};

		var	p, url = $location.absUrl();

		p = url.indexOf('?');
		if (p !== -1) {
			url = url.substring(0, p);
		}
		p = url.indexOf('/install/');
		if (p === url.length - 9) {
			url = url.substring(0, p);
		}
		$scope.websiteUrl = url + '/index.php';
		$scope.websiteDocumentRoot = $('meta[name="DOCUMENT_ROOT"]').attr('content');


		$scope.submit = function ()
		{
			var restUrl = 'rest/rest.php/';

			saveConfiguration().then(
				function () {
					initializeProject().then(
						function () {
							console.log("All commands OK");
							//$location.path('/end');
						},
						function (result) {
							console.warn("Commands error: ", result);
							$scope.busy = false;
						}
					);
				},
				function (result) {
					console.warn("Save configuration failed: ", result);
				}
			);


			//
			// Save configuration
			//

			function saveConfiguration ()
			{
				var defer = $q.defer(), config = {};

				config.type = $scope.dbEngine;
				angular.extend(config, $scope[config.type]);

				$http.get(makeUrl(restUrl + 'config/setDbConfig', config))
					.success(function (result) {
						console.log("save config success: ", result);
						defer.resolve(result);
					})
					.error(function (result) {
						console.log("save config error: ", result);
						defer.reject(result);
					});

				return defer.promise;
			}


			//
			// Execute commands
			// See https://github.com/RBSChange/Change/wiki
			//

			function initializeProject ()
			{
				var defer = $q.defer(), commands, step;

				commands = [
					{ 'name': 'change:set-document-root', 'params' : { 'path': $scope.websiteDocumentRoot } },
					{ 'name': 'change:generate-db-schema' },
					{ 'name': 'change:register-plugins' },
					{ 'name': 'change:install-package', 'params' : { 'vendor': 'Rbs', 'name': 'Core' } },
					{ 'name': 'change:install-package', 'params' : { 'vendor': 'Rbs', 'name': 'ECom' } },
					{ 'name': 'change:install-plugin', 'params' : { 'vendor': 'Rbs', 'name': 'Demo', 'type': 'theme' } },
					{ 'name': 'rbs_website:add-default-website', 'params' : { 'baseURL': $scope.websiteUrl } }
				];

				defer = $q.defer();
				step = 100.0 / commands.length;
				$scope.percent = 0;
				$scope.busy = true;

				function executeNextCommand (index) {
					if (index === commands.length) {
						defer.resolve();
						return;
					}
					var command = commands[index];
					$http.get(makeUrl(restUrl + 'commands/' + command.name.replace(/:/, '/'), command.params))
						.success(function (result) {
							console.log("succes: ", result);
							index++;
							$scope.percent = Math.min(100, step * index);
							executeNextCommand(index);
						})
						.error(function (result) {
							console.log("error: ", result);
							defer.reject(result);
						});
				}

				executeNextCommand(0);

				return defer.promise;
			}

		};
	});


	function makeUrl (url, params) {
		var baseUrl = url,
			queryString = '',
			hash = '',
			urlArgs = {},
			p;

		p = url.lastIndexOf('#');
		if (p > -1) {
			baseUrl = url.substring(0, p);
			hash = url.substring(p, url.length);
		}

		p = baseUrl.indexOf('?');
		if (p > -1) {
			queryString = baseUrl.substring(p + 1, baseUrl.length);
			baseUrl = url.substring(0, p);
			angular.forEach(queryString.split('&'), function (token) {
				var param = token.split('=');
				urlArgs[param[0]] = param[1];
			});
		}

		queryString = '';
		angular.extend(urlArgs, params);
		angular.forEach(urlArgs, function (value, key) {
			if (angular.isDefined(value) && value !== null) {
				if (queryString.length > 0) {
					queryString += '&';
				}
				if (angular.isArray(value)) {
					for (p=0 ; p<value.length ; p++) {
						if (p > 0) {
							queryString += '&';
						}
						queryString += key + '[]=' + encodeURIComponent(value[p]);
					}
				} else {
					queryString += key + '=' + encodeURIComponent(value);
				}
			}
		});

		if (queryString) {
			return baseUrl + '?' + queryString + hash;
		}

		return baseUrl + hash;
	}

})();