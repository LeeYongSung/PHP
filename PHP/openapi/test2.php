<!DOCTYPE html>
<html>
<head>
    <title>Interactive Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.7.5/proj4.js"></script>
</head>
<body>
    <div id="map" style="width: 600px; height: 400px"></div>
    <div id="images"></div> <!-- 이미지를 추가할 div -->
    <script>
        var map = L.map('map').setView([37.56, 126.97], 13);

        map.on('moveend', function() {
            var bbox = map.getBounds().toBBoxString().split(',').map(Number); 

            var lowerLeft = [bbox[0], bbox[1]];
            var upperRight = [bbox[2], bbox[3]];

            // Proj4js 설정
            proj4 .defs('EPSG:5179','+proj=tmerc +lat_0=38 +lon_0=127.5 +k=0.9996 +x_0=1000000 +y_0=2000000 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs');
            proj4.defs("EPSG:4326","+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs");

            lowerLeft = proj4('EPSG:4326', 'EPSG:5179', lowerLeft);
            upperRight = proj4('EPSG:4326', 'EPSG:5179', upperRight);

            // Math.floor 함수를 사용하여 소수점 이하의 값을 제거
            lowerLeft = lowerLeft.map(Math.floor);
            upperRight = upperRight.map(Math.floor);

            console.log(lowerLeft, upperRight);

            fetch('./getMapImage.php?lowerLeft=' + lowerLeft.join(',') + '&upperRight=' + upperRight.join(','))
                .then(response => response.text())
                .then(imageHtml => {
                    // 응답 받은 이미지 HTML을 웹 페이지에 추가
                    document.querySelector('#images').innerHTML = '';
                    document.querySelector('#images').innerHTML += imageHtml;
                });

        });

    </script>
</body>
</html>
