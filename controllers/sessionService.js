angular.module('mySchoolApp').service('sessionService', function () {

    var session;

    function getSession() {
        return session;
    }

    function setSession(value) {
        session = value;
    }

    return {
        getSession: getSession,
        setSession: setSession
    };


});