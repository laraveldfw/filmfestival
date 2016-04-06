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
    .service('AuthService', AuthService)
    .controller('RegisterController', RegisterController);