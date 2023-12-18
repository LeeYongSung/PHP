<?php
$API_KEY = ""; // API 키 입력 (실제 배포시 배포 API 입력 바람)
$API_URL = "http://openapi.nsdi.go.kr/nsdi/PossessionService/wms/getPossessionWMS"; // API URL

$lowerLeft = explode(',', $_GET['lowerLeft']);
$upperRight = explode(',', $_GET['upperRight']);
$bbox = implode(',', array_merge($lowerLeft, $upperRight));

echo getMapImage($bbox, $API_KEY, $API_URL);

function getMapImage($bbox, $API_KEY, $API_URL) {
    $ch = curl_init();    
    $url = $API_URL;
    $queryParams = '?' . urlencode('authkey') . '=' . $API_KEY; // API 키 변경
    $queryParams .= '&' . urlencode('layers') . '=' . urlencode('173'); // 화면에 표출할 레이어명의 나열, 값은 쉼표로 구분
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
?>
