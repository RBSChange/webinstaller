<input type="password" class="form-control" ng-model="password" role="password" placeholder="{{ 'password' | i18n }}"/>
<input type="password" class="form-control" ng-model="confirmation" role="confirmation" placeholder="{{ 'confirm-password' | i18n }}"/>
<div class="progress">
<div class="progress-bar progress-bar-{{ pbStyle }}" role="progressbar" aria-valuenow="{{ percent }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ percent }}%">{{ pbText }}</div>
</div>