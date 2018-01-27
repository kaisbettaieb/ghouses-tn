// Regular map
function regular_map() {
    var var_location = new google.maps.LatLng(document.getElementById('map-container').getAttribute('data-maplat'), document.getElementById('map-container').getAttribute('data-maplng'));

    var var_mapoptions = {
        center: var_location,
        zoom: 14
    };

    var var_map = new google.maps.Map(document.getElementById("map-container"),
        var_mapoptions);

    var var_marker = new google.maps.Marker({
        position: var_location,
        map: var_map,
        title: "Carthage"
    });
}

// Initialize maps
google.maps.event.addDomListener(window, 'load', regular_map);

$(document).ready(function () {
    $('#ght-showcase').scrollToFixed({
        marginTop: $('.navbar').outerHeight(true) + 10,
        limit: function () {
            var limit = $('#endCarousel').offset().top - $('#ght-showcase').outerHeight(true) - 10;
            return limit;
        },
        zIndex: 0,
        fixed: function () {
        },
        dontCheckForPositionFixedSupport: true
    });
    /*** Similairehouses ***/
    $("#SimilaireHouses").lightSlider({
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

        onBeforeStart: function (el) {
        },
        onSliderLoad: function (el) {
        },
        onBeforeSlide: function (el) {
        },
        onAfterSlide: function (el) {
        },
        onBeforeNextSlide: function (el) {
        },
        onBeforePrevSlide: function (el) {
        }
    });
    /* add comment section */
    var rate = 0;
    $(document).on("click", ".ratings_stars", function () {
        if ($(this).data('rating') == 1) {
            $('.ratings_stars').removeClass('selected');
            $(this).addClass('selected');
        } else if ($(this).data('rating') == 2) {
            $('.ratings_stars').removeClass('selected');
            $('#rating-1').addClass('selected');
            $('#rating-2').addClass('selected');
        } else if ($(this).data('rating') == 3) {
            $('.ratings_stars').removeClass('selected');
            $('#rating-1').addClass('selected');
            $('#rating-2').addClass('selected');
            $('#rating-3').addClass('selected');
        } else if ($(this).data('rating') == 4) {
            $('.ratings_stars').removeClass('selected');
            $('#rating-1').addClass('selected');
            $('#rating-2').addClass('selected');
            $('#rating-3').addClass('selected');
            $('#rating-4').addClass('selected');
        } else if ($(this).data('rating') == 5) {
            $('.ratings_stars').removeClass('selected');
            $('#rating-1').addClass('selected');
            $('#rating-2').addClass('selected');
            $('#rating-3').addClass('selected');
            $('#rating-4').addClass('selected');
            $('#rating-5').addClass('selected');
        }
        else {
            $('.ratings_stars').removeClass('selected');
            $('#rating-1').addClass('selected');
            $('#rating-2').addClass('selected');
            $('#rating-3').addClass('selected');
            $('#rating-4').addClass('selected');
            $('#rating-5').addClass('selected');
        }
        var rating = $(this).data('rating'); // Get the rating from the selected star
        rate = rating;
    });
    $('#ajouter-commentaire').click(function () {
        commentaire = $('#commentaire').val();
        stars = '<div class="ml-auto">\
      <div class="display-7">';
        if (rate == 1) {
            stars += '<i class="fa fa-star" aria-hidden="true"></i> \
                <i class="fa fa-star-o mr-1" aria-hidden="true"></i>\
                <i class="fa fa-star-o mr-1" aria-hidden="true"></i>\
                <i class="fa fa-star-o mr-1" aria-hidden="true"></i>\
                <i class="fa fa-star-o mr-1" aria-hidden="true"></i>\
                <button class="btn btn-warning btn-sm mr-4">Signalier</button>\
                </div>\
                </div>\
                ';
        } else if (rate == 2) {
            stars += '<i class="fa fa-star" aria-hidden="true"></i> \
                <i class="fa fa-star mr-1" aria-hidden="true"></i>\
                <i class="fa fa-star-o mr-1" aria-hidden="true"></i>\
                <i class="fa fa-star-o mr-1" aria-hidden="true"></i>\
                <i class="fa fa-star-o mr-1" aria-hidden="true"></i>\
                <button class="btn btn-warning btn-sm mr-4">Signalier</button>\
                </div>\
                </div>\
                ';
        } else if (rate == 3) {
            stars += '<i class="fa fa-star" aria-hidden="true"></i> \
                <i class="fa fa-star mr-1" aria-hidden="true"></i>\
                <i class="fa fa-star mr-1" aria-hidden="true"></i>\
                <i class="fa fa-star-o mr-1" aria-hidden="true"></i>\
                <i class="fa fa-star-o mr-1" aria-hidden="true"></i>\
                <button class="btn btn-warning btn-sm mr-4">Signalier</button>\
                </div>\
                </div>\
                ';
        } else if (rate == 4) {
            stars += '<i class="fa fa-star" aria-hidden="true"></i> \
                <i class="fa fa-star mr-1" aria-hidden="true"></i>\
                <i class="fa fa-star mr-1" aria-hidden="true"></i>\
                <i class="fa fa-star mr-1" aria-hidden="true"></i>\
                <i class="fa fa-star-o mr-1" aria-hidden="true"></i>\
                <button class="btn btn-warning btn-sm mr-4">Signalier</button>\
                </div>\
                </div>\
                ';
        } else {
            stars += '<i class="fa fa-star-o" aria-hidden="true"></i> \
                <i class="fa fa-star-o mr-1" aria-hidden="true"></i>\
                <i class="fa fa-star-o mr-1" aria-hidden="true"></i>\
                <i class="fa fa-star-o mr-1" aria-hidden="true"></i>\
                <i class="fa fa-star-o mr-1" aria-hidden="true"></i>\
                <button class="btn btn-warning btn-sm mr-4">Signalier</button>\
                </div>\
                </div>\
                ';
        }
        $('#ght-commentaires').append('<div class="bg-content">\
    <div class="row my-2 ">\
      <div class="col-md-1 col-sm-1">\
        <img class="mr-3 rounded-circle" src="https://placehold.it/64x64" alt="Generic placeholder image">\
      </div>\
      <div class="col-md-3 col-sm-3 ml-3">\
        <h5>Nom Prenom </h5>\
        <div class="display-7">5 Decembre 2017</div>\
      </div>' + stars +
            '</div>\
            <div class="ml-3 mb-3"> \
            <p>' + commentaire +
            '</p></div>\
            </div>')
    });


});
