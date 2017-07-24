angular.module('mySchoolApp').controller('schoolController',function(Upload,$location,$scope,$http,$rootScope){
    $scope.thisStudent={};
    $scope.addStdnt = false;
    $scope.addCrs= false;
    $scope.errorMsg=false;
    $scope.user={};
    $scope.viewStudent=false;
    $scope.editingStudent=false;
    $scope.addCourse=false;
    $scope.form = {};
    $scope.deletebox=false;
    $scope.mainContainer=true;
    $scope.editCrse=false;






    var getCourses = function () {
        $http({
            method: 'GET',
            url: 'getcourses'
        }).then(function (response) {
            if(response.data[0] == 'error'){
                $scope.courses = {};
            }else {
                $scope.courses = response.data;
            }

        })
    };

    getCourses();

    var getStudents = function () {
        $http({
            method: 'GET',
            url: 'getstudents'
        }).then(function (response) {
            if(response.data[0] == 'error'){
                $scope.students = {};
            }else {
                $scope.students = response.data;

            }
        })
    };

    getStudents();

    $scope.reset = function () {
        $scope.user={};
        $scope.form.personForm.$setPristine();
        $scope.preview = null;
    }
    $scope.addStudent=function (file) {
        Upload.upload({
            url: 'php/imageupload.php',
            file: file,
            sendFieldsAs: 'form-data'

        }).then(function (res) {
            var img_path = res.data;
            $scope.user['image'] = img_path;
            if ($scope.user.selected){
                $scope.user['courseId'] = $scope.user.selected;
            }else {
                $scope.user['courseId'] =0;
            }

            $http({
                method: 'post',
                url: 'addstudents',
                data: $scope.user
            }).then(function (response) {
                console.log(response)
                if(response.data[0]=='error'){
                    $scope.errorMsg=true;
                }else {
                    $scope.reset();
                    getStudents();
                    $scope.mainContainer=true;
                    $scope.addStdnt=false;
                    $scope.viewStudent = false;
                    $scope.viewCourse = false;
                    $scope.addCourse=false;
                    $scope.editCrse=false;
                    $scope.editingStudent=false;
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

    $scope.addS= function () {
        $scope.addStdnt=true;
        $scope.viewStudent = false;
        $scope.viewCourse = false;
        $scope.addCourse=false;
        $scope.editCrse=false;
        $scope.mainContainer=false;
        $scope.editingStudent=false;



    }


    $scope.addC= function () {
        $scope.addCourse=true;
        $scope.viewStudent = false;
        $scope.addStdnt=false;
        $scope.viewCourse = false;
        $scope.mainContainer=false;
        $scope.editCrse=false;
        $scope.editingStudent=false;

    }


    $scope.showStudent =function(student){
        $scope.addStdnt=false;
        $scope.viewStudent = true;
        $scope.viewCourse = false;
        $scope.addCourse=false;
        $scope.mainContainer=false;
        $scope.editingStudent=false;
        $scope.editCrse=false;



        for (i = 0; $scope.students.length; i++) {
            if ($scope.students[i].id == student) {
                $scope.thisStudent = $scope.students[i];
                var data = {'email': $scope.thisStudent['email']};
                $http({
                    method: 'post',
                    url: 'getcoursesforstudent',
                    data: data
                }).then(function (response) {
                    var courses=[];
                    var arr = response.data;

                    for (var i=0 ; i<arr.length ; i++){
                        for(var x=0 ; x<arr[i].length;x++){
                            courses.push(arr[i][x].name);
                        }
                    }
                   $scope.thisStudent['courses']=courses;
                })
                return;
            }
        }

    }

    $scope.addCourses =function(file){
        Upload.upload({
            url: 'php/imageupload.php',
            file: file,
            sendFieldsAs: 'form-data'

        }).then(function (res) {
            var img_path = res.data;
            $scope.user['image'] = img_path;
            $http({
                method: 'post',
                url: 'addcourses',
                data: $scope.user
            }).then(function (response) {
                $scope.reset();
                getCourses();
                $scope.addStdnt=false;
                $scope.viewStudent = false;
                $scope.viewCourse = false;
                $scope.addCourse=false;
                $scope.mainContainer=true;
                $scope.editingStudent=false;
                $scope.editCrse=false;

            })
        })

    }



    $scope.showCourse = function(course){
        $scope.addStdnt=false;
        $scope.viewStudent = false;
        $scope.viewCourse = true;
        $scope.addCourse=false;
        $scope.mainContainer=false;
        $scope.editingStudent=false;
        $scope.editCrse=false;


        for (i = 0; $scope.courses.length; i++) {
            if ($scope.courses[i].id == course) {
                $scope.thisCourse= $scope.courses[i];
                var data = {'id' : $scope.thisCourse['id']};
                $http({
                    method: 'post',
                    url: 'countcourses',
                    data: data
                }).then(function (response) {
                    $scope.thisCourse['howmany']=response.data;
                })
                return;
            }
        }
    }


    $scope.deleteStudent = function () {
        var data = {'id':$scope.thisStudent['id'],'mail':$scope.thisStudent['email']};
        $http({
            method: 'POST',
            url: 'deletestudent',
            data:data
        }).then(function (response) {
            getStudents();
            $scope.addStdnt=false;
            $scope.viewStudent = false;
            $scope.viewCourse = false;
            $scope.addCourse=false;
            $scope.deletebox=false;
            $scope.mainContainer=true;
            $scope.editingStudent=false;
            $scope.editCrse=false;


        })
    }
    $scope.deleteCourse= function () {
        var data = {'id':$scope.thisCourse['id']};
        $http({
            method: 'POST',
            url: 'deletecourse',
            data:data
        }).then(function (response) {
            getCourses();
            $scope.addStdnt=false;
            $scope.viewStudent = false;
            $scope.viewCourse = false;
            $scope.addCourse=false;
            $scope.deletebox=false;
            $scope.mainContainer=true;
            $scope.editingStudent=false;
            $scope.editCrse=false;


        })
    }

    $scope.editStudent = function () {
        $scope.editingStudent=true;
        $scope.addStdnt=true;
        $scope.viewStudent=false;
        $scope.viewCourse = false;
        $scope.deletebox=false;
        $scope.mainContainer=false;
        $scope.addCourse=false;
        $scope.editCrse=false;

    }
    $scope.editIt = function (file) {
        var data={};
        Upload.upload({
            url: 'php/imageupload.php',
            file: file,
            sendFieldsAs: 'form-data'

        }).then(function (res) {
            var img_path = res.data;
            $scope.user['image'] = img_path;
            $scope.user['courseId'] = $scope.user.selected;
            $scope.user['oldmail'] =$scope.thisStudent['email'];
            data = {'id':$scope.thisStudent['id'],'newData':$scope.user}


            $http({
                method: 'post',
                url: 'editstudent',
                data: data
            }).then(function (response) {
                if(response.data[0]=='error'){
                    $scope.errorMsg=true;
                }else {
                    $scope.editingStudent=false;
                    $scope.addStdnt=false;
                    $scope.viewStudent=false;
                    $scope.viewCourse = false;
                    $scope.deletebox=false;
                    $scope.mainContainer=true;
                    $scope.addCourse=false;
                    $scope.editCrse=false;
                    $scope.errorMsg=false;
                    getStudents();
                    $scope.reset();

                }

            })
        })
    }




    $scope.editCourse = function () {
        $scope.editingStudent=true;
        $scope.addStdnt=false;
        $scope.viewStudent=false;
        $scope.viewCourse = false;
        $scope.deletebox=false;
        $scope.mainContainer=false;
        $scope.addCourse=true;
        $scope.editCrse=true;

    }


    $scope.editItCourse = function (file) {
        var data={};
        Upload.upload({
            url: 'php/imageupload.php',
            file: file,
            sendFieldsAs: 'form-data'

        }).then(function (res) {
            var img_path = res.data;
            $scope.user['image'] = img_path;
            data['id']= $scope.thisCourse['id'];
            data['newData']= $scope.user;


            $http({
                method: 'post',
                url: 'editcourse',
                data: data
            }).then(function (response) {
                $scope.editingStudent=false;
                $scope.addStdnt=false;
                $scope.viewStudent=false;
                $scope.viewCourse = false;
                $scope.deletebox=false;
                $scope.mainContainer=true;
                $scope.addCourse=false;
                $scope.editCrse=false;

                getCourses();
                $scope.reset();

            })
        })
    }

});


