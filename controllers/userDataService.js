angular.module('mySchoolApp').service('userDataService', function () {

    var user;

    function getUser() {
        return user;
    }

    function setUser(value) {
        user = value;
    }

    return {
        getUser: getUser,
        setUser: setUser
    };


});