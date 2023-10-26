<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

include 'components/save_send.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel = "stylesheet" type = "text/css" href = "mapCSS/map.css" />
   <title>Home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/renter_header.php'; ?>
<section class="map">

   <h1 class="heading">Boarding House map and Routes</h1>

   <div class= "container">
        <div class= "boardinghouse">
        <div id="boardinghouse1">
        <a href = "AES.html"><img src = "img/a (4).jpg"/> </a>
        <h2>AES DORMITORY</h2>
        
        </div>
        <div id="boardinghouse2">
            <a href = "ABH.html"><img src = "img/a (1).jpg"/> </a>
            <h2>AUGUST BOARDING HOUSE</h2>
            </div>
            <div id="boardinghouse3">
                <a href = "VBH.html"><img src = "img/a (2).jpg"/> </a>
                <h2>VERLIA BOARDING HOUSE</h2>
                </div>  
                <div id="boardinghouse4">
                    <a href = "JJJ.html"><img src = "img/a (3).jpg"/> </a>
                    <h2>JJJ BOARDING HOUSE</h2>
                    </div>
                    
        </div>
        <div class="map" id="map">

        </div> 
        </div>
  
    </div>
    <div class= "container">
    <script>
        
    

    var map = L.map('map').setView([16.9037, 121.6136], 15);

	var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 19,
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	}).addTo(map);

    coords=[[16.902112891496145, 121.61091261639527],[16.90519091575569, 121.61306090171387],[16.90084102291009, 121.61279342638149],[16.901860241938216, 121.60940433414693]];
    //rooms
    rooms = [17,16,3,6]
    //vacant
    vacant =[9,0,2,2]
    //outside
    images = ["photo/a.jpg","photo/b.jpg","photo/c.jpg","photo/d.jpg"]

    
    let l = coords.length;
    var boardinghouse1 = document.querySelector('#boardinghouse1')
    var boardinghouse2= document.querySelector('#boardinghouse2')
    var boardinghouse3 = document.querySelector('#boardinghouse3')
    var boardinghouse4= document.querySelector('#boardinghouse4')

    boardinghouse= [boardinghouse1, boardinghouse2, boardinghouse3, boardinghouse4]
    for( let i = 0; i < l; i++) {
        //popups
    var pop = L.popup({
        closeOnClick:true
    }).setContent('<h4> rooms: '+rooms[i]+'<h4> rooms available: '+vacant[i] + '<h4> <img src=' +images[i] + ' style="height:100px">');
    //markers
        var marker = L.marker(coords[i]).addTo(map).bindPopup(pop);
    //zoomin
    boardinghouse[i].addEventListener("mouseover", ()=>{
        map.flyTo(coords[i], 18);
    })
 
}
</script>
</div>









<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

<script>

   let range = document.querySelector("#range");
   range.oninput = () =>{
      document.querySelector('#output').innerHTML = range.value;
   }

</script>

</body>
</html>
