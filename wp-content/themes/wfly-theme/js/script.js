(function($) {
  function headerFixed() {
    var headertop = $('#header');
    var offset = headertop.position();
    $(window).scroll(function () {
      if ($(this).scrollTop() > offset.top) {
        headertop.addClass('fixed');
      } else {
        headertop.removeClass('fixed');
      }
    });
  }

  function navigation() {
    $('.menu-icon').click(function() {
      $('ul.main-nav').slideToggle('fast');
    });
  }

  function featureSlider() {
    $('.feature .block-slider').slick({
      arrows: false,
      dots: false,
      infinite: true,
      speed: 500,
      fade: true,
      cssEase: 'linear',
      adaptiveHeight: true,
      autoplay: true,
      autoplaySpeed: 3000,
    });
  }

  function verticalSlick() {
    $('.slickvertical > .block-content').slick({
      vertical: true,
      slidesToScroll: 1,
      autoplay: true,
      speed: 300,
      infinite: true,
      slidesToShow: 2
    });
  }

  function colorbox() {
    if($( window ).width() < 480) {
      $(".popup-login").colorbox({inline:true, width:"100%"});
    } else {
      $(".popup-login").colorbox({inline:true, width:"30%"});
    }
  }

  function loginForm() {
    var form_group = $('.login-form .form-group');
    form_group.each(function() {
      if($(this).html().replace(/\s|&nbsp;/g, '').length == 0) {
        $(this).remove();
      }
 
      var form_class = $(this).find('input').attr('name');
      $(this).addClass(form_class);
    })
  }

  function matchHeight() {
    //$(this).find('.post-cars .car-title').matchHeight();
  }

  $(document).ready(function() {
    // Call to function
    headerFixed();
    navigation();
    featureSlider();
    verticalSlick();
    colorbox();
    loginForm();
    matchHeight();
  });

  $(window).load(function() {
    // Call to function
  });

  $(window).resize(function() {
    // Call to function
    matchHeight();  
  });
})(jQuery);
