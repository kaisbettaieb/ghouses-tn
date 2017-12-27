var mark;
var map;
var posLat;
var posLng;
function initMap() {
    map = new google.maps.Map(document.getElementById('map-container'), {
        zoom: 7,
        center: {
            lat: 36.862609,
            lng: 10.332946
        }
    });
    map.addListener('click', function (e) {
        if (mark && mark.getMap()) {
            mark.setPosition(e.latLng);
        } else {
            placeMarkerAndPanTo(e.latLng, map);
        }
        posLat = e.latLng.lat();
        posLng = e.latLng.lng();
    });
}
// Delete one marker
function deleteMarker(mark) {
    mark.setMap(null);
}

function placeMarkerAndPanTo(latLng, map) {
    mark = new google.maps.Marker({
        position: latLng,
        map: map,
        draggable: true,
        title: "La positon de votre maison",
        animation: google.maps.Animation.DROP
    });
    map.panTo(latLng);
    google.maps.event.addListener(mark, 'rightclick', function (point) {
        deleteMarker(mark);
    });
}


$(document).ready(function () {
    /* navbar color class */
    $('#ght-navbar').removeClass("navbar-dark");
    $('#ght-navbar').addClass("navbar-light ght-add-navbar");

    $('#ghouse_add_form').submit(function (e) {
        if (posLat === undefined || posLng === undefined) {
            $.notify({
                title: '<strong>Erreur</strong>',
                message: "Il faut que vous choisit la position de votre maison dans google map."
            }, {
                offset: {
                    x: 5,
                    y: 70
                },
                type: 'danger'
            });
            e.preventDefault();
            return false;
        }
        document.getElementById('ghouse_form_mapLat').value = posLat;
        document.getElementById('ghouse_form_mapLng').value = posLng;
    });
    /* added image form */
    var imagesCount = '{{ ghouse_add_form.gh_images|length }}';

    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
   // var $container = $('div#ghouse_form_gh_images');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $('#add_image').click(function (e) {
        addImage($container);
        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
    if (index != 0) {
        $container.children('div').each(function () {
            addDeleteLink($(this));
        });
    }

    // La fonction qui ajoute un formulaire GhouseImages
    function addImage($container) {
        // Dans le contenu de l'attribut « data-prototype », on remplace :
        // - le texte "__name__label__" qu'il contient par le label du champ
        // - le texte "__name__" qu'il contient par le numéro du champ
        var template = $container.attr('data-prototype')
            .replace(/__name__label__/g, 'Image n°' + (index + 1))
            .replace(/__name__/g, index)
        ;

        // On crée un objet jquery qui contient ce template
        var $prototype = $(template);
        $prototype.addClass('md-form');
        // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
        addDeleteLink($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $container.append($prototype);

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        index++;
    }

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function addDeleteLink($prototype) {
        // Création du lien
        var $deleteLink = $('<a href="#" class="btn btn-danger btn-sm pull-right">X</a>');

        // Ajout du lien
        $prototype.append($deleteLink);

        // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
        $deleteLink.click(function (e) {
            $prototype.remove();

            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });
    }

    /* ./add image form */
});
