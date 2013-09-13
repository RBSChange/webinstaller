<?php
$locale = isset($_GET['l']) ? $_GET['l'] : 'en_US';
if (! preg_match('/^[a-z]{2}_[A-Z]{2}$/', $locale))
{
	$locale = 'en_US';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $locale; ?>" ng-app="RbsChangeWebInstaller">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="DOCUMENT_ROOT" content="<?php echo dirname(__DIR__) ?>" />
	<title>RBS Change - Web Installer</title>
	<link rel="icon" type="image/png" href="img/rbschange-favicon.png" />
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="css/installer.css" rel="stylesheet" />
</head>
<body>
	<div class="ng-view"></div>
	<script type="text/javascript" src="lib/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="lib/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="lib/angular/angular.min.js"></script>
	<script type="text/javascript" src="lib/angular/angular-route.min.js"></script>
	<script type="text/javascript" src="lib/angular/angular-sanitize.min.js"></script>
	<script type="text/javascript" src="lib/angular/angular-touch.min.js"></script>
	<script type="text/javascript" src="lib/angular/angular-animate.min.js"></script>
	<script type="text/javascript" src="js/controllers.js"></script>
	<script type="text/javascript" src="js/i18n/i18n.js"></script>
	<script type="text/javascript" src="js/i18n/<?php echo $locale; ?>.js"></script>
	<script type="text/javascript" src="js/directives/rbsPasswordField.js"></script>
</body>
</html>