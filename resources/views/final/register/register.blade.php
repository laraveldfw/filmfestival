@extends('app')

@section('content')
    <section ng-app="RegisterApp">
        <section ng-controller="RegisterController">
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
    <script src="{{ elixir('js/register.js') }}" type="text/javascript"></script>
    @endsection