var map = L.map('map').setView([16.9037, 121.6136], 13);

	var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);


	var markerIcon = L.icon({
		iconUrl: 'images/marker.png',
		iconSize: [30, 30]
	})

var map = L.map('map').setView([16.9037, 121.6136], 15);

var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
	maxZoom: 19,
	attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var boardinghouse1
L.marker([16.90221, 121.6112],{icon: markerIcon}).addTo(map)
.bindPopup('<b>TAGUBA BOARDINGHOUSE').openPopup();
L.marker([16.90225, 121.61099],{icon: markerIcon}).addTo(map)
.bindPopup('<b>TAGUBA BOARDINGHOUSE').openPopup();
L.marker([16.90488, 121.6132],{icon: markerIcon}).addTo(map)
.bindPopup('<b>TAGUBA BOARDINGHOUSE').openPopup();
L.marker([16.90039, 121.61772],{icon: markerIcon}).addTo(map)
.bindPopup('<b>TAGUBA BOARDINGHOUSE').openPopup();

function onMapClick(e) {
	popup
		.setLatLng(e.latlng)
		.setContent('You clicked the map at ' + e.latlng.toString())
		.openOn(map);
}

map.on('click', onMapClick);