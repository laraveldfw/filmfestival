/*
* Compiling register page app
*
* @params none
*
* @returns none
*/

var registerApp = angular.module('RegisterApp', [])
    .value('pwdTester', zxcvbn)
    .value('filmConfig', filmConfig)
    .value('ticketCost', ticketCost)
    .value('categories', categories)
    .directive('ticketPicker', TicketPicker)
    .service('AuthService', AuthService)
    .controller('RegisterController', RegisterController);