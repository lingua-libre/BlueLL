// Target mobile devices
function showMobileSubMenu () {
    $( '.menu-icon a' ).on( 'click tap', function ( e ) {
        if ( window.matchMedia( "(max-width: 767px)" ).matches ) {
            e.preventDefault();
            $( '.top-bar-section' ).slideToggle( 'slow' );            
        }
    } );
    
    // Display nav when window resize to large screen
    window.onresize = function () {
        if (  !window.matchMedia( "(max-width: 767px)" ).matches ) {
            $( '.top-bar-section' ).css( {'display' : 'block' } );
        }
        else{
            $( '.top-bar-section' ).css( {'display' : 'none' } );
        }
    };
}

showMobileSubMenu();