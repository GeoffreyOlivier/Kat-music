

        // $(window).on('scroll', function () {
        //    var scrollTop = $(window).scrollTop(),
        //      sticky = $('#page-menu-mobile').offset().top;
        //     if (scrollTop > sticky ) {
        //         $( "#page-menu-mobile" ).addClass( "sticky-mobile" );
        //     } 
        //     else {
        //         $( "#page-menu-mobile" ).removeClass( "sticky-mobile" );
        //     }
        
        // });







// // Get Menu titles
var LivreDor_title = document.getElementById("titre_LivreDor");
var CahierDesCharges_title = document.getElementById("titre_CahierDesCharges");
var ContactPro_title = document.getElementById("titre_ContactPro");


$(window).on('scroll', function () {
    // console.log('ok');
    var scrollTop = $(window).scrollTop(),
        LivreDorTrigger = $('#LivreDorTrigger').offset().top,
        distance  = (LivreDorTrigger - scrollTop);
        CahierDesChargesTrigger = $('#CahierDesChargesTrigger').offset().top,
        distance2 = (CahierDesChargesTrigger - scrollTop);
        ContactProTrigger = $('#ContactProTrigger').offset().top,
        distance3 = (ContactProTrigger - scrollTop);

    if ((LivreDorTrigger - 150) > scrollTop  ) {
        LivreDor_title.classList.add("current")
        CahierDesCharges_title.classList.remove("current");
        ContactPro_title.classList.remove("current");
    } 
    else if ((CahierDesChargesTrigger -150)  > scrollTop  ) {
        CahierDesCharges_title.classList.add("current");
        LivreDor_title.classList.remove("current");
        ContactPro_title.classList.remove("current");
    }
    else  {
        ContactPro_title.classList.add("current");
        LivreDor_title.classList.remove("current");
        CahierDesCharges_title.classList.remove("current");
    }

});

