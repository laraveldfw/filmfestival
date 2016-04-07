/*
* Angular controller for register page
*
* @params $scope
*
* @returns none
*/

RegisterController.$inject = ['$scope', '$http', 'pwdTester', 'AuthService', 'filmConfig', 'ticketCost', 'categories'];

function RegisterController($scope, $http, pwdTester, AuthService, filmConfig, ticketCost, categories) {
    
    $scope.filmConfig = filmConfig;
    $scope.categories = categories;
    
    AuthService.checkAuth()
        .then(function (user) {
            $scope.user = user;
        });
    
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
        if(!$scope.user){
            $scope.registering = true;
            AuthService.registerAccount($scope.register.name, $scope.register.email, $scope.register.pwd)
                .then(function () {
                    $scope.registrationEmailSent = true;
                    $scope.registering = false;
                }, function (error) {
                    console.log(error);
                    $scope.registering = false;
                }); 
        }
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

    //<editor-fold desc="Film Registration">
    var filmTemplate = {
        name: null,
        source_url: null,
        categories: [],
        run_length: null,
        cost: function () {
            var cst = 0;
            for (var i = 0; i < this.categories.length; i++) {
                cst += this.categories[i].selected ? filmConfig.extraCategoryCost : 0;
            }
            return filmConfig.registrationCost + cst;
        }
    };
    for (var i = 0; i < categories.length; i++) {
        filmTemplate.categories.push(angular.copy(categories[i]));
    }
    $scope.films = [angular.copy(filmTemplate)];
    
    $scope.addFilm = function () {
        if($scope.films.length < filmConfig.maxFilmsPerPerson){
            $scope.films.push(angular.copy(filmTemplate));
        }
    };
    
    $scope.removeFilm = function (index) {
        $scope.films.splice(index, 1);  
    };
    
    $scope.totalCategoriesSelected = function (film) {
        var catCount = 0;
        for (var i = 0; i < film.categories.length; i++) {
            if(film.categories[i].selected) catCount++;
        }
        return catCount;
    };
    
    $scope.totalCategoryCount = function () {
        if(angular.isArray($scope.films)){
            var filmCatCount = 0;
            for (var i = 0, count = 0; i < $scope.films.length; i++) {
                filmCatCount += $scope.totalCategoriesSelected($scope.films[i]);
            }
            return filmCatCount;
        }
    };
    
    $scope.totalFilmsDue = function () {
        var cost = 0;
        for (var i = 0; i < $scope.films.length; i++) {
            cost += $scope.films[i].cost();
        }
        return cost;
    };

    $scope.oneCatMinPerFilm = function () {
        
        for (var i = 0; i < $scope.films.length; i++) {
            if($scope.totalCategoriesSelected($scope.films[i]) < 1){
                return false;
            }
        }
        return true;
    };

    $scope.submitFilms = function () {
        //$http request to save films?
        $scope.currentNav = 2;
    };
    //</editor-fold>

    $scope.$watch('currentNav', function (nav) {
         if(nav === 2 && !$scope.categoryTickets){
             $scope.fetchingTickets = true;
             $http.get('/getCategoryTickets')
                 .then(function (response) {
                     if(response.data.success){
                         $scope.categoryTickets = response.data.categoryTickets;
                         $scope.fetchingTickets = false;
                     }
                 }, function (error) {
                     console.error(error);
                     $scope.fetchingTickets = false;
                 })
         }
    });
}