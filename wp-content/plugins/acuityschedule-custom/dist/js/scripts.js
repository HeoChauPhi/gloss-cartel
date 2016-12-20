/*jslint browser: true*/
/*global $, jQuery, Modernizr, enquire, audiojs*/

(function($) {
  function setCookie(key, value) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value +';path=/'+ ';expires=' + expires.toUTCString();
  }

  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
  }

  var removeCookie = function () {
    //console.log(getCookie('Client[Area]'));
    var ClientArea    = getCookie("Client[Area]").length;
    var ClientService = getCookie("Client[Service]").length;
    var ClientDate    = getCookie("Client[Date]").length;
    var ClientTime    = getCookie("Client[Time]").length;

    var confirmCatimg   = getCookie("confirm[Catimg]").length;
    var confirmCategory = getCookie("confirm[Category]").length;
    var confirmName     = getCookie("confirm[Name]").length;
    var confirmPrice    = getCookie("confirm[Price]").length;
    var confirmImage    = getCookie("confirm[Image]").length;

    var signinemail    = getCookie("signin[email]").length;
    var signinemailid  = getCookie("signin[emailid]").length;

    //alert(getCookie('Client["Area"]'));

    return false;
  };

  $(document).ready(function() {
    //$('.sign-out').on('click', removeCookie);
  });

  $(window).load(function() {
    // Call to function
  });

  $(window).resize(function() {
    // Call to function
  });
})(jQuery);
