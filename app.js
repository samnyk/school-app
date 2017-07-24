
	var app = angular.module('mySchoolApp', ['ngFileUpload','ngRoute','angularCSS']);


	app.config(['$routeProvider' ,function($routeProvider) {
		$routeProvider

			.when('/', {
				templateUrl : 'pages/login.html',
				controller: 'loginController',
				css:'css/login.css'
			})
            .when('/school', {
                templateUrl: 'pages/school.html',
                controller: 'schoolController',
                css: 'css/school.css'
            })
                .when('/admins', {
                templateUrl : 'pages/admins.html',
                controller: 'adminController',
                css:'css/admins.css'
        })

	}]);



    app.run(['$rootScope','$http','userDataService','sessionService',function($rootScope,$http,userDataService,sessionService){
        $http({
            method: 'GET',
            url: 'checksession'
        }).then(function(response){
                if(response.data['session']){
                    sessionService.setSession(true);
                    userDataService.setUser(response.data['user']);
                    $rootScope.loggedUser = response.data['user'];
                    $rootScope.session = true;

                }else{
                    $rootScope.session=false
                }
            },
            function(){

            })
    }]);



