console.log ("ola")
$(document).ready(function(){


    // NAV SLIDE TOOGLE
    $('i.icon').click(function(){
        $('.nav-list').slideToggle()

    });

    // Sticky NAV BAR
    $(window).scroll(function(){
        var sc = $(this).scrollTop();
        if(sc > 50){
            $('header').addClass('sticky');
         console.log ("plus")   
        }else{
            $('header').removeClass('sticky');
        console.log ("ere")
        }
    });
});