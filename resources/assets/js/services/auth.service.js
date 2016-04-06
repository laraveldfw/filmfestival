/*
* Angular service that helps with auth related activities
*
* @params $log, $http
*
* @returns none
*/

AuthService.$inject = ['$log', '$http', '$q'];

function AuthService($log, $http, $q) {
    
    var self = this;
    
    /****  Private Variables  ****/
    var user;
    
    /****  Public Variables  ****/
    
    
    /****  Initializations  ****/
    
    
    /****  Public Functions  ****/
    self.checkAuth         = checkAuth;
    self.getUser           = getUser;
    self.isEmailUnique     = isEmailUnique;
    self.registerAccount   = registerAccount;
    self.checkConfirmation = checkConfirmation;
    
    /****  Private Functions  ****/
    
    /*
    * Checks to see if the user is already logged in
    *
    * @params none
    *
    * @returns $http promise
    */
    function checkAuth() {

        return $http.get('/checkAuth')
            .then(function (response) {
                if(response.data.success){
                    user = response.data.user;
                }
            }, function (error) {
                $log.error('There was an error trying to get auth data', error);
            });
        
    }
    
    /*
    * Returns the user
    *
    * @params none
    *
    * @returns user object
    */
    function getUser() {
        return user;
    }

    
    /*
    * Checks to see if a given email is unique
    *
    * @params email (string|required)
    *
    * @returns $http promise
    */
    function isEmailUnique (email) {
        
        return $http.post('/isEmailUnique', {
            email: email
        });
        
    }

    /*
    * Attemps to log in with credentials
    *
    * @params email (string|required), password (string|required)
    *
    * @returns promise
    */
    function registerAccount(name, email, password) {

        if(angular.isObject(user)){
            return $q(function (resolve, reject) {
                reject('User is already logged in');
            });
        }
        else {
            return $http.post('/register', {
                name: name,
                email: email,
                password: password
            })
        }
    }
    
    /*
    * Checks users confirmation code
    *
    * @params code
    *
    * @returns $http promise -> {success: bool, user: object(if success)}
    */
    function checkConfirmation(confirmation) {
        
        return $http.post('/checkConfirmation', {
            confirmation: confirmation
        })
            .then(function (response) {
                if(response.data.success){
                    user = response.data.user;
                }
                return response;
            }, function (error) {
                console.log(error);
                return error;
            });
        
    }    
    
}