$('.navTrigger').click(function () {
    $(this).toggleClass('active');
    console.log("Clicked menu");
    $("#mainListDiv").toggleClass("show_list");
    $("#mainListDiv").fadeIn();

});

// import SwupSlideTheme from '@swup/slide-theme/dist';
// const swup = new Swup({
//     plugins: [new SwupSlideTheme()]
//   });



const swup = new Swup();