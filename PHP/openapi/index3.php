<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <title>지적도 출력</title>

    <!-- ArcGIS API css -->
    <link rel="stylesheet" href="https://js.arcgis.com/4.21/esri/themes/light/main.css">
    <!-- ArcGIS API JavaScript 라이브러리 -->
    <script src="https://js.arcgis.com/4.21/"></script>
    <style>
        html,
        body,
        #viewDiv {
            padding: 0;
            margin: 0;
            height: 500px;
            width: 500px;
        }
    </style>
</head>
<body>
    <!-- 지도 표시 div -->
    <div id="viewDiv"></div>
    <!-- 지도 아래 이미지 div -->
    <div id="images"></div>
    <script>
        require([
            "esri/Map",
            "esri/views/MapView",
            "esri/geometry/Point",
            "esri/geometry/projection",
            "esri/widgets/Search"  // 검색 위젯 로드
        ], function(Map, MapView, Point, projection, Search) {
            // 맵 객체 생성
            var map = new Map({
                basemap: "hybrid" // 하이브리드 베이스맵 사용
                /*
                streets             : 도로, 건물, 주요 랜드마크 등 도시의 상세한 정보를 제공하는 베이스맵.
                satellite           : 위성 이미지를 기반으로 하는 베이스맵. 자연적인 지형이나 지역의 실제 모습.
                hybrid              : 위성 이미지 위에 도로나 주요 랜드마크 등의 정보를 겹쳐서 보여주는 베이스맵.
                terrain             : 지형 정보를 강조하여 보여주는 베이스맵. 산맥이나 계곡 등의 지형을 3D로 표현.
                topo                : 지형 정보와 도로, 건물, 주요 랜드마크 등의 정보를 함께 제공하는 베이스맵.
                dark-gray-vector    : 어두운 색상의 베이스맵, 밝은 색상의 데이터를 강조하여 보여주기에 적합.
                light-gray-vector   : 밝은 색상의 베이스맵, 어두운 색상의 데이터를 강조하여 보여주기에 적합.
                oceans              : 바다와 주변 지역의 정보를 제공하는 베이스맵. 해저 지형이나 해양 데이터를 표시하는데 적합.
                 */
            });

            // 맵 뷰를 생성
            var view = new MapView({
                container: "viewDiv", // 맵을 표시할 div 요소의 id
                map: map, // 사용할 맵 객체
                center: [126.97, 37.56], // 초기 중심 좌표
                zoom: 20 // 초기 줌 레벨 (17레벨부터 지적도 표시 가능[정해져 있는거 같음])
            });
            
            // 검색 위젯을 생성하고 뷰에 추가
            var searchWidget = new Search({
                view: view
            });
            
            view.ui.add(searchWidget, "top-right"); // 검색 위젯을 맵 뷰의 오른쪽 상단에 추가

            // projection 객체를 로드한 후
            projection.load().then(function() {
                // 맵 뷰의 extent가 변경될 때마다
                view.watch("extent", function(newValue, oldValue, propertyName, target) {
                    // 변경된 extent의 왼쪽 하단 좌표를 생성
                    var lowerLeft = new Point({
                        x: newValue.xmin,
                        y: newValue.ymin,
                        spatialReference: view.spatialReference
                    });
                    // 변경된 extent의 오른쪽 상단 좌표를 생성
                    var upperRight = new Point({
                        x: newValue.xmax,
                        y: newValue.ymax,
                        spatialReference: view.spatialReference
                    });

                    // 좌표를 원하는 좌표계로 변환
                    // 국가 공간 정보 포털에서는 UTM-K(EPSG:5179), ITRF2000(EPSG:5186), Bessel(EPSG:2097) 좌표계를 지원
                    // 좌표 변환 값 5179, 5186, 2097로 했을경우 지적도 출력 좌표값과 맞지 않음
                    // Modified Korea Central Belt 대한민국 좌표 체계 중 하나인 EPSG 5181로 변환해서 넘겨야 함
                    lowerLeft = projection.project(lowerLeft, { wkid: 5181 });
                    upperRight = projection.project(upperRight, { wkid: 5181 });

                    // 좌표의 소수점 이하를 제거
                    lowerLeft = [Math.floor(lowerLeft.x), Math.floor(lowerLeft.y)];
                    upperRight = [Math.floor(upperRight.x), Math.floor(upperRight.y)];

                    console.log(lowerLeft, upperRight);

                    // 변경된 좌표를 서버에 전달하여 이미지를 요청
                    fetch('./getMapImage.php?lowerLeft=' + lowerLeft.join(',') + '&upperRight=' + upperRight.join(','))
                        .then(response => response.text())
                        .then(imageHtml => {
                            // 응답 받은 이미지 HTML을 웹 페이지에 추가
                            document.querySelector('#images').innerHTML = '';
                            document.querySelector('#images').innerHTML += imageHtml;
                        });
                });
            });
        });
    </script>
</body>
</html>
