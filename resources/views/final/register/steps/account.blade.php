<div class="row" ng-show="currentNav === 0">
    <div class="col-xs-12" ng-hide="user">
        <h3 class="text-center">
            Create an account to get started...
        </h3>
    </div>
    <form name="forms.account"
          novalidate
          ng-submit="registerAccount()">
        <div class="col-xs-12">
            <div class="row"  ng-hide="registrationEmailSent || user">
                <div class="form-group col-xs-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3"
                     ng-class="[{'has-error': forms.account.name.$invalid && forms.account.name.$touched},
                        {'has-succes': forms.account.name.$valid}]">
                    <label for="name">Name</label>
                    <input type="text"
                           required
                           name="name"
                           id="name"
                           ng-disabled="registering"
                           class="form-control"
                           maxlength="255"
                           ng-class="{'animated jello': forms.account.name.$invalid && forms.account.name.$touched}"
                           ng-model="register.name" />
                </div>
                <div class="form-group col-xs-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3"
                     ng-class="[{'has-error': (forms.account.email.$invalid && forms.account.email.$touched) || foundEmail},
                        {'has-success': forms.account.email.$valid && !emailSearching && !foundEmail}]">
                    <label for="email">Email</label>
                    <input type="email"
                           required
                           name="email"
                           id="email"
                           ng-disabled="registering"
                           ng-class="{'animated jello': (forms.account.email.$invalid && forms.account.email.$touched) || foundEmail}"
                           class="form-control"
                           ng-change="isEmailUnique()"
                           ng-model-options="{debounce: 250}"
                           ng-model="register.email" />
                    <span class="help-block" ng-show="foundEmail">
                        That email already exists in the system
                    </span>
                </div>
                <div class="form-group col-xs-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3"
                     ng-class="[{'has-error':
                        (forms.account.pwd.$invalid || pwdFeedback.score < 3) &&
                        forms.account.pwd.$touched}, {'has-success': pwdFeedback.score >= 3}]">
                    <label for="pwd">Password</label>
                    <input type="password"
                           required
                           name="pwd"
                           id="pwd"
                           class="form-control"
                           maxlength="72"
                           ng-disabled="registering"
                           ng-class="{'animated jello':
                            (forms.account.pwd.$invalid || pwdFeedback.score < 3) &&
                            forms.account.pwd.$touched}"
                           ng-change="checkPwdStrength()"
                           ng-model="register.pwd" />
                    <span class="help-block" ng-show="forms.account.pwd.$touched && pwdFeedback.feedback.suggestions.length > 0">
                        <span ng-show="register.pwd === register.email">
                            Email and password can not be the same <br>
                        </span>
                        <span ng-repeat="suggestion in pwdFeedback.feedback.suggestions">
                            @{{ suggestion }}<br>
                        </span>
                    </span>
                </div>
                <div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3" ng-show="register.pwd">
                    <div class="progress">
                        <div class="progress-bar"
                             role="progressbar"
                             aria-valuenow="@{{ pwdFeedback.score * 25 }}"
                             aria-valuemin="0"
                             aria-valuemax="100"
                             style="min-width: 9em;"
                             ng-class="[{'progress-bar-danger': pwdFeedback.score < 2},
                                {'progress-bar-warning': pwdFeedback.score === 2},
                                {'progress-bar-success': pwdFeedback.score > 2}]"
                             ng-style="{width: (pwdFeedback.score * 25) + '%'}">
                            @{{ pwdStates[pwdFeedback.score] }}
                        </div>
                    </div>
                </div>
                <div class="form-group col-xs-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3"
                     ng-class="[{'has-error':
                        (forms.account.pwd2.$invalid || register.pwd !== register.pwd_confirmed) &&
                        forms.account.pwd2.$touched},
                        {'has-success': register.pwd === register.pwd_confirmed && pwdFeedback.score >= 3}]">
                    <label for="pwd2">Confirm Password</label>
                    <input type="password"
                           required
                           name="pwd2"
                           id="pwd2"
                           class="form-control"
                           ng-disabled="!(pwdFeedback.score >= 3) || registering"
                           ng-class="{'animated jello':
                               (forms.account.pwd2.$invalid || register.pwd !== register.pwd_confirmed) &&
                               forms.account.pwd2.$touched}"
                           ng-model="register.pwd_confirmed" />
                    <span class="help-block"
                          ng-show="(forms.account.pwd2.$invalid || register.pwd !== register.pwd_confirmed) &&
                                       forms.account.pwd2.$touched">
                        Passwords do not match
                    </span>
                </div>
                <div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3">
                    <button type="submit"
                            class="btn pull-right"
                            ng-class="(forms.account.$invalid ||
                                pwdFeedback.score < 3 ||
                                foundEmail ||
                                register.pwd !== register.pwd_confirmed) ? 'btn-default' : 'btn-primary'"
                            ng-disabled="forms.account.$invalid ||
                                pwdFeedback.score < 3 ||
                                foundEmail ||
                                registering ||
                                register.pwd !== register.pwd_confirmed">
                        Submit
                    </button>
                </div>
            </div>
            <div class="row" ng-show="registrationEmailSent && !user">
                <div class="form-group col-xs-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3"
                     ng-class="{'has-error': badConfirmation}">
                    <label for="confirmation">Confirmation Code (emailed to you)</label>
                    <input type="text"
                           ng-required="registrationEmailSent"
                           class="form-control"
                           name="confirmation"
                           id="confirmation"
                           ng-disabled="checkingConfirmation"
                           ng-change="checkConfirmation()"
                           ng-model="confirmation" />
                </div>
            </div>
            <div class="row" ng-show="user">
                <div class="col-xs-12" style="text-align: center;">
                    <h3>
                        Congratulations @{{ user.name }} <br>
                        You can enjoy the End Of The World with us!
                    </h3>
                    <button class="btn btn-info btn-lg" ng-click="currentNav = 1">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>