new WOW().init();
$('#load-more').click(function () {
    dt = ' <div class="row mt-4">\
<div class="card mr-3" style="width:265px;">\
  <!--Card image-->\
  <div class="view overlay hm-white-slight">\
      <img src="assets/img/gh-snaps/5.jpg" height="150" width="280" alt="">\
    <a>\
        <div class="mask"></div>\
      </a>\
    </div>\
    <!--/.Card image-->\
    <!--Card content-->\
    <div class="card-body">\
      <!--Social shares button-->\
      <a class="activator"><h5 class="pink-text"><i class="fa fa-cutlery"></i> Culinary</h5><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></a>\
      <!--Title-->\
      <h4 class="card-title">Maison a Carthage</h4>\
      <hr>\
      <!--Text-->\
      <p class="card-text ">test exemple.</p>\
      <a href="#" class="d-flex flex-row-reverse">\
        <h5 class="waves-effect waves-dark p-2">Voir <i class="fa fa-chevron-right"></i></h5>\
      </a>\
    </div>\
  </div>\
  <!--/.Card content-->\
  <div class="card mr-3" style="width:265px;">\
    <!--Card image-->\
    <div class="view overlay hm-white-slight">\
        <img src="assets/img/gh-snaps/1.jpg" height="150" width="280" alt="">\
      <a>\
          <div class="mask"></div>\
        </a>\
      </div>\
      <!--/.Card image-->\
      <!--Card content-->\
      <div class="card-body">\
        <!--Social shares button-->\
        <a class="activator"><h5 class="pink-text"><i class="fa fa-cutlery"></i> Culinary</h5><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></a>\
        <!--Title-->\
        <h4 class="card-title">Maison a Carthage</h4>\
        <hr>\
        <!--Text-->\
        <p class="card-text ">test exemple.</p>\
        <a href="#" class="d-flex flex-row-reverse">\
          <h5 class="waves-effect waves-dark p-2">Voir <i class="fa fa-chevron-right"></i></h5>\
        </a>\
      </div>\
    </div>\
    <!--/.Card content-->\
    <div class="card mr-3" style="width:265px;">\
      <!--Card image-->\
      <div class="view overlay hm-white-slight">\
          <img src="assets/img/gh-snaps/6.jpg" height="150" width="280" alt="">\
        <a>\
            <div class="mask"></div>\
          </a>\
        </div>\
        <!--/.Card image-->\
        <!--Card content-->\
        <div class="card-body">\
          <!--Social shares button-->\
          <a class="activator"><h5 class="pink-text"><i class="fa fa-cutlery"></i> Culinary</h5><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></a>\
          <!--Title-->\
          <h4 class="card-title">Maison a Carthage</h4>\
          <hr>\
          <!--Text-->\
          <p class="card-text ">test exemple.</p>\
          <a href="#" class="d-flex flex-row-reverse">\
            <h5 class="waves-effect waves-dark p-2">Voir <i class="fa fa-chevron-right"></i></h5>\
          </a>\
        </div>\
      </div>\
      <!--/.Card content-->\
      <div class="card mr-3" style="width:265px;">\
        <!--Card image-->\
        <div class="view overlay hm-white-slight">\
            <img src="assets/img/gh-snaps/4.jpg" height="150" width="280" alt="">\
          <a>\
              <div class="mask"></div>\
            </a>\
          </div>\
          <!--/.Card image-->\
          <!--Card content-->\
          <div class="card-body">\
            <!--Social shares button-->\
            <a class="activator"><h5 class="pink-text"><i class="fa fa-cutlery"></i> Culinary</h5><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i></a>\
            <!--Title-->\
            <h4 class="card-title">Maison a Carthage</h4>\
            <hr>\
            <!--Text-->\
            <p class="card-text ">test exemple.</p>\
            <a href="#" class="d-flex flex-row-reverse">\
              <h5 class="waves-effect waves-dark p-2">Voir <i class="fa fa-chevron-right"></i></h5>\
            </a>\
          </div>\
        </div>\
        <!--/.Card content-->';
    var new_row = '<div class="row mt-4 row-data" id="ght-new-row" style="display: none;"> </div>';
    $(new_row).appendTo('#ght-explore-present').fadeIn('slow');
    jQuery('.row-data').html(dt, 5000);

});

/*$(document).ready(function () {
    $('#newer_ghouses').click(function () {
        alert("hi");
    });

});*/