var newWindowCar = false;
var carShown = null;

function showCar(el, car_id, photos) {
    if (newWindowCar) {
        newWindowCar = false;
        return;
    }
    if (el.tagName == 'A') {
        newWindowCar = true;
        return true;
    }

    carShown = car_id;

    if ($('#car_descr_' + carShown).hasClass('opened')) {
        closeCarDescription(carShown);
        return;
    }

    if ($('#car_descr_' + carShown).hasClass('loaded') || photos < 2) {
        openCarDescription(carShown);
        return;
    }

    var width = $('#tr_' + carShown).width();
    var height = $('#tr_' + carShown).height();
    var top = $('#tr_' + carShown).position().top;
    var left = $('#tr_' + carShown).position().left;

    var hidden_div = "<div id='hide_" + carShown + "' class='hide_box' style='width: " + width + "px;height: " + height + "px;top:" + (top-10) + "px; left:" + (left-10) + "px;'>";
    hidden_div += "</div>"
    hidden_div += "<div id='loader_" + carShown + "' class='hide_load' style='top:" + (top + height/2 - 16 - 5) + "px; left:" + (left + width/2 - 16) + "px;'></div>";
    $('#cars_table').after(hidden_div);

    $.ajax({
        dataType: "json",
        url: '/ajax/api/car/?car_id=' + car_id,
        success: parseJsonCars
    });
}

function parseJsonCars (data) {
    $('#hide_' + carShown).remove();
    $('#loader_' + carShown).remove();

    var photos = data.objects;

    for (var i = 1; i < photos.length; i++) {
        $('#car_descr_' + carShown + ' .more_pictures').append(
            "<div class='car_photo'>" +
                "<a title='" + $('#car_model_' + carShown).val() + "' href='" + $('#big_path').val() + "/" + photos[i].path + "' class='thickbox' rel='car_" + carShown + "'>" +
                    "<img alt='" + $('#car_model_' + carShown).val() + "' src='" + $('#small_path').val() + "/" + photos[i].path + "' />" +
                "</a>" +
             "</div>"
        );
    }

    tb_init('a[rel=car_' + carShown + '],a#prev_' + carShown);//apply thickbox

    openCarDescription(carShown);
}

function closeCarDescription (car_id) {
    $('#car_descr_' + car_id).hide();
    $('#car_descr_' + car_id).removeClass('opened');
    $('#car_descr_' + car_id).prev().removeClass('opened');
}

function openCarDescription(car_id) {
    $('#car_descr_' + car_id).show();
    $('#car_descr_' + car_id).addClass('opened');
    $('#car_descr_' + car_id).addClass('loaded');
    $('#car_descr_' + car_id).prev().addClass('opened');
}

function fillModel() {
    var search = $( "#model").val();
    if (search != '') {
        $.ajax({
            dataType: "json",
            url: '/ajax/api/carModel/' + search,
            success: parseJsoncar_model_id
        });
    } else {
        $( "#car_model_id").val('');
    }

}

var availableObjectscar_model_id = 0;
var availableObjectsDatacar_model_id = [];

function parseJsoncar_model_id(data) {
    availableObjectscar_model_id = [];
    availableObjectsDatacar_model_id = data;

    for (var i = 0; i < data.objects.length; i++) {
        availableObjectscar_model_id[availableObjectscar_model_id.length] = data.objects[i]['car_model'];
    }

    $( "#model" ).autocomplete({
        source: availableObjectscar_model_id
    });

    $( "#model" ).autocomplete( "search",  $( "#model").val());
}

function callcar_model_id() {
    if (availableObjectsDatacar_model_id.length == 0) {
        return;
    }

    for (var i = 0; i < availableObjectsDatacar_model_id.objects.length; i++) {
        if (availableObjectsDatacar_model_id.objects[i]['car_model'] == $( "#model").val()) {
            $( "#car_model_id").val(availableObjectsDatacar_model_id.objects[i]['car_model_id']);
            return;
        }
    }
}

function orderByDate() {
    $('#orderByPrice').val(0);
    switch(parseInt($('#orderByDate').val())) {
        case 0: $('#orderByDate').val(1); break;
        case 1: $('#orderByDate').val(2); break;
        case 2: $('#orderByDate').val(1); break;
    }

    sendSearch();
}

function orderByPrice() {
    $('#orderByDate').val(0);
    switch(parseInt($('#orderByPrice').val())) {
        case 0: $('#orderByPrice').val(1); break;
        case 1: $('#orderByPrice').val(2); break;
        case 2: $('#orderByPrice').val(1); break;
    }

    sendSearch();
}

function selectType(type) {
    $('#type').val(type);

    sendSearch();
}

function sendSearch() {
    callcar_model_id();

    var year_min = $('#year_min').val();
    var year_max = $('#year_max').val();
    var price_min = $('#price_min').val();
    var price_max = $('#price_max').val();
    var mileage_max = $('#mileage_max').val();
    var ec_max = $('#ec').val();
    var model = $('#model').val();
    var car_model_id = $('#car_model_id').val();
    var orderByPrice = $('#orderByPrice').val();
    var orderByDate = $('#orderByDate').val();
    var type = $('#type').val();

    var search = "?year_min=" + year_min;
    search += "&year_max=" + year_max;
    search += "&price_min=" + price_min;
    search += "&price_max=" + price_max;
    search += "&mileage_max=" + mileage_max;
    search += "&ec_max=" + ec_max;
    search += "&model=" + model;
    search += "&car_model_id=" + car_model_id;
    search += "&orderByPrice=" + orderByPrice;
    search += "&orderByDate=" + orderByDate;
    search += "&type=" + type;

    $.get('/ajax/api/search/' + search,
        function (data) {
            var city = $('#city').val();
            var city_id = $('#city_id').val();
            if (typeof city === 'undefined') {
                window.location.href = '/';
            } else {
                window.location.href = '/city/' + city + '/' + city_id + '/';
            }
        }
    );
}

$(document).ready(function() {
    $('body').keypress(function (e) {
        if(e.which == 13) {
            sendSearch();
        }
    });
});