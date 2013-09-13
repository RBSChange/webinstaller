<div class="container" ng-controller="RbsChange_WebInstaller_CheckSystem">

	<div class="page-header">
		<h1>RBS Change
			<small i18n="check.title"></small>
		</h1>
	</div>

	<div class="alert alert-info" ng-if="busy" i18n="check.checking">
	</div>

	<div ng-if="! busy && ! errors">
		<div class="alert alert-success">
			<h4><i class="glyphicon glyphicon-thumbs-up"></i> <span i18n="check.great-news"></span></h4>
			<span i18n="check.server-is-ok"></span>
		</div>
		<div class="btn-toolbar">
			<a class="btn btn-default btn-lg" href="#/welcome"><i class="glyphicon glyphicon-chevron-left"></i> <span i18n="back"></span></a>
			<a href="#/settings" class="btn btn-primary btn-lg"><span i18n="continue"></span> <i class="glyphicon glyphicon-chevron-right"></i></a>
		</div>
	</div>

	<div class="alert alert-danger" ng-if="! busy && errors">
		<h4><i class="glyphicon glyphicon-thumbs-down"></i> <span i18n="check.bad-news"></span></h4>
		<span i18n="check.server-is-not-OK"></span>
		<ul>
			<li ng-repeat="err in errors">{{ err }}</li>
		</ul>
	</div>
</div>