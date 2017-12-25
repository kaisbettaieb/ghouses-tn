$(document).ready(function() {
  new WOW().init();

  /*** Featured Carousel ***/
  $("#featuredCarousel").lightSlider({
    item: 4,
    autoWidth: true,
    slideMove: 1, // slidemove will be 1 if loop is true
    slideMargin: 10,

    addClass: '',
    mode: "slide",
    useCSS: true,
    cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
    easing: 'linear', //'for jquery animation',////

    speed: 400, //ms'
    auto: true,
    loop: true,
    slideEndAnimation: true,
    pause: 3600,

    keyPress: false,
    controls: true,
    prevHtml: '<button class=" btn btn-elegant waves-effect btn-sm my-0" id="f-next"><i class="fa fa-chevron-left"></i></button>',
    nextHtml: '<button class=" btn btn-elegant waves-effect btn-sm my-0" id="f-next"><i class="fa fa-chevron-right"></i></button>',

    rtl: false,
    adaptiveHeight: true,

    vertical: false,
    verticalHeight: 500,
    vThumbWidth: 100,

    thumbItem: 10,
    pager: false,
    gallery: false,
    galleryMargin: 5,
    thumbMargin: 5,
    currentPagerPosition: 'middle',

    enableTouch: true,
    enableDrag: true,
    freeMove: true,
    swipeThreshold: 40,

    responsive: [],

    onBeforeStart: function(el) {},
    onSliderLoad: function(el) {},
    onBeforeSlide: function(el) {},
    onAfterSlide: function(el) {},
    onBeforeNextSlide: function(el) {},
    onBeforePrevSlide: function(el) {}
  });
  /*** Newest Carousel ***/
  $("#newestCarousel").lightSlider({
    item: 4,
    autoWidth: true,
    slideMove: 1, // slidemove will be 1 if loop is true
    slideMargin: 10,

    addClass: '',
    mode: "slide",
    useCSS: true,
    cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
    easing: 'linear', //'for jquery animation',////

    speed: 400, //ms'
    auto: true,
    loop: true,
    slideEndAnimation: true,
    pause: 4600,

    keyPress: false,
    controls: true,
    prevHtml: '<button class=" btn btn-elegant waves-effect btn-sm my-0" id="f-next"><i class="fa fa-chevron-left"></i></button>',
    nextHtml: '<button class=" btn btn-elegant waves-effect btn-sm my-0" id="f-next"><i class="fa fa-chevron-right"></i></button>',

    rtl: false,
    adaptiveHeight: true,

    vertical: false,
    verticalHeight: 500,
    vThumbWidth: 100,

    thumbItem: 10,
    pager: false,
    gallery: false,
    galleryMargin: 5,
    thumbMargin: 5,
    currentPagerPosition: 'middle',

    enableTouch: true,
    enableDrag: true,
    freeMove: true,
    swipeThreshold: 40,

    responsive: [],

    onBeforeStart: function(el) {},
    onSliderLoad: function(el) {},
    onBeforeSlide: function(el) {},
    onAfterSlide: function(el) {},
    onBeforeNextSlide: function(el) {},
    onBeforePrevSlide: function(el) {}
  });

  /*** NewestComments Carousel ***/
  $("#latestComments").lightSlider({
    item: 1,
    autoWidth: true,
    slideMove: 1, // slidemove will be 1 if loop is true
    slideMargin: 200,

    addClass: '',
    mode: "slide",
    useCSS: true,
    cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
    easing: 'linear', //'for jquery animation',////

    speed: 600, //ms'
    auto: false,
    loop: true,
    slideEndAnimation: true,
    pause: 2000,

    keyPress: false,
    controls: true,
    prevHtml: '<button class=" btn btn-elegant waves-effect btn-sm my-0" id="f-next"><i class="fa fa-chevron-left"></i></button>',
    nextHtml: '<button class=" btn btn-elegant waves-effect btn-sm my-0" id="f-next"><i class="fa fa-chevron-right"></i></button>',

    rtl: false,
    adaptiveHeight: true,

    vertical: false,
    verticalHeight: 500,
    vThumbWidth: 100,

    thumbItem: 10,
    pager: false,
    gallery: false,
    galleryMargin: 5,
    thumbMargin: 5,
    currentPagerPosition: 'middle',

    enableTouch: true,
    enableDrag: true,
    freeMove: true,
    swipeThreshold: 40,

    responsive: [],

    onBeforeStart: function(el) {},
    onSliderLoad: function(el) {},
    onBeforeSlide: function(el) {},
    onAfterSlide: function(el) {},
    onBeforeNextSlide: function(el) {},
    onBeforePrevSlide: function(el) {}
  });


});
