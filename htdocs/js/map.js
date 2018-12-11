let latitude = document.getElementById("latitude").innerText;
let longitude = document.getElementById("longitude").innerText;
latitude = parseFloat(latitude);
longitude = parseFloat(longitude);
var map = new ol.Map({
    target: 'map',
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM()
        })
    ],
    view: new ol.View({
        center: ol.proj.fromLonLat([longitude, latitude]),
        zoom: 15
    })
});