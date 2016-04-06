@extends('app')

@section('content')
    <section ng-app="RegisterApp">
        <section ng-controller="RegisterController">
            <a href="/logout"
               class="btn btn-warning"
               ng-show="user"
               title="Sign Out"
               style="position: absolute; top: 5px; right: 5px;">
                <i class="fa fa-sign-out"></i>
            </a>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12" style="margin-top: 20px;">
                        <div class="btn-group btn-group-justified" role="group">
                            <a ng-repeat="nav in navItems"
                                href="javascript:void(0)"
                                class="btn"
                                ng-class="$index === currentNav ? 'btn-primary' : 'btn-default'"
                                ng-disabled="$index === currentNav"
                                ng-click="goToNav($index)">
                                <i class="fa" ng-class="nav.icon"></i>&nbsp;
                                @{{ nav.text }}
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-12" style="margin-top: 20px;">
                        @include('final.register.steps.account')
                        @include('final.register.steps.film')
                        @include('final.register.steps.tickets')
                    </div>
                </div>
            </div>
        </section>
    </section>
    @endsection

@section('footerScripts')
    <script>
        var categories = {!! $categories !!};

        var filmConfig = {
            registrationCost: {{ config('film.registrationCost') }},
            freeCategories: {{ config('film.freeCategories') }},
            maxCategories: {{ config('film.maxCategories') }},
            extraCategoryCost: {{ config('film.extraCategoryCost') }},
            maxFilms: {{ config('film.maxFilms') }}
        };

        var ticketCost = {{ config('ticket.cost') }};
    </script>
    <script src="{{ elixir('js/register.js') }}" type="text/javascript"></script>
    @endsection