<div class="row" ng-show="currentNav === 2">
    <div class="col-xs-12">
        <h3 class="text-center">
            Purchase Showdown Tickets
        </h3>
        <hr />
    </div>
    <div class="col-xs-12">
        <ticket-picker categories="categoryTickets"
                       maxFilmsPerCategory="filmConfig.maxFilmsPerCategory"></ticket-picker>
    </div>
    <div class="col-xs-12" style="margin-top: 20px; text-align: center;">
        <button class="btn btn-success btn-lg" ng-click="payForAll()">
            <i class="fa fa-flag-checkered"></i>&nbsp;
            Pay For Film Registration And Tickets
        </button>
    </div>
</div>