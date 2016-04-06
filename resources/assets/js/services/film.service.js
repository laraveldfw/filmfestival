/*
* Angular Service for working with film registration
*
* @params $log, $http
*
* @returns none
*/

FilmService.$inject = ['$log', '$http', 'AuthService'];

function FilmService($log, $http, AuthService) {
    
    var self = this;
    
    /****  Public Variables  ****/
    var films = [];
    
    /****  Private Variables  ****/

    
    /****  Initializations  ****/
    
    // create an initial film
    films.push({});
    
    /****  Public Functions  ****/
    
    
    /****  Private Functions  ****/
    
    
    
}