/*
* Compiling register page app
*
* @params none
*
* @returns none
*/

var registerApp = angular.module('RegisterApp', [])
    .value('pwdTester', zxcvbn)
    .service('AuthService', AuthService)
    .controller('RegisterController', RegisterController);