/*
* Angular Directive that controls the ticket picker
*
* @params none
*
* @returns directive object
*/

function TicketPicker() {
    return {
        restrict: 'E',
        scope: {
            categories: '=',
            maxFilmsPerCategory: '='
        },
        templateUrl: './partials/ticketPicker.html',
        link: function (scope, element, attrs) {
            scope.rows = ['A', 'B', 'C', 'D', 'E'];
            scope.seats = [1,2,3,4,5,6,7,8,9,10];
            scope.myTickets = {};
            scope.picked = 0;
            scope.$watch('categories', function (cat) {
                if(angular.isArray(cat) && !scope.currentCategory){
                    scope.currentCategory = cat[0];
                } 
            });

            scope.switchCategory = function (cat) {
                scope.currentCategory = cat;
            };

            scope.seatStatus = function (row, seat) {
                if(scope.currentCategory){
                    for (var i = 0; i < scope.currentCategory.tickets.length; i++) {
                        if(scope.currentCategory.tickets[i].row === row && scope.currentCategory.tickets[i].seat === seat){
                            if(scope.currentCategory.tickets[i].picked) return 'picked';
                            else if(scope.currentCategory.tickets[i].user_id === null) return 'open';
                            else return 'taken';
                        }
                    }
                }
            };
            
            scope.pickSeat = function (row, seat) {
                for (var i = 0; i < scope.currentCategory.tickets.length; i++) {
                    if(scope.currentCategory.tickets[i].row === row && scope.currentCategory.tickets[i].seat === seat){
                        if(scope.currentCategory.tickets[i].user_id === null) {
                            if(scope.currentCategory.tickets[i].picked){
                                scope.currentCategory.tickets[i].picked = false;
                                scope.picked--;
                            }
                            else{
                                scope.currentCategory.tickets[i].picked = true;
                                scope.picked++;
                            }
                            break;
                        }
                    }
                }
            };
            
            
        }
    }
}