/*
* Angular controller for register page
*
* @params $scope
*
* @returns none
*/

RegisterController.$inject = ['$scope', 'pwdTester', 'AuthService', 'filmConfig', 'ticketCost'];

function RegisterController($scope, pwdTester, AuthService, filmConfig, ticketCost) {
    
    $scope.navItems = [
        {
            text: 'Create An Account',
            icon: 'fa-user'
        },
        {
            text: 'Upload Your Film',
            icon: 'fa-film'
        },
        {
            text: 'Purchase Showdown Tickets',
            icon: 'fa-ticket'
        }
    ];
    $scope.currentNav = 0;


    //<editor-fold desc="Create Account">
    $scope.pwdStates = [
        'Very Weak',
        'Weak',
        'Better...',
        'Good',
        'Awesome'
    ];
    $scope.pwdFeedback = {
        score: 0
    };

    var lastEmail;
    $scope.isEmailUnique = function () {
        if($scope.register.email && $scope.forms.account.email.$valid){
            $scope.emailSearching = true;
            lastEmail = angular.copy($scope.register.email);
            AuthService.isEmailUnique($scope.register.email)
                .then(function (response) {
                    if(response.data.success){
                        $scope.foundEmail = '';
                    }
                    else{
                        $scope.foundEmail = lastEmail;
                    }
                    $scope.emailSearching = false;
                }, function (error) {
                    if(error.data.email[0] === 'The email has already been taken.'){
                        $scope.foundEmail = lastEmail;
                    }
                    $scope.emailSearching = false;
                });
        }
    };
    
    $scope.checkPwdStrength = function () {
        if($scope.register.pwd && $scope.forms.account.pwd.$valid){
            $scope.pwdFeedback = pwdTester($scope.register.pwd, [$scope.register.email]);
        }  
    };
    
    $scope.registerAccount = function () {
        $scope.registering = true;
        AuthService.registerAccount($scope.register.name, $scope.register.email, $scope.register.pwd)
            .then(function () {
                $scope.registrationEmailSent = true;
                $scope.registering = false;
            }, function (error) {
                console.log(error);
                $scope.registering = false;
            });
    };
    
    $scope.checkConfirmation = function () {
        if($scope.confirmation && $scope.confirmation.length === 32){
            $scope.checkingConfirmation = true;
            AuthService.checkConfirmation($scope.confirmation)
                .then(function (response) {
                    $scope.user = response.data.user;
                    $scope.checkingConfirmation = false;
                }, function (error) {
                    $scope.checkingConfirmation = false;
                });
        }
    };
    //</editor-fold>
    
    var filmTemplate = {
        name: null,
        source_url: null,
        categories: [],
        run_length: null,
        cost: function () {
            return filmConfig.registrationCost + (this.categories.length * filmConfig.extraCategoryCost);
        }
    };
    $scope.films = [filmTemplate];
    
    $scope.addFilm = function () {
        if($scope.films.length < filmConfig.maxFilms){
            $scope.films.push(filmTemplate);
        }
    };
    
    $scope.removeFilm = function (index) {
        $scope.films.splice(index, 1);  
    };
    
}