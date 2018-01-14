

// module pattern to avoid conflicts

var User = (function () {

    function isPasswordMatches()
    {

        return ($('#pass1').val() == $('#pass2').val()) ? true : false;

    }
        
    return {

        isPasswordMatches: function () {

            isPasswordMatches();

        }
    };

})();



