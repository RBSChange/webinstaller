<div class="container" ng-controller="RbsChange_WebInstaller_Welcome">
	<div class="jumbotron">
		<div class="container">
			<h1><img style="vertical-align: baseline;" src="img/logo-change@2x.png"/> RBS Change</h1>
			<p i18n="welcome.message1"></p>
			<p i18n="welcome.message2"></p>
			<p i18n="welcome.message3"></p>
			<p>
				<div class="btn-group pull-right">
					<a class="btn btn-lg btn-default" href="?l=fr_FR#/welcome" ng-class="{'active': localeIs('fr_FR')}">Français</a>
					<a class="btn btn-lg btn-default" href="?l=en_US#/welcome" ng-class="{'active': localeIs('en_US')}">English</a>
				</div>
				<a class="btn btn-primary btn-lg" href="#/checks"><span i18n="welcome.start"></span> <i class="glyphicon glyphicon-arrow-right"></i></a>
			</p>
		</div>
	</div>
</div>