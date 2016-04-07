<div class="row" ng-show="currentNav === 1">
    <div class="col-xs-12" style="text-align: center;">
        <h3>
            Give us your films... before it is too late.
        </h3>
        <h4>
            # Films: @{{ films.length }} | # total categories: @{{ totalCategoryCount() }} |
            Total Due: @{{ totalFilmsDue() | currency:'$':0 }}
        </h4>
    </div>
    <!-- forms.film.$invalid || !oneCatMinPerFilm() -->
    <form name="forms.film" novalidate>
        <div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3" style="text-align: center;">
            <button class="btn btn-info"
                    ng-click="submitFilms()"
                    ng-disabled="forms.film.$invalid || !oneCatMinPerFilm()">
                <i class="fa fa-film"></i>&nbsp;
                Submit Films
            </button>
            <button class="btn btn-success"
                    ng-disabled="films.length >= filmConfig.maxFilmsPerPerson"
                    ng-click="addFilm()">
                <i class="fa fa-plus"></i>&nbsp;
                Add Another Film
            </button>
        </div>
        <div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3" style="margin-top: 15px;">
            <div class="panel panel-info" ng-repeat="film in films track by $index">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Film #@{{ $index + 1 }}
                        <i class="fa fa-trash pull-right"
                           ng-show="$index > 0"
                           style="cursor: pointer; color: red;"
                           ng-click="removeFilm($index)"></i>
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="col-xs-12">
                        <h5 class="pull-right">
                            Registration Cost: @{{ film.cost() | currency:'$':0 }}
                        </h5>
                    </div>
                    <div class="form-group col-xs-12"
                         ng-class="{'has-error': forms.film['filmName' + $index].$invalid && forms.film['filmName' + $index].$touched}">
                        <label for="filmName@{{ $index }}">Film Name</label>
                        <input type="text"
                               required
                               maxlength="30"
                               class="form-control"
                               name="filmName@{{ $index }}"
                               id="filmName@{{ $index }}"
                               ng-model="film.name" />
                    </div>
                    <div class="form-group col-xs-12"
                         ng-class="{'has-error': forms.film['filmUrl' + $index].$invalid && forms.film['filmUrl' + $index].$touched}">
                        <label for="filmUrl@{{ $index }}">Film Source Url</label>
                        <input type="url"
                               required
                               class="form-control"
                               name="filmUrl@{{ $index }}"
                               id="filmUrl@{{ $index }}"
                               ng-model="film.source_url" />
                    </div>
                    <div class="form-group col-xs-12"
                         ng-class="{'has-error': (forms.film['filmMinutes' + $index].$invalid && forms.film['filmMinutes' + $index].$touched) || forms.film['filmMinutes' + $index].$error.max}">
                        <label for="filmMinutes@{{ $index }}">Film Running Minutes (excluding credits)</label>
                        <input type="number"
                               required
                               max="200"
                               class="form-control"
                               name="filmMinutes@{{ $index }}"
                               id="filmMinutes@{{ $index }}"
                               ng-model="film.run_length" />
                        <span class="help-block" ng-show="forms.film['filmMinutes' + $index].$error.max">
                            The max length for any film is 200 minutes
                        </span>
                    </div>
                    <div class="col-xs-12">
                        <h4>
                            Categories for this film
                        </h4>
                        <hr />
                    </div>
                    <div class="form-group col-xs-12 col-lg-6" ng-repeat="category in film.categories track by $index">
                        <div class="checkbox abc-checkbox">
                            <input type="checkbox"
                                   name="categoryCheck@{{ $index }}"
                                   id="categoryCheck@{{ $index }}"
                                   ng-model="category.selected"
                                   ng-disabled="(category.filmCount >= filmConfig.maxFilmsPerCategory) ||
                                                (!category.selected && totalCategoriesSelected(film) >= filmConfig.maxCategoriesPerFilm)"/>
                            <label for="categoryCheck@{{ $index }}">
                                @{{ category.name }}
                                <span ng-show="category.filmCount >= filmConfig.maxFilmsPerCategory"> - FULL!</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>