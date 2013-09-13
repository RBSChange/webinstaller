<div class="container" ng-controller="RbsChange_WebInstaller_Settings">

	<div class="page-header">
		<h1>RBS Change
			<small i18n="settings.title"></small>
		</h1>
	</div>

	<form role="form" name="settings" novalidate="" class="form-horizontal" ng-submit="submit()">

		<fieldset>
			<legend>
				<i class="glyphicon glyphicon-globe"></i> <span i18n="settings.website"></span>
			</legend>

			<div class="col-md-4 col-md-push-8" i18n="settings.website-help-text">
			</div>

			<div class="col-md-8 col-md-pull-4">
				<div class="form-group" ng-class="{ 'has-error': settings.websiteUrl.$invalid && settings.websiteUrl.$dirty }">
					<label for="inputWebsiteUrl" class="col-md-4 control-label" i18n="settings.website-url"></label>
					<div class="col-md-8">
						<input type="url" name="websiteUrl" ng-model="websiteUrl" class="form-control" id="inputWebsiteUrl" required="required" placeholder="{{ 'settings.website-url-placeholder' | i18n }}"/>
					</div>
				</div>

				<div class="form-group" ng-class="{ 'has-error': settings.websiteDocumentRoot.$invalid }">
					<label for="inputWebsiteDocumentRoot" class="col-md-4 control-label" i18n="settings.website-document-root"></label>
					<div class="col-md-8">
						<input class="form-control" name="websiteDocumentRoot" id="inputWebsiteDocumentRoot" type="text" required="required" ng-model="websiteDocumentRoot" disabled/>
					</div>
				</div>
			</div>
		</fieldset>

		<fieldset>
			<legend>
				<i class="glyphicon glyphicon-cog"></i> <span i18n="settings.db"></span>
			</legend>

			<div class="col-md-4 col-md-push-8" i18n="settings.db-help-text">
			</div>

			<div class="col-md-8 col-md-pull-4">
				<div class="form-group">
					<label for="inputDbEngine" class="col-md-4 control-label" i18n="settings.db-type"></label>
					<div class="col-md-8">
						<select class="form-control" name="dbEngine" ng-model="dbEngine" id="inputDbEngine" required="required" ng-options="engine.id as engine.label for engine in dbEngines"></select>
					</div>
				</div>

				<div ng-switch="dbEngine">
					<div ng-switch-when="mysql">
						<div class="form-group" ng-class="{ 'has-error': settings.dbDatabase.$invalid && settings.dbDatabase.$dirty }">
							<label for="inputDbDatabase" class="col-md-4 control-label" i18n="settings.db-database"></label>
							<div class="col-md-8">
								<input type="text" name="dbDatabase" ng-model="mysql.database" class="form-control" id="inputDbDatabase" required="required" placeholder="{{ 'settings.db-database-placeholder' | i18n }}"/>
							</div>
						</div>
						<div class="form-group" ng-class="{ 'has-error': settings.dbUser.$invalid && settings.dbUser.$dirty }">
							<label for="inputDbUser" class="col-md-4 control-label" i18n="settings.db-user"></label>
							<div class="col-md-8">
								<input type="text" name="dbUser" ng-model="mysql.user" class="form-control" id="inputDbUser" required="required" placeholder="{{ 'settings.db-user-placeholder' | i18n }}"/>
							</div>
						</div>
						<div class="form-group" ng-class="{ 'has-warning': settings.dbPassword.$dirty && ! dbPassword }">
							<label for="inputDbPassword" class="col-md-4 control-label" i18n="settings.db-password"></label>
							<div class="col-md-8">
								<input type="password" name="dbPassword" ng-model="mysql.password" class="form-control" id="inputDbPassword" placeholder="{{ 'settings.db-password-placeholder' | i18n }}"/>
							</div>
						</div>
						<div class="form-group" ng-class="{ 'has-error': settings.dbHost.$invalid && settings.dbHost.$dirty }">
							<label for="inputDbHost" class="col-md-4 control-label" i18n="settings.db-host"></label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="text" name="dbHost" ng-model="mysql.host" class="form-control" id="inputDbHost" required="required" placeholder="{{ 'settings.db-host-placeholder' | i18n }}"/>
									<span class="input-group-btn">
										<button class="btn btn-default" type="button" ng-click="mysql.host = '127.0.0.1'" i18n="settings.db-host-same-server"></button>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group" ng-class="{ 'has-error': settings.dbPort.$invalid && settings.dbPort.$dirty }">
							<label for="inputDbPort" class="col-md-4 control-label" i18n="settings.db-port"></label>
							<div class="col-md-4">
								<div class="input-group">
									<input type="number" name="dbPort" ng-model="mysql.port" class="form-control" id="inputDbPort" required="required"/>
									<span class="input-group-btn">
										<button class="btn btn-default" type="button" ng-click="mysql.port = 3306" i18n="settings.db-port-use-default"></button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div ng-switch-when="sqlite">
						<div class="form-group" ng-class="{ 'has-error': settings.dbFile.$invalid && settings.dbFile.$dirty }">
							<label for="inputSqliteFile" class="col-md-4 control-label" i18n="settings.db-sqlite-file"></label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="text" name="dbFile" ng-model="sqlite.file" class="form-control" id="inputSqliteFile" required="required" placeholder="{{ 'settings.db-sqlite-file-placeholder' | i18n }}"/>
									<span class="input-group-btn">
										<button class="btn btn-default" type="button" ng-click="sqlite.file = dbDefaultFile" i18n="settings.db-sqlite-default-file"></button>
									</span>
								</div>
								<span class="help-block" i18n="settings.db-sqlite-file-help"></span>
							</div>
						</div>
					</div>
				</div>
			</div>

		</fieldset>


		<fieldset>
			<legend>
				<i class="glyphicon glyphicon-user"></i> <span i18n="settings.admin"></span>
			</legend>

			<div class="col-md-4 col-md-push-8">
				<span i18n="settings.admin-help-text"></span>
			</div>

			<div class="col-md-8 col-md-pull-4">
				<div class="form-group" ng-class="{ 'has-error': settings.adminEmail.$invalid && settings.adminEmail.$dirty }">
					<label for="inputAdminEmail" class="col-md-4 control-label" i18n="settings.admin-email"></label>
					<div class="col-md-8">
						<input type="email" name="adminEmail" ng-model="adminEmail" class="form-control" id="inputAdminEmail" required="required" placeholder="{{ 'settings.admin-email-placeholder' | i18n }}"/>
					</div>
				</div>

				<div class="form-group" ng-class="{ 'has-error': settings.adminPassword.$invalid && settings.adminPassword.$dirty }">
					<label for="inputAdminPassword" class="col-md-4 control-label" i18n="settings.admin-password"></label>
					<div class="col-md-8">
						<div rbs-password-field ng-model="adminPassword" input-id="inputAdminPassword" name="adminPassword" required="required"></div>
					</div>
				</div>
			</div>

		</fieldset>

		<div class="row" ng-hide="busy">
			<div class="col-md-8">
				<div class="col-md-8 col-md-offset-4">
					<a class="btn btn-default btn-lg" href="#/checks"><i class="glyphicon glyphicon-chevron-left"></i> <span i18n="back"></span></a>
					<button type="submit" ng-disabled="settings.$invalid || adminConfirmPassword != adminPassword" class="btn btn-primary btn-lg"><span i18n="continue"></span> <i class="glyphicon glyphicon-chevron-right"></i></button>
				</div>
			</div>
		</div>


		<div class="row" ng-if="busy">
			<h4>Avancement : {{ percent|number:0 }}%</h4>
			<div class="progress">
				<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{ percent }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ percent }}%"></div>
			</div>
		</div>

	</form>

</div>