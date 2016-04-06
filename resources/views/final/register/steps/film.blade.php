<div class="row" ng-show="currentNav === 1">
    <div class="col-xs-12">
        <h3 class="text-center">
            Give us your films... before it is too late.
        </h3>
    </div>
    <form name="forms.film" novalidate>
        <div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3">
            <div class="panel panel-info" ng-repeat="film in films">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Film #@{{ $index + 1 }}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="form-group col-xs-12"
                         ng-class="{'has-error': forms.film['filmName' + $index].$invalid && forms.film['filmName' + $index].$touched}">
                        <label for="filmName@{{ $index }}">Film Name</label>
                        <input type="text"
                               required
                               maxlength="30"
                               name="filmName@{{ index }}"
                               id="filmName@{{ $index }}"
                               ng-model="film.name" />
                    </div>
                    <div class="form-group col-xs-12"
                         ng-class="{'has-error': forms.film['filmUrl' + $index].$invalid && forms.film['filmUrl' + $index].$touched}">
                        <label for="filmUrl@{{ $index }}">Film Source Url</label>
                        <input type="url"
                               required
                               name="filmUrl@{{ index }}"
                               id="filmUrl@{{ $index }}"
                               ng-model="film.source_url" />
                    </div>
                    <div class="form-group col-xs-12"
                         ng-class="{'has-error': forms.film['filmMinutes' + $index].$invalid && forms.film['filmMinutes' + $index].$touched}">
                        <label for="filmMinutes@{{ $index }}">Film Running Minutes (excluding credits)</label>
                        <input type="number"
                               required
                               max="200"
                               name="filmMinutes@{{ index }}"
                               id="filmMinutes@{{ $index }}"
                               ng-model="film.run_length" />
                        <span class="help-block" ng-show="forms.film['filmMinutes' + $index].$error.max">
                            The max length for any film is 200 minutes
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>