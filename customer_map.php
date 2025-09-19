<?php
// 7 điểm cố định (5 Smart Locker, 2 Kho)
$points = [
  ['id'=>'locker-1','type'=>'locker','name'=>'Smart Locker GO! Cần Thơ','coords'=>[105.782405,10.013725],'icon'=>'./images/smart_locker_point/locker.png'],
  ['id'=>'locker-2','type'=>'locker','name'=>'Smart Locker Đại học Cần Thơ','coords'=>[105.770782,10.029144],'icon'=>'./images/smart_locker_point/locker.png'],
  ['id'=>'locker-3','type'=>'locker','name'=>'Smart Locker Sense City Cần Thơ','coords'=>[105.785598,10.034457],'icon'=>'./images/smart_locker_point/locker.png'],
  ['id'=>'locker-4','type'=>'locker','name'=>'Smart Locker Mega Market','coords'=>[105.761449,10.023039],'icon'=>'./images/smart_locker_point/locker.png'],
  ['id'=>'locker-5','type'=>'locker','name'=>'Smart Locker Coop Mart','coords'=>[105.770930,10.054364],'icon'=>'./images/smart_locker_point/locker.png'],
  ['id'=>'warehouse-1','type'=>'warehouse','name'=>'Hub Vệ tinh','coords'=>[105.750637,10.052864],'icon'=>'./images/default_point/warehouse.png'],
  ['id'=>'warehouse-2','type'=>'warehouse','name'=>'Hub Chính','coords'=>[105.783084,10.013510],'icon'=>'.//images/default_point/warehouse.png'],
];

// Demo cảnh báo
$alerts = [
  ['id'=>'alert-2','type'=>'Traffic','name'=>'Khu vực ùn tắc giao thông','coords'=>[105.779464,10.046051],'icon'=>'./images/traffic.png'],
  ['id'=>'alert-1','type'=>'Flood','name'=>'Khu vực ngập lụt','coords'=>[105.773663,10.051739],'icon'=>'./images/flood.png'],
  ['id'=>'alert-3','type'=>'Flood','name'=>'Khu vực ngập lụt','coords'=>[105.757084,10.026777],'icon'=>'./images/flood.png'],
  ['id'=>'alert-4','type'=>'Traffic','name'=>'Khu vực ùn tắc giao thông','coords'=>[105.764714,10.021395],'icon'=>'./images/traffic.png'],
];

// Shipper xuất phát
$default_shipper = [105.750790,10.053068];

// Mapping order_id -> destination
$orderDestMap = [
  "DH001" => $points[0], // locker 1
  "DH002" => $points[1], // locker 2
  "DH003" => $points[2], // locker 3
  "DH004" => ['id'=>'dest-img1','name'=>'Điểm giao hàng của mã đơn DH004','coords'=>[105.771733,10.036914],'icon'=>'./images/destination.png'],
  "DH005" => ['id'=>'dest-img2','name'=>'Điểm giao hàng của mã đơn DH005','coords'=>[105.785614,10.021705],'icon'=>'./images/destination.png']
];

// Lấy order_id từ query
$order_id = $_GET['order_id'] ?? null;
$destination = $orderDestMap[$order_id] ?? null;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Bản đồ giao hàng & cảnh báo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://api.mapbox.com/mapbox-gl-js/v3.15.0/mapbox-gl.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://api.mapbox.com/mapbox-gl-js/v3.15.0/mapbox-gl.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <style>
    #map { width:100%; height:90vh; }
    .marker { width:36px; height:36px; background-size:contain; }
    .marker-shipper { width:48px; height:48px; background-size:contain; }
  </style>
</head>
<body>
  <div class="p-4 bg-blue-600 text-white flex justify-between items-center">
    <h1 class="text-xl font-bold">Bản đồ giao hàng</h1>
    <a href="customer.php" class="bg-white text-blue-600 px-4 py-2 rounded-lg">Quay lại</a>
  </div>
  <div id="map"></div>

<script>
mapboxgl.accessToken = "pk.eyJ1IjoicHBodWNqcyIsImEiOiJjbTV5emdvNWUwbjhhMmpweXAybThmbmVhIn0.4PA9RDEf2HFu7jMuicJ1OQ";
const map = new mapboxgl.Map({
  container:"map", style:"mapbox://styles/mapbox/streets-v11",
  center:[105.780142,10.029895], zoom:13
});

// Điểm cố định
const points = <?php echo json_encode($points); ?>;
points.forEach(pt=>{
  const el=document.createElement("div");
  el.className="marker";
  el.style.backgroundImage=`url('${pt.icon}')`;
  new mapboxgl.Marker(el).setLngLat(pt.coords)
    .setPopup(new mapboxgl.Popup({offset:25})
      .setHTML(`<b>${pt.name}</b>`)).addTo(map);
});

// Cảnh báo
const alerts = <?php echo json_encode($alerts); ?>;
alerts.forEach(al=>{
  const el=document.createElement("div");
  el.className="marker";
  el.style.backgroundImage=`url('${al.icon}')`;
  new mapboxgl.Marker(el).setLngLat(al.coords)
    .setPopup(new mapboxgl.Popup({offset:25})
      .setHTML(`<b>${al.name}</b><br>Loại: ${al.type}`)).addTo(map);
});

// Shipper
const shipperEl=document.createElement("div");
shipperEl.className="marker-shipper";
shipperEl.style.backgroundImage="url('./images/shipper.png')";
const shipperCoords = <?php echo json_encode($default_shipper); ?>;
new mapboxgl.Marker(shipperEl).setLngLat(shipperCoords)
  .setPopup(new mapboxgl.Popup({offset:25}).setHTML("<b>Shipper xuất phát từ Hub Vệ tinh</b>"))
  .addTo(map);

// Điểm đích từ order_id
const destination = <?php echo json_encode($destination); ?>;
if(destination){
  const el=document.createElement("div");
  el.className="marker";
  el.style.backgroundImage=`url('${destination.icon}')`;
  new mapboxgl.Marker(el).setLngLat(destination.coords)
    .setPopup(new mapboxgl.Popup({offset:25})
      .setHTML(`<b>${destination.name}</b>`)).addTo(map);

  map.on("load",()=>{ drawRoute(shipperCoords, destination.coords); });
}else{
  alert("❌ Không tìm thấy order_id hợp lệ!");
}

// Hàm vẽ tuyến đường
async function drawRoute(start, end){
  const query=await fetch(`https://api.mapbox.com/directions/v5/mapbox/driving/${start};${end}?geometries=geojson&alternatives=true&steps=true&access_token=${mapboxgl.accessToken}`);
  const json=await query.json();
  if(!json.routes || !json.routes.length) return;

  const mainRoute=json.routes[0];
  addRouteLayer("main-route",mainRoute.geometry,"#3b82f6",5);
}

// Thêm layer tuyến đường
function addRouteLayer(id,geometry,color,width){
  if(map.getSource(id)) return;
  map.addSource(id,{type:"geojson",data:{type:"Feature",geometry}});
  map.addLayer({
    id,type:"line",source:id,
    paint:{"line-color":color,"line-width":width,"line-opacity":0.8}
  });
}
</script>
</body>
</html>
