jQuery(function($) {
    $(document).ready(function() {
        var timer;
        // when the button and button menu are hovered
        $('.dropdown a, .dropdown-menu').hover(function() {
          // Clears the time on hover to prevent a que or waiting for the delay to finish from a previous hover event
          clearTimeout(timer);
          // Add the class .open and show the menu
          $('.dropdown').addClass('show');
          $('.dropdown-menu').addClass('show');
        }, function() {
          // Sets the timer variable to run the timeout delay
          timer = setTimeout(function() {
            // remove the class .open and hide the submenu
            $('.dropdown').removeClass("show");
            $('.dropdown-menu').removeClass("show");
          }, 200);
        });
        // document ready  
      });
});