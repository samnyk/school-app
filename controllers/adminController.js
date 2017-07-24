angular.module('mySchoolApp').controller('adminController', function (Upload, $location, $scope, $http, $rootScope) {
    $scope.edit;
    $scope.add;
    $scope.form = {};
    $scope.deletebox=false;

    $scope.addAdmin = function () {
        $scope.edit = false;
        $scope.add = true;
        $scope.addOrEdit = true;
    };


    var getAdmins = function () {
        $http({
            method: 'GET',
            url: 'getadmins'
        }).then(function (response) {
                $scope.admins = response.data;

            })
    };

    getAdmins();


    $scope.editData;
    $scope.user = {};


    $scope.editDetails = function (admin) {
        $scope.edit = true;
        $scope.add = false;
        $scope.addOrEdit = true;
        for (i = 0; $scope.admins.length; i++) {
            if ($scope.admins[i].id == admin) {
                $scope.editData = $scope.admins[i];
                return;
            }
        }
    }

    $scope.editIt = function (file) {
        var data = {};
        Upload.upload({
            url: 'php/imageupload.php',
            file: file,
            sendFieldsAs: 'form-data'

        }).then(function (res) {
            var img_path = res.data;
            $scope.user['image'] = img_path;

            data['id'] = $scope.editData['id'];
            data['newData'] = $scope.user;

            $http({
                method: 'post',
                url: 'editadmin',
                data: data
            }).then(function (response) {
                if(response.data[0]=='error'){
                    $scope.errorMsg=true;
                }else {
                    getAdmins()
                    $scope.reset();
                    $scope.addOrEdit=false;
                    $scope.errorMsg=false;


                }

            })
        })
    }


    $scope.reset = function () {
        $scope.user={};
        $scope.form.personForm.$setPristine();
        $scope.preview = null;
    }

    $scope.addUser = function (file) {
        var data = {};
        Upload.upload({
            url: 'php/imageupload.php',
            file: file,
            sendFieldsAs: 'form-data'

        }).then(function (res) {
            var img_path = res.data;
            $scope.user['image'] = img_path;
            $http({
                method: 'post',
                url: 'addadmin',
                data: $scope.user
            }).then(function (response) {
                if(response.data[0]=='error'){
                    $scope.errorMsg=true;
                }else {
                    $scope.reset();
                    getAdmins();
                    $scope.addOrEdit=false;
                    $scope.errorMsg=false;

                }


            })
        })
    }

    $scope.deleteDialog=function(){
        $scope.deletebox=true;
    }
    $scope.dontDelete=function(){
        $scope.deletebox=false;
    }

    $scope.deleteUser = function () {
        var data = {'id':$scope.editData['id']};
        $http({
            method: 'POST',
            url: 'deleteuser',
            data:data
        }).then(function (response) {
            getAdmins();
            $scope.addOrEdit=false;
            $scope.deletebox=false;
        })
    }


});
