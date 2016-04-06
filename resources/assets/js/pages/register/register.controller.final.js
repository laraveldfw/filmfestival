/*
* Angular controller for register page
*
* @params $scope
*
* @returns none
*/

RegisterController.$inject = ['$scope', 'pwdTester', 'AuthService'];

function RegisterController($scope, pwdTester, AuthService) {
    
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
        AuthService.registerAccount($scope.register.name, $scope.register.email, $scope.register.pwd)
            .then(function () {
                $scope.registrationEmailSent = true;
            }, function (error) {
                console.log(error);
            })
    }
    
}