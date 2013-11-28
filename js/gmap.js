// =======================================================
// Google Map 処理
// =======================================================
var map;
var geo;
var geocli;
var clickMark;
var address; //逆ジオロケーション用
var f_zeroresults;
var curWindow;


// 初期化。bodyのonloadでinit()を指定することで呼び出し
function gmapinit(ilat, ilon) {
    if (arguments.length == 2) {
        latlng = new google.maps.LatLng(ilat, ilon);
        var opts = {
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: latlng,
            streetViewControl: false
        };

    } else {
        // Google Mapで利用する初期設定用の変数

        var opts = {
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: latlng,
            scaleControl: true,
            streetViewControl: false

        };
    }
    // getElementById("map")の"map"は、body内の<div id="map">より
    map = new google.maps.Map(document.getElementById("map"), opts);

    // ジオコードリクエストを送信するGeocoderの作成
    geo = new google.maps.Geocoder();
    //geocli = new  google.maps.GClientGeocoder;

    google.maps.event.addListener(map, 'click', mylistener);

}

//地図上でクリックされた時
function mylistener(event) {
    //document.getElementById("show_lat").innerHTML = event.latLng.lat();
    // document.getElementById("show_lng").innerHTML = event.latLng.lng();

    document.getElementById("shopLat").value = event.latLng.lat();
    document.getElementById("shopLon").value = event.latLng.lng();

    var markerOptions = {
        position: event.latLng
    };

    if(clickMark){
      clickMark.setPosition(event.latLng);
    }else{
      clickMark = new google.maps.Marker({
                    position: event.latLng,
                    map: map
                });
    }
}

//住所を入力して緯度経度を取得ボタンを押した時
function getLocationFromAdress() {
    // GeocoderRequest
    var req = {
        address: document.getElementById("shopAddress").value
    };
    geo.geocode(req, geoResultCallback);
}

function geoResultCallback(result, status) {
    if (status != google.maps.GeocoderStatus.OK) {
        //alert(status);
        f_zeroresults = true;
        return;
    }

    latlng = result[0].geometry.location;

    map.setCenter(latlng);
    map.setZoom(16);

    // document.getElementById("show_lat").innerHTML = latlng.lat();
    // document.getElementById("show_lng").innerHTML = latlng.lng();
    document.getElementById("shopLat").value = latlng.lat();
    document.getElementById("shopLon").value = latlng.lng();

    var adrsrequest = {
        location: latlng
    };
    geo.geocode(adrsrequest, adrsResultCallback);


    var markerOptions = {
        position: latlng
    };

    if(clickMark){
      clickMark.setPosition(latlng);
    }else{
      clickMark = new google.maps.Marker({
                    position: latlng,
                    map: map
                });
    }


}

function adrsResultCallback(result, status) {
    if (status != google.maps.GeocoderStatus.OK) {
        //alert(status);
        f_zeroresults = true;
        return;
    }
    //      var place = result.geometry;
    address = result[0].formatted_address;

    //document.getElementById("input").value =  address;

}


function handleError(error) {
    document.getElementById("location").innerHTML = error.message;
}