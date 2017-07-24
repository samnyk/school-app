

angular.module('mySchoolApp').directive('navdirective',function(){
    return{
        templateUrl: 'pages/navbar.html',
        restrict: 'E',
        controller: function($location,$scope,$http,$rootScope,userDataService,sessionService){


            $scope.logout = function () {
                $http({
                    method: 'POST',
                    url: 'logout'
                }).then(function(data){
                        userDataService.setUser('');
                        sessionService.setSession(false);
                        $location.path('/');
                        $rootScope.loggedUser = '';
                        $rootScope.session = false;

                    },
                    function(data){
                        console.log(data)
                    })
            }

        }
    }
})



