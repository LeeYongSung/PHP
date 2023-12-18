<?php
// $API_KEY = "AD4A9807-DD92-3E66-9793-146DF4ECDD7F"; // api 키 입력 (실제 배포시 배포 api 입력 바람)
$API_KEY = ""; // api 키 입력 (실제 배포시 배포 api 입력 바람)
$API_URL = "http://openapi.nsdi.go.kr/nsdi/PossessionService/wms/getPossessionWMS"; // api url
// $API_URL = "http://apis.data.go.kr/1360000/wms/openapiPossessionWMS"; // api url
// $API_URL = "http://openapi.nsdi.go.kr/nsdi/map/LandInfoBaseMapUTMKService"; // api url
function getMapImage($bbox) {
    $ch = curl_init();    
    $url = "http://openapi.nsdi.go.kr/nsdi/PossessionService/wms/getPossessionWMS"; /*URL*/    
    $queryParams = '?' . urlencode('authkey') . ''; /*Service Key*/    
    $queryParams .= '&' . urlencode('layers') . '=' . urlencode('173'); /* 화면에 표출할 레이어명의 나열, 값은 쉼표로 구분 */  
    $queryParams .= '&' . urlencode('crs') . '=' . urlencode('EPSG:5174'); /* 좌표 체계(산출물을 위한 SRS) */  
    $queryParams .= '&' . urlencode('bbox') . '=' . urlencode($bbox); /* 크기(extent)를 정의하는 범위(bounding box) */  
    $queryParams .= '&' . urlencode('width') . '=' . urlencode('915'); /* 반환 이미지의 너비(픽셀) */  
    $queryParams .= '&' . urlencode('height') . '=' . urlencode('700'); /* 반환 이미지의 높이(픽셀) */  
    $queryParams .= '&' . urlencode('format') . '=' . urlencode('image/png'); /* 반환 이미지 형식(image/png 또는 image/jpeg 또는 image/gif) */  
    $queryParams .= '&' . urlencode('transparent') . '=' . urlencode('false'); /* 반환 이미지 배경의 투명 여부(true 또는 false[기본값]) */  
    $queryParams .= '&' . urlencode('bgcolor') . '=' . urlencode('0xFFFFFF'); /* 반환 이미지의 배경색(0xRRGGBB) */  
    $queryParams .= '&' . urlencode('exceptions') . '=' . urlencode('blank'); /* 예외 발생 시 처리 방법(blank 또는 xml 또는 inimage) */  

    curl_setopt($ch, CURLOPT_URL, $url . $queryParams);    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);    
    curl_setopt($ch, CURLOPT_HEADER, FALSE);    
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');    
    $response = curl_exec($ch);    
    curl_close($ch);   

    $base64Image = base64_encode($response);
    return '<img src="data:image/png;base64,'.$base64Image.'"/>';
}

echo getMapImage('191939,445561,192155,445691'); // 첫 번째 지적도 이미지
echo getMapImage('192155,445691,192371,445821'); // 두 번째 지적도 이미지
?>

<!DOCTYPE html>
<html>
<head>
    <title>Interactive Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body>
    <div id="map" style="width: 600px; height: 400px"></div>
    <script>
        // var map = L.map('map').setView([37.56, 126.97], 13);
        var map = L.map('map').setView([37.56, 126.97], 13);

        // L.tileLayer.wms("http://apis.data.go.kr/1360000/wms/openapi", {
        L.tileLayer.wms("<?php echo $API_URL; ?>", {
            layers: '국토지리정보',
            format: 'image/png',
            transparent: true,
            version: '1.1.0',
            attribution: "Data from KOPIS",
            apikey: "<?php echo $API_KEY; ?>",
        }).addTo(map);
    </script>
</body>
</html>