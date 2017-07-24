angular.module('mySchoolApp').controller('loginController',['$location','$scope','$http','$rootScope','userDataService','sessionService',function($location,$scope,$http,$rootScope,userDataService,sessionService){
    $scope.user={};


    $scope.login  = function (){
        $http({
            method: 'POST',
            url: 'login',
            data:$scope.user
        }).then(function(data){
            if(data.data.session==true){
                userDataService.setUser(data.data['user']);
                $rootScope.loggedUser = data.data['user'];
                sessionService.setSession(true);
                $rootScope.session = true;
                $location.path('/school');
                if(!$scope.$$phase) {
                    $scope.$apply()
                }
            }else {
                $scope.error = true;
            }
            },
            function(data){
                console.log(data)
            })
    }
}]);