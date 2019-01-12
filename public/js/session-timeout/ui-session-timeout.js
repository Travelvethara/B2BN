var SessionTimeout = function () {

    var handlesessionTimeout = function () {
        $.sessionTimeout({
            title: 'Session Timeout',
            message: 'session is about to expire.',
           	redirUrl: 'home',
            logoutUrl: 'home',
            warnAfter: 60000, //warn after 5 seconds
            redirAfter: 60000, //redirect after 10 secons, /// total seconds in 15 seconds
            ignoreUserActivity: true,
            countdownMessage: 'Redirecting home page in {timer} seconds.',
            countdownBar: true
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handlesessionTimeout();
        }
    };

}();

$(document).ready(function() {    
   SessionTimeout.init();
});