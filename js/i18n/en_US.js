(function () {
	"use strict";
	angular.module('RbsChangeWebInstaller').run(['RbsChange.i18n', function (i18n) {
		i18n.setStrings({
			'installer-title' : "RBS Change - web installer",
			'password' : "Password",
			'confirm-password' : "Confirm password",
			'continue' : "Next",
			'back' : "Back",
			'bad' : "bad",
			'medium' : "medium",
			'good' : "good",
			'very good' : "very good",

			'welcome.message1' : "Welcome to the installation process of <a href=\"http://www.rbschange.fr\" target=\"_blank\">RBS Change</a>,<br/>the <strong>open source E-commerce CMS</strong>!",
			'welcome.message2' : "The RBS Change team thanks you for having chosen its platform to manage your website!",
			'welcome.message3' : "Let's start right now the installation of your future website!",
			'welcome.start' : "Start",

			'check.title' : "System checks",
			'check.checking' : "RBS Change is checking your server's configuration...",
			'check.great-news' : "We have great news for you!",
			'check.server-is-ok' : "Your server has everything installed to get RBS Change working on it.",
			'check.bad-news' : "Oh no!",
			'check.server-is-not-OK' : "Your server is missing some components to get RBS Change working on it.",

			'settings.title' : "Settings",
			'settings.website' : "Website",
			'settings.website-help-text' : "<strong>Please type in the URL of your future website.</strong><br/>We already found a possible URL for your website, an we placed it in the corresponding text field. You can change if you know what you're doing.",
			'settings.website-url' : "Website URL",
			'settings.website-document-root' : "<em>Document Root</em>",
			'settings.website-url-placeholder' : "Website URL",
			'settings.db' : "Database",
			'settings.db-help-text' : "<strong>Please select the database type to use for your website.</strong><br/>The choices listed here depend on your server's configuration and on the capabilities of the PHP engine.",
			'settings.db-host' : "MySQL server",
			'settings.db-host-same-server' : "Same server",
			'settings.db-host-placeholder' : "Name or IP address of the MySQL server",
			'settings.db-database' : "Database",
			'settings.db-database-placeholder' : "Database name",
			'settings.db-type' : "Database type",
			'settings.db-user' : "User",
			'settings.db-user-placeholder' : "MySQL user",
			'settings.db-password' : "Password",
			'settings.db-password-placeholder' : "MySQL password",
			'settings.db-sqlite-default-file' : "Default file",
			'settings.db-sqlite-file' : "SQLite file",
			'settings.db-sqlite-file-help' : "It is recommanded not to use an absolute path here: the file will then be placed in the <strong>App</strong> directory that comes with your Change installation.",
			'settings.db-port' : "Port",
			'settings.db-port-use-default' : "Default port",
			'settings.admin' : "RBS Change's administrator account",
			'settings.admin-help-text' : "<strong>RBS Change needs a minimum set of information to create the user account for the administrator.</strong><br/>When you'll first log in, Change will suggest you to complete your user profile, with your name. And what about choosing a nice and funny avatar?",
			'settings.admin-email' : "E-mail address",
			'settings.admin-password' : "Password",
			'settings.admin-email-placeholder' : "Administrator's e-mail address"
		});
	}]);
})();