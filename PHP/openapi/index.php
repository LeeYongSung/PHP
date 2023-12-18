

<!DOCTYPE html> 
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi" />
<title>국가공간정보포털</title>

<link rel="stylesheet" type="text/css" href="css/tundra.css"/>
<link rel="stylesheet" type="text/css" href="css/claro.css"/>
<link rel="stylesheet" type="text/css" href="css/esri.css"/>

<script src="js/init.js"></script>

<!-- openAPI -->
<link rel="stylesheet" href="css/jquery-ui-1.9.2.custom.min.css"/>



<!-- 부동산개방DB css 정의 -->
<link rel="stylesheet" href="css/jquery-ui-1.9.2.custom.min.css"/>
<link rel="stylesheet" href="css/style_sub_api_171117.css"/>
<!--[if lte IE 8]>
	<link rel="stylesheet" href="/nsdi/css/eios/style_sub_api_ie_171117.css" />
<![endif]-->
<link rel="stylesheet" href="css/style_16_api_171123.css"/>
<style>
body{background-color:#fff;}
</style>

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="js/run_sub_api.js"></script>
<script type="text/javascript" src="js/custom/proj4js-compressed.js"></script>
<script type="text/javascript" src="http://www.openlayers.org/api/2.13/OpenLayers.js"></script>
<SCRIPT language="JavaScript" type="text/javascript" src="http://map.vworld.kr/js/apis.do?type=Base&apiKey=AD4A9807-DD92-3E66-9793-146DF4ECDD7F&domain=http://openapi.nsdi.go.kr"></SCRIPT>

<script>
var map;
var mouseControl;
var mouseControl2;
var zoombox1;
var zoombox2;
var mapBoundsProj;
var mapBounds = new OpenLayers.Bounds(124 , 32, 130 , 38);
var mapMinZoom = 7;
var mapMaxZoom = 19;
var webUrlPort = "http://openapi.nsdi.go.kr";
var adresSpce_Layer, ctnlgsSpce_Layer, bldgisSpce_Layer, lgstspSpce_Layer, lgstgsSpce_Layer, lgstrgSpce_Layer, indstrySpce_Layer,
edcClturSpce_Layer, trnsportSpce_Layer, tritPlnSpce_Layer, tritGnrlzSpce_Layer, farmngSpce_Layer, ctySpce_Layer, mtstSpce_Layer, marnSpce_Layer, 
marnResrce_Layer, msfrtnSpce_Layer, irmcSpce_Layer, areaSpce_Layer, envrnEnergySpce_Layer, gisBuildingSpce_Layer, gisBuildingSpce_Layer2 , indvdLandPriceSpce_Layer, referLandPriceSpce_Layer, indvdHousingPriceSpce_Layer, apartHousingPriceSpce_Layer, islandsSpce_Layer, estateDevlopSpce_Layer, estateBrkpgSpce_Layer, possessionSpce_Layer;
var params;
var pnuFindTask;

// avoid pink tiles
OpenLayers.IMAGE_RELOAD_ATTEMPTS = 3;
OpenLayers.Util.onImageLoadErrorColor = "transparent";
var userProj = new OpenLayers.Projection("EPSG:3857");
var userProj2 = new OpenLayers.Projection("EPSG:2097");

require(["esri/tasks/FindTask"
         , "esri/tasks/FindParameters"]
         
, function (FindTask, FindParameters) {

		pnuFindTask = new FindTask(webUrlPort+"/nsdi/map/rest/services/opendb/EiosSpceService/Mapserver");
	    params = new FindParameters();
});

function init(){
var options = {
    controls: [],
    projection: userProj,
    displayProjection: new OpenLayers.Projection("EPSG:4326"),
    units: "m",
    controls : [],
    numZoomLevels:21,
    maxResolution: 156543.0339,
    maxExtent: new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34)
    };
map = new OpenLayers.Map('map', options);

//======================================
//1. 배경지도 추가하기

vBase = new vworld.Layers.Base('VBASE');

if (vBase != null){map.addLayer(vBase);} 

var resourceInfo = {
		singleTile: true,visibility: false,opacity: 0.5,isBaseLayer: false, projection: userProj
 	    };

adresSpce_Layer = new OpenLayers.Layer.WMS(
        "exam",
        webUrlPort+"/nsdi/map/AdresSpceService",
        {layers: ["1","2","3"],transparent: true,format: 'image/png'},
        {singleTile: true,visibility: true,opacity: 0.5,isBaseLayer: false, projection: userProj});

map.addLayer(adresSpce_Layer);


	/* 연속지적도형정보 */		
	ctnlgsSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/CtnlgsSpceService", {layers: ["6"], transparent: true,format: 'image/png'},resourceInfo);
	/*GIS건물통합정보*/
	bldgisSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/BldgisSpceService", {layers: ["8"], transparent: true,format: 'image/png'},resourceInfo);
	/*지적도근점정보*/
	lgstspSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/LgstspSpceService", {layers: ["12"], transparent: true,format: 'image/png'},resourceInfo);
	/*지적삼각보조점정보*/
	lgstgsSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/LgstgsSpceService", {layers: ["11"], transparent: true,format: 'image/png'},resourceInfo);
	/*지적삼각정보*/
	lgstrgSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/LgstrgSpceService", {layers: ["10"], transparent: true,format: 'image/png'},resourceInfo);
	/*공업주제도조회*/
	indstrySpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/IndstrySpceService", {layers: ["68","69","70","71","72","73","74"], transparent: true,format: 'image/png'},resourceInfo);
	/*교육문화주제도조회*/
	edcClturSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/EdcClturSpceService", {layers: ["120","121","122","123","124","125","126"], transparent: true,format: 'image/png'},resourceInfo);
	/*교통주제도조회*/
	trnsportSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/TrnsportSpceService", {layers: ["76","77","78","79","80","81","82","83","84"], transparent: true,format: 'image/png'},resourceInfo);
	/*국토계획주제도조회*/
	tritPlnSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/TritPlnSpceService", {layers: ["133","134","135","136","137","138","139","140","141","142","143","144","145","146","147","148","149","150","151","152","153","154","155","156","157","158"], transparent: true,format: 'image/png'},resourceInfo);
	/*국토종합주제도조회*/
	tritGnrlzSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/TritGnrlzSpceService", {layers: ["14","15"], transparent: true,format: 'image/png'},resourceInfo);
	/*농업주제도조회*/
	farmngSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/FarmngSpceService", {layers: ["41","42","43","44","45","46","47","48"], transparent: true,format: 'image/png'},resourceInfo);
	/*도시주제도조회*/
	ctySpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/CtySpceService", {layers: ["27","28","29","30","31","32","33","34","35","36","37","38","39"], transparent: true,format: 'image/png'},resourceInfo);
	/*산림주제도조회*/
	tstSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/MtstSpceService", {layers: ["50","51","52","53","54","55","56","57","58","59","60","61","62"], transparent: true,format: 'image/png'},resourceInfo);
	/*수산주제도조회*/
	marnSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/MarnSpceService", {layers: ["64","65","66"], transparent: true,format: 'image/png'},resourceInfo);
	/*수자원주제도조회*/
	marnResrce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/MarnResrceSpceService", {layers: ["86","87","88","89","90","91","92"], transparent: true,format: 'image/png'},resourceInfo);
	/*재난주제도조회*/
	msfrtnSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/MsfrtnSpceService", {layers: ["128","129","130","131"], transparent: true,format: 'image/png'},resourceInfo);
	/*정보통신주제도조회*/
	irmcSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/IrmcSpceService", {layers: ["93"], transparent: true,format: 'image/png'},resourceInfo);
	/*지역주제도조회*/
	areaSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/AreaSpceService", {layers: ["17","18","19","20","21","22","23","24","25"], transparent: true,format: 'image/png'},resourceInfo);
	/*환경에너지주제도조회*/
	envrnEnergySpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/map/EnvrnEnergySpceService", {layers: ["95","96","97","98","99","100","101","102","103","104","105","106","107","108","109","110","111","112","113","114","115","116","117","118"], transparent: true,format: 'image/png'},resourceInfo);
	
	
	//GIS건물일반정보
	gisBuildingSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/GisBuildingService/wms/getGisGnrlBuildingWMS", {layers: ["171"], transparent: true,format: 'image/png'},resourceInfo);
	//GIS건물집합정보
	gisBuildingSpce_Layer2 = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/GisBuildingService/wms/getGisAggrBuildingWMS", {layers: ["171"], transparent: true,format: 'image/png'},resourceInfo);
	//개별공시지가정보
	indvdLandPriceSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/IndvdLandPriceService/wms/getIndvdLandPriceWMS", {layers: ["166"], transparent: true,format: 'image/png'},resourceInfo); 
	//표준지공시지가정보
	referLandPriceSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/ReferLandPriceService/wms/getReferLandPriceWMS", {layers: ["166"], transparent: true,format: 'image/png'},resourceInfo); 
	//개별주택가격정보
	indvdHousingPriceSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/IndvdHousingPriceService/wms/getIndvdHousingPriceWMS", {layers: ["164"], transparent: true,format: 'image/png'},resourceInfo); 
	//공동주택가격정보
	apartHousingPriceSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/ApartHousingPriceService/wms/getApartHousingPriceWMS", {layers: ["163"], transparent: true,format: 'image/png'},resourceInfo); 
	//도서정보
	islandsSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/IslandsService/wms/getIslandsWMS", {layers: ["161"], transparent: true,format: 'image/png'},resourceInfo); 
	//부동산개발업정보
	estateDevlopSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/EstateDevlopService/wms/getEstateDevlopWMS", {layers: ["168"], transparent: true,format: 'image/png'},resourceInfo); 
	//부동산중개업정보
	estateBrkpgSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/EstateBrkpgService/wms/getEstateBrkpgWMS", {layers: ["169"], transparent: true,format: 'image/png'},resourceInfo); 
	//토지소유정보
	possessionSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/PossessionService/wms/getPossessionWMS", {layers: ["173"], transparent: true,format: 'image/png'},resourceInfo); 

	//토지특성정보
	landcharacterSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/LandCharacteristicsService/wms/getLandCharacteristicsWMS", {layers: ["F251"], transparent: true,format: 'image/png'},resourceInfo); 
	//건축물연령정보
	buildingAgeSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/BuildingAgeService/wms/getBuildingAgeWMS", {layers: ["F252"], transparent: true,format: 'image/png'},resourceInfo); 
	//용도별건물정보
	useBuildingSpce_Layer = new OpenLayers.Layer.WMS("exam", webUrlPort+"/nsdi/BuildingUseService/wms/getBuildingUseWMS", {layers: ["F253"], transparent: true,format: 'image/png'},resourceInfo); 

	map.addLayer(lgstspSpce_Layer);
	map.addLayer(lgstgsSpce_Layer);
	map.addLayer(lgstrgSpce_Layer);
	map.addLayer(indstrySpce_Layer);
	map.addLayer(edcClturSpce_Layer);
	map.addLayer(trnsportSpce_Layer);
	map.addLayer(tritPlnSpce_Layer);
	map.addLayer(tritGnrlzSpce_Layer);
	map.addLayer(farmngSpce_Layer);
	map.addLayer(ctySpce_Layer);
	map.addLayer(tstSpce_Layer);
	map.addLayer(marnSpce_Layer);
	map.addLayer(marnResrce_Layer);
	map.addLayer(msfrtnSpce_Layer);
	map.addLayer(irmcSpce_Layer);
	map.addLayer(areaSpce_Layer);
	map.addLayer(envrnEnergySpce_Layer);
	map.addLayer(ctnlgsSpce_Layer);
	map.addLayer(bldgisSpce_Layer);
	
	map.addLayer(gisBuildingSpce_Layer);
	map.addLayer(gisBuildingSpce_Layer2);
	map.addLayer(indvdLandPriceSpce_Layer);
	map.addLayer(referLandPriceSpce_Layer);
	map.addLayer(indvdHousingPriceSpce_Layer);
	map.addLayer(apartHousingPriceSpce_Layer);
	map.addLayer(islandsSpce_Layer);
	map.addLayer(estateDevlopSpce_Layer);
	map.addLayer(estateBrkpgSpce_Layer);
	map.addLayer(possessionSpce_Layer);

	//////////////////////////2017년도 추가//////////////////////////
	map.addLayer(buildingAgeSpce_Layer);
	map.addLayer(useBuildingSpce_Layer);
	map.addLayer(landcharacterSpce_Layer);
	
mapBoundsProj = mapBounds.transform(map.displayProjection, map.projection );
map.zoomToExtent(mapBoundsProj);
var scaleLineControl = new OpenLayers.Control.ScaleLine({bottomOutUnits: ''});
var scaleLineControl = new OpenLayers.Control.ScaleLine({div: document.getElementById("scaleline"),bottomOutUnits: ''});
mouseControl = new OpenLayers.Control.Navigation();
map.addControl(new OpenLayers.Control.MousePosition());

zoomBox1 = new OpenLayers.Control.ZoomBox({ out: false });
zoomBox2 = new OpenLayers.Control.ZoomBox({ out: true });
map.addControl(mouseControl);
map.addControl(scaleLineControl);
map.addControl(zoomBox1);
map.addControl(zoomBox2);


//map.addControl(new OpenLayers.Control.LayerSwitcher());
map.addControl(new OpenLayers.Control.Attribution({separator:" "}));
}

/**
 * Layer초기화
 */
initLayer = function() {
	/** @@ 2016.02.20 국토정보기본도 추가  **/
	/********************************************************************************************************/
	//LandInfoBaseMapUTMKSpec_Layer.setVisibility(false); // 국토정보기본도 정보끔
	//LandInfoBaseMapITRF2000Spec_Layer.setVisibility(false); // 국토정보기본도 정보끔
	//LandInfoBaseMapBesselSpec_Layer.setVisibility(false); // 국토정보기본도 정보끔
	
	ctnlgsSpce_Layer.setVisibility(false); //연속지적도형정보 끔
	bldgisSpce_Layer.setVisibility(false); //GIS건물통합정보 끔
	lgstspSpce_Layer.setVisibility(false); //지적도근점정보 끔
	lgstgsSpce_Layer.setVisibility(false); //지적삼각보조점정보 끔
	lgstrgSpce_Layer.setVisibility(false); //지적삼각정보 끔
	indstrySpce_Layer.setVisibility(false); //공업주제도조회 끔
	edcClturSpce_Layer.setVisibility(false); //교육문화주제도조회 끔
	trnsportSpce_Layer.setVisibility(false); //교통주제도조회 끔
	tritPlnSpce_Layer.setVisibility(false); //국토계획주제도조회 끔
	tritGnrlzSpce_Layer.setVisibility(false); //국토종합주제도조회 끔
	farmngSpce_Layer.setVisibility(false); //농업주제도조회 끔
	ctySpce_Layer.setVisibility(false); //도시주제도조회 끔
	tstSpce_Layer.setVisibility(false); //산림주제도조회 끔
	marnSpce_Layer.setVisibility(false); //수산주제도조회 끔
	marnResrce_Layer.setVisibility(false); //수자원주제도조회 끔
	msfrtnSpce_Layer.setVisibility(false); //재난주제도조회 끔
	irmcSpce_Layer.setVisibility(false); //정보통신주제도조회 끔
	areaSpce_Layer.setVisibility(false); //지역주제도조회 끔
	envrnEnergySpce_Layer.setVisibility(false); //환경에너지주제도조회 끔
	
	gisBuildingSpce_Layer.setVisibility(false);
	gisBuildingSpce_Layer2.setVisibility(false);
	indvdLandPriceSpce_Layer.setVisibility(false);
	referLandPriceSpce_Layer.setVisibility(false);
	indvdHousingPriceSpce_Layer.setVisibility(false);
	apartHousingPriceSpce_Layer.setVisibility(false);
	islandsSpce_Layer.setVisibility(false);
	estateDevlopSpce_Layer.setVisibility(false);
	estateBrkpgSpce_Layer.setVisibility(false);
	possessionSpce_Layer.setVisibility(false);
	
	
	//////////////////////////2017년 추가//////////////////////////
	buildingAgeSpce_Layer.setVisibility(false);
	useBuildingSpce_Layer.setVisibility(false);
	landcharacterSpce_Layer.setVisibility(false);
	
};

/*
 * 맵사이즈 초기화
 */
initMapSize = function() {
	
	$("#map").width($(window).width());
	if(	$('#map-service').height() > $(window).height()){
		$("#map").height($('#map-service').height());
	}else{
		$("#map").height($(window).height());	
	}
	
	
	
}; 

/*
 * windows resize
 */
 $(window).resize(function(){
	initMapSize();
 });

$(document).ready(function(){
	initMapSize();//맵사이즈 조정
	$('#zoomIn').on('click', function(e) {
		zoomBox2.deactivate();
		zoomBox1.activate();
		});
	$('#zoomOut').on('click', function(e) {
		zoomBox1.deactivate();
		zoomBox2.activate();
		});
	$('#deactivate').on('click', function(e) {
		zoomBox1.deactivate();
		zoomBox2.deactivate();
		});
	$('#zoomFullExt').on('click', function(e) {	
		map.zoomToExtent( mapBoundsProj );

	});
	
	/**
	 * 서비스 초기화
	 */
	$('#clear').on('click', function(e) {
		// 초기화 시 레이어 목록 체크 해제
		$(".checkClass").prop('checked', false);
		initLayer();//Layer초기화
		$("#legendBox").hide();//범례초기화
	});
	
	/**
	* 연속지적도형정보 레이어 IN/OUT
	*/
	$('#ctnlgsSpce').change(function(){
         if($('#ctnlgsSpce').is(":checked")){
        	ctnlgsSpce_Layer.setVisibility(true);	
        }else{
        	ctnlgsSpce_Layer.setVisibility(false);	
        }
         setLegend();
      });
	
	/**
	* GIS건물통합정보 레이어 IN/OUT
	*/
	$('#bldgisSpce').change(function(){
         if($('#bldgisSpce').is(":checked")){
        	bldgisSpce_Layer.setVisibility(true);	
        }else{
        	bldgisSpce_Layer.setVisibility(false);	
        }
         setLegend();
      });

	/**
	* 지적도근점정보 레이어 IN/OUT
	*/
	$('#lgstspSpce').change(function(){
         if($('#lgstspSpce').is(":checked")){
        	lgstspSpce_Layer.setVisibility(true);	
        }else{
        	lgstspSpce_Layer.setVisibility(false);	
        }
         setLegend();
      });

	/**
	* 지적삼각보조점정보 레이어 IN/OUT
	*/
	$('#lgstgsSpce').change(function(){
         if($('#lgstgsSpce').is(":checked")){
        	lgstgsSpce_Layer.setVisibility(true);	
        }else{
        	lgstgsSpce_Layer.setVisibility(false);	
        }
         setLegend();
      });

	/**
	* 지적삼각정보 레이어 IN/OUT
	*/
	$('#lgstrgSpce').change(function(){
         if($('#lgstrgSpce').is(":checked")){
    	 	lgstrgSpce_Layer.setVisibility(true);	
        }else{
        	lgstrgSpce_Layer.setVisibility(false);	
        }
         setLegend();
      });

	/**
	* 공업주제도조회 레이어 IN/OUT
	*/
	$('#indstrySpce').change(function(){
         if($('#indstrySpce').is(":checked")){
    	 	indstrySpce_Layer.setVisibility(true);	
        }else{
        	indstrySpce_Layer.setVisibility(false);
        }
         setLegend();
      });

    /**
	* 교육문화주제도조회 레이어 IN/OUT
	*/
	$('#edcClturSpce').change(function(){
         if($('#edcClturSpce').is(":checked")){
        	 edcClturSpce_Layer.setVisibility(true);
        }else{
        	edcClturSpce_Layer.setVisibility(false);
        }
         setLegend();
      });
       
	/**
	* 교통주제도조회 레이어 IN/OUT
	*/
	$('#trnsportSpce').change(function(){
         if($('#trnsportSpce').is(":checked")){
    	 	trnsportSpce_Layer.setVisibility(true);
        }else{
        	trnsportSpce_Layer.setVisibility(false);
        }
         setLegend();
      });

	/**
	* 국토계획주제도조회 레이어 IN/OUT
	*/
	$('#tritPlnSpce').change(function(){
         if($('#tritPlnSpce').is(":checked")){
        	tritPlnSpce_Layer.setVisibility(true);
        }else{
        	tritPlnSpce_Layer.setVisibility(false);
        }
         setLegend();
      });

  	/**
	* 국토종합주제도조회 레이어 IN/OUT
	*/
	$('#tritGnrlzSpce').change(function(){
         if($('#tritGnrlzSpce').is(":checked")){
    	 	tritGnrlzSpce_Layer.setVisibility(true);
        }else{
        	tritGnrlzSpce_Layer.setVisibility(false);	
        }
         setLegend();
      });

 	/**
	* 농업주제도조회 레이어 IN/OUT
	*/
	$('#farmngSpce').change(function(){
         if($('#farmngSpce').is(":checked")){
    	 	farmngSpce_Layer.setVisibility(true);
        }else{
        	farmngSpce_Layer.setVisibility(false);
        }
         setLegend();
      }); 

	  /**
	* 도시주제도조회 레이어 IN/OUT
	*/
	$('#ctySpce').change(function(){
         if($('#ctySpce').is(":checked")){
    	 	ctySpce_Layer.setVisibility(true);
        }else{
        	ctySpce_Layer.setVisibility(false);
        }
         setLegend();
      });

	  /**
	* 산림주제도조회 레이어 IN/OUT
	*/
	$('#mtstSpce').change(function(){
         if($('#mtstSpce').is(":checked")){
    	 	tstSpce_Layer.setVisibility(true);
        }else{
        	tstSpce_Layer.setVisibility(false);
        }
         setLegend();
      });

	  /**
	* 수산주제도조회 레이어 IN/OUT
	*/
	$('#marnSpce').change(function(){
         if($('#marnSpce').is(":checked")){
    	 	marnSpce_Layer.setVisibility(true);	
        }else{
        	marnSpce_Layer.setVisibility(false);
        }
         setLegend();
      });

	  /**
	* 수자원주제도조회 레이어 IN/OUT
	*/
	$('#marnResrce').change(function(){
         if($('#marnResrce').is(":checked")){
    	 	marnResrce_Layer.setVisibility(true);
        }else{
        	marnResrce_Layer.setVisibility(false);
        }
         setLegend();
      });

	  /**
	* 재난주제도조회 레이어 IN/OUT
	*/
	$('#msfrtnSpce').change(function(){
         if($('#msfrtnSpce').is(":checked")){
    	 	msfrtnSpce_Layer.setVisibility(true);
        }else{
        	msfrtnSpce_Layer.setVisibility(false);	
        }
         setLegend();
      });

	  /**
	* 정보통신주제도조회 레이어 IN/OUT
	*/
	$('#irmcSpce').change(function(){
         if($('#irmcSpce').is(":checked")){
    	 	irmcSpce_Layer.setVisibility(true);	
        }else{
        	irmcSpce_Layer.setVisibility(false);
        }
         setLegend();
      });


    	  /**
	* 지역주제도조회 레이어 IN/OUT
	*/
	$('#areaSpce').change(function(){
       if($('#areaSpce').is(":checked")){
  	 	areaSpce_Layer.setVisibility(true);
      }else{
      	areaSpce_Layer.setVisibility(false);
      }
       setLegend();
    }); 

   	  /**
	* 환경에너지주제도조회 레이어 IN/OUT
	*/
	$('#envrnEnergySpce').change(function(){
         if($('#envrnEnergySpce').is(":checked")){
    	 	envrnEnergySpce_Layer.setVisibility(true);
        }else{
        	envrnEnergySpce_Layer.setVisibility(false);
        }
        setLegend();
      });
   	  
	  /**
	* GIS건물일반정보조회 레이어 IN/OUT
	*/
	$('#gisBuildingSpce').change(function(){
         if($('#gisBuildingSpce').is(":checked")){
    	 	gisBuildingSpce_Layer.setVisibility(true);
        }else{
        	gisBuildingSpce_Layer.setVisibility(false);
        }
        setLegend();
      });
	  /**
	* GIS건물집합정보조회 레이어 IN/OUT
	*/
	$('#gisBuildingSpce2').change(function(){
         if($('#gisBuildingSpce2').is(":checked")){
    	 	gisBuildingSpce_Layer2.setVisibility(true);
        }else{
        	gisBuildingSpce_Layer2.setVisibility(false);
        }
        setLegend();
      });
  /**
	* 개별공시지가정보 레이어 IN/OUT
	*/
	$('#indvdLandPriceSpce').change(function(){
         if($('#indvdLandPriceSpce').is(":checked")){
    	 	indvdLandPriceSpce_Layer.setVisibility(true);
        }else{
        	indvdLandPriceSpce_Layer.setVisibility(false);
        }
        setLegend();
      });
  /**    
	* 표준지공시지가정보 레이어 IN/OUT
	*/
	$('#referLandPriceSpce').change(function(){
         if($('#referLandPriceSpce').is(":checked")){
    	 	referLandPriceSpce_Layer.setVisibility(true);
        }else{
        	referLandPriceSpce_Layer.setVisibility(false);
        }
        setLegend();
      });
  /**    
	* 개별주택가격정보 레이어 IN/OUT
	*/
	$('#indvdHousingPriceSpce').change(function(){
         if($('#indvdHousingPriceSpce').is(":checked")){
    	 	indvdHousingPriceSpce_Layer.setVisibility(true);
        }else{
        	indvdHousingPriceSpce_Layer.setVisibility(false);
        }
        setLegend();
      });
  /**    
	* 공동주택가격정보 레이어 IN/OUT
	*/
	$('#apartHousingPriceSpce').change(function(){
         if($('#apartHousingPriceSpce').is(":checked")){
    	 	apartHousingPriceSpce_Layer.setVisibility(true);
        }else{
        	apartHousingPriceSpce_Layer.setVisibility(false);
        }
        setLegend();
      });
  /**    
	* 도서정보 레이어 IN/OUT
	*/
	$('#islandsSpce').change(function(){
         if($('#islandsSpce').is(":checked")){
    	 	islandsSpce_Layer.setVisibility(true);
        }else{
        	islandsSpce_Layer.setVisibility(false);
        }
        setLegend();
      });
  /**    
	* 부동산개발업정보 레이어 IN/OUT
	*/
	$('#estateDevlopSpce').change(function(){
         if($('#estateDevlopSpce').is(":checked")){
    	 	estateDevlopSpce_Layer.setVisibility(true);
        }else{
        	estateDevlopSpce_Layer.setVisibility(false);
        }
        setLegend();
      });
  /**    
	* 부동산중개업정보 레이어 IN/OUT
	*/
	$('#estateBrkpgSpce').change(function(){
         if($('#estateBrkpgSpce').is(":checked")){
    	 	estateBrkpgSpce_Layer.setVisibility(true);
        }else{
        	estateBrkpgSpce_Layer.setVisibility(false);
        }
        setLegend();
      });
  /**    
	* 토지소유정보 레이어 IN/OUT
	*/
	$('#possessionSpce').change(function(){
         if($('#possessionSpce').is(":checked")){
    	 	possessionSpce_Layer.setVisibility(true);
        }else{
        	possessionSpce_Layer.setVisibility(false);
        }
        setLegend();
      });
  
  //////////////2017년도 추가////////////////////
  
    /**    
	* 건축물연령정보 레이어 IN/OUT
	*/
	$('#buildingAgeSpce').change(function(){
         if($('#buildingAgeSpce').is(":checked")){
        	 buildingAgeSpce_Layer.setVisibility(true);
        }else{
        	buildingAgeSpce_Layer.setVisibility(false);
        }
        setLegend();
      });
  
	  /**    
	* 용도별건물정보 레이어 IN/OUT
	*/
	$('#useBuildingSpce').change(function(){
         if($('#useBuildingSpce').is(":checked")){
        	 useBuildingSpce_Layer.setVisibility(true);
        }else{
        	useBuildingSpce_Layer.setVisibility(false);
        }
        setLegend();
      });
	  
	  /**    
	* 토지특성정보 레이어 IN/OUT
	*/
	$('#landcharacterSpce').change(function(){
         if($('#landcharacterSpce').is(":checked")){
        	 landcharacterSpce_Layer.setVisibility(true);
        }else{
        	landcharacterSpce_Layer.setVisibility(false);
        }
        setLegend();
      });
  
	/*********************************************************************************
	**********************************법정동 검색 조건 *******************************
	*********************************************************************************/
	/**
	* 시,도 selectbox 세팅
	*/
	
	$.ajax 
	  ({ 
	   type: "GET", 
	   url: webUrlPort+"/nsdi/eios/service/rest/AdmService/admCodeList.json", 
	   dataType: 'json',    
	   contentType: "application/x-www-form-urlencoded; charset=UTF-8",
	   success: function(data) 
	   { 
		  $("select[name='siArea']").find('option').each(function() {
				$(this).remove();
		  });
		   $("select[name='dongArea']").find('option').each(function() {
			$(this).remove();
		  });
		   $("select[name='reeArea']").find('option').each(function() {
			$(this).remove();
		  });		   
		  var admVoList = data.admVOList.admVOList;
		  $("#doArea").append("<option value=''>선택</option>");
		  
		  for(var i=0;i< admVoList.length ;i++ ){
	    	  $("#doArea").append("<option value='"+admVoList[i].admCode+"'>"+admVoList[i].lowestAdmCodeNm+"</option>");
			 
	      }
	   } 
	});  
	/**
	* 시,군,구 selectbox 세팅
	*/
	$('#doArea').change(function(){		
		    
		var doArea = $('#doArea').val();
		
		$.ajax 
		  ({ 
		   type: "GET", 
		   url: webUrlPort+"/nsdi/eios/service/rest/AdmService/admSiList.json?admCode="+doArea, 
		   dataType: 'json',    
		   contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		   success: function(data) 
		   {    
			  
			  $("select[name='siArea']").find('option').each(function() {
				$(this).remove();
			  });
			   $("select[name='dongArea']").find('option').each(function() {
				$(this).remove();
			  });
			   $("select[name='reeArea']").find('option').each(function() {
				$(this).remove();
			  });
			  $("#siArea").append("<option value=''>선택</option>");
			  var admVoList = data.admVOList.admVOList;
			  
			 
			  for(var i=0;i< admVoList.length ;i++ ){
				 
		    	  $("#siArea").append("<option value='"+admVoList[i].admCode+"'>"+admVoList[i].lowestAdmCodeNm+"</option>")
		      
			  }
		   } 
		});  
	});
	/**
	* 읍면동 selectbox 세팅
	*/
	$('#siArea').change(function(){		
		    
		var siArea = $('#siArea').val();
		
		$.ajax 
		  ({ 
		   type: "GET", 
		   url: webUrlPort+"/nsdi/eios/service/rest/AdmService/admDongList.json?admCode="+siArea, 
		   dataType: 'json',    
		   contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		   success: function(data) 
		   { 
			  
			   $("select[name='dongArea']").find('option').each(function() {
				$(this).remove();
			  });
			   $("select[name='reeArea']").find('option').each(function() {
				$(this).remove();
			  });
			  $("#dongArea").append("<option value=''>선택</option>")
			  var admVoList = data.admVOList.admVOList;
			  for(var i=0;i< admVoList.length ;i++ ){
		    	  $("#dongArea").append("<option value='"+admVoList[i].admCode+"'>"+admVoList[i].lowestAdmCodeNm+"</option>")
		      }
		   } 
		});  
	});
	/**
	* 읍면동 selectbox 세팅
	*/
	$('#dongArea').change(function(){		
		    
		var dongArea = $('#dongArea').val();
		
		$.ajax 
		  ({ 
		   type: "GET", 
		   url: webUrlPort+"/nsdi/eios/service/rest/AdmService/admReeList.json?admCode="+dongArea, 
		   dataType: 'json',    
		   contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		   success: function(data) 
		   { 
			  $("select[name='reeArea']").find('option').each(function() {
			  	$(this).remove();
			  });
			  $("#reeArea").append("<option value=''>선택</option>")
			  var admVoList = data.admVOList.admVOList;
			  for(var i=0;i< admVoList.length ;i++ ){
				  
				  if(admVoList[i].admCode.substring(8,10) != '00'){
					  $("#reeArea").append("<option value='"+admVoList[i].admCode+"'>"+admVoList[i].lowestAdmCodeNm+"</option>")  
				  }
		    	  
		      }
		   } 
		});  
	});
	
	/**
	* 검색
	*/
	$('#searchBtn').click(function(){		
	    
		var doArea = $.trim($('#doArea').val());
		var siArea = $.trim($('#siArea').val());
		var dongArea = $.trim($('#dongArea').val());
		var reeArea = $.trim($('#reeArea').val());
		
		var layerId = "215";
		var searchField = "LD_CPSG_CODE";//법정동_시도시군구_코드
		var searchText = doArea;
		
		if(doArea != '' && siArea == '' ){
			layerId = "215";//159
			searchField = "LD_CPSG_CODE";//법정동_시도시군구_코드
			searchText = doArea;
		}
		if(siArea != '' && dongArea == '' ){
			layerId = "214";//158
			searchField = "LD_CPSG_CODE";///법정동_시도시군구_코드
			searchText = siArea;
		}
		if(dongArea != '' && reeArea == '' ){
			layerId = "213";//157
			searchField = "LD_EMD_CODE";//법정동_읍면동_코드
			searchText = dongArea;
		}
		if(reeArea != ''  ){
			layerId = "212";//156
			searchField = "LD_LI_CODE";//법정동리
			searchText = reeArea ;
		}
		if(doArea == ''){
			alert("시도를 선택하세요");
			return;
		}
		if(siArea == ''){
			alert("시군구를 선택하세요");
			return;
		}
		if(dongArea == ''){
			alert("읍면동을 선택하세요");
			return;
		}
	    params.layerIds = [layerId];
	    params.searchFields = [searchField];
	    params.searchText = searchText;
	    params.returnGeometry = true;
	    params.contains = false;
	    pnuFindTask.execute(params, showFinds);
		
	});
	
	function showFinds(myFeatureSet) {
    	if ( myFeatureSet.length == 0 ) {
    		findGraphic = null;
    		return;
    	}						

    	var featureSet = myFeatureSet[0];
        findGraphic = featureSet.feature;
    	var unionedExtent = findGraphic.geometry.getExtent();
    	
    	var searchBounds = new OpenLayers.Bounds(unionedExtent.xmin,unionedExtent.ymin,unionedExtent.xmax,unionedExtent.ymax);

    	searchBounds = searchBounds.transform( userProj2,map.projection);
    	map.zoomToExtent(searchBounds);

	}
	
	function setLegend () {
		$("#legendDiv").children().remove();
		
		 if($('#ctnlgsSpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>연속지적도형정보</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(255,0,0);'>&nbsp;</span>&nbsp;연속지적도형</li>");
		 }
		 if($('#bldgisSpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>GIS건물통합정보</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(210,227,250);'>&nbsp;</span>&nbsp;GIS건물통합</li>");
		 }
		 if($('#lgstspSpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>지적도근점정보</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,112,255); background-color: rgb(0,112,255);'>&nbsp;</span>&nbsp;지적도근점</li>");
		 }
		 if($('#lgstgsSpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>지적삼각보조점정보</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(153,0,61); background-color: rgb(153,0,61);'>&nbsp;</span>&nbsp;지적삼각보조점</li>");
		 }
		 if($('#lgstrgSpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>지적삼각점정보</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(255,0,0); background-color: rgb(255,0,0);'>&nbsp;</span>&nbsp;지적삼각점</li>");
			 
		 }
		 if($('#indstrySpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>공업주제도</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0);'>&nbsp;</span>&nbsp;공업/기타용도지역지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(23,46,111);'>&nbsp;</span>&nbsp;산업입지/산업단지</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(32,100,21);'>&nbsp;</span>&nbsp;공업배치/용도지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(23,46,111);'>&nbsp;</span>&nbsp;기업활동/공장입지</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,200,10);'>&nbsp;</span>&nbsp;자유무역지역설치/용도지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(23,100,200); '>&nbsp;</span>&nbsp;유통단지개발촉진/유통단지</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(183,14,182);'>&nbsp;</span>&nbsp;유통단지개발촉진/협동화단지</li>");
		 }
		 if($('#edcClturSpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>교육문화주제도</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(137,112,68);'>&nbsp;</span>&nbsp;교육문화/기타용도지역지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(211,211,42);'>&nbsp;</span>&nbsp;학교환경위생정화구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(113,131,251);'>&nbsp;</span>&nbsp;청소년기본/청소년수련지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(141,14,14);'>&nbsp;</span>&nbsp;문화재/문화재보호</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(123,11,114);'>&nbsp;</span>&nbsp;문화재/전통건조물보존</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(43,57,129); '>&nbsp;</span>&nbsp;전통사찰/전통사찰보존</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(189,189,0);'>&nbsp;</span>&nbsp;관광진흥/관광지</li>");
		 }
		 if($('#trnsportSpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>교통주제도</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0);'>&nbsp;</span>&nbsp;교통/기타용도지역지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(231,100,245);'>&nbsp;</span>&nbsp;도로/용도구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(173,134,153);'>&nbsp;</span>&nbsp;고속국도/접도구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(29,200,200);'>&nbsp;</span>&nbsp;철도/철도선로인접지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(139,100,0);'>&nbsp;</span>&nbsp;고속철도/고속철도건설예정지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(200,200,10);'>&nbsp;</span>&nbsp;항만/용도구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(210,9,0);'>&nbsp;</span>&nbsp;신항만/신항만건설예정지역</li>");
			 //$('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(200,30,100);'>&nbsp;</span>&nbsp;항공/공항구역</li>");
			 //$('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(223,190,50);'>&nbsp;</span>&nbsp;신항공/수도권신공항건설예정지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,111,111);'>&nbsp;</span>&nbsp;도시교통정비촉진/도시교통정비지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(96,127,126);'>&nbsp;</span>&nbsp;교통/주차장</li>");
		 }
		 if($('#tritPlnSpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>국토계획주제도</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(80,130,130); background-color: rgb(80,130,130);'>&nbsp;</span>&nbsp;국토계획/도시지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(80,170,170); background-color: rgb(80,170,170);'>&nbsp;</span>&nbsp;국토계획/관리지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(200,200,0); background-color: rgb(200,200,0);'>&nbsp;</span>&nbsp;국토계획/농림지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(100,200,100); background-color: rgb(100,200,100);'>&nbsp;</span>&nbsp;국토계획/자연환경보전지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(130,130,90); background-color: rgb(130,130,90);'>&nbsp;</span>&nbsp;국토계획/기타용도지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(250,130,41);'>&nbsp;</span>&nbsp;국토계획/경관지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(170,240,170);'>&nbsp;</span>&nbsp;국토계획/미관지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(48,122,214);'>&nbsp;</span>&nbsp;국토계획/고도지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(255,0,0);'>&nbsp;</span>&nbsp;국토계획/방화지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(38,169,19);'>&nbsp;</span>&nbsp;국토계획/방재지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0); background-color: rgb(124,0,96);'>&nbsp;</span>&nbsp;국토계획/보존지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0);'>&nbsp;</span>&nbsp;국토계획/시설보호지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(181,49,114);'>&nbsp;</span>&nbsp;국토계획/취락지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(159,112,162);'>&nbsp;</span>&nbsp;국토계획/개발진흥지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0);'>&nbsp;</span>&nbsp;국토계획/특정용도제한지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0);'>&nbsp;</span>&nbsp;국토계획/기타용도지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0);'>&nbsp;</span>&nbsp;국토계획/구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(23,46,111);'>&nbsp;</span>&nbsp;국토계획/도시계획사업지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(56,90,89);'>&nbsp;</span>&nbsp;국토계획/교통시설</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(184,0,0);'>&nbsp;</span>&nbsp;국토계획/공간시설</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(182,0,0);'>&nbsp;</span>&nbsp;국토계획/유통및공급시설</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(189,0,0);'>&nbsp;</span>&nbsp;국토계획/공공문화체육시설</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(186,0,0);'>&nbsp;</span>&nbsp;국토계획/방재시설</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(140,140,140); background-color: rgb(128,128,128);'>&nbsp;</span>&nbsp;국토계획/보건위생시설</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(140,140,140); background-color: rgb(128,128,128);'>&nbsp;</span>&nbsp;국토계획/환경기초시설</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(140,140,140); background-color: rgb(128,128,128);'>&nbsp;</span>&nbsp;국토계획/기타기반시설</li>");
		 }
		 if($('#tritGnrlzSpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>국토종합주제도</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(180,100,100); background-color: rgb(,,);'>&nbsp;</span>&nbsp;국토/기타용도지역지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(130,130,80);'>&nbsp;</span>&nbsp;국토/용도지역</li>");
		 }
		 if($('#farmngSpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>농업주제도</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(255,70,71);'>&nbsp;</span>&nbsp;농업/기타용도지역지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(192,148,100);'>&nbsp;</span>&nbsp;농지/농업진흥지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(255,128,128); background-color: rgb(255,128,255);'>&nbsp;</span>&nbsp;영농여건불리농지/영농여건불리농지</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(245,144,141);'>&nbsp;</span>&nbsp;농어촌주택개량촉진/농어촌주거환경개선</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(55,151,151);'>&nbsp;</span>&nbsp;농어촌정비/농어촌정비</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(178,123,178);'>&nbsp;</span>&nbsp;축산/가축보호지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(255,128,128); background-color: rgb(255,128,255);'>&nbsp;</span>&nbsp;새만금사업/새만금사업지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(255,128,128); background-color: rgb(255,128,255);'>&nbsp;</span>&nbsp;농업생산기반시설/주변지역활용구역</li>");
		 }
		 if($('#ctySpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>도시주제도</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(222,222,0);'>&nbsp;</span>&nbsp;도시/기타용도지역지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(255,0,255);'>&nbsp;</span>&nbsp;건축/재해위험구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(128,128,128); background-color: rgb(140,140,140);'>&nbsp;</span>&nbsp;건축/용도지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(154,156,1112);'>&nbsp;</span>&nbsp;택지개발/택지개발예정구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,33,255);'>&nbsp;</span>&nbsp;토지구획정리/토지구획정리사업지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(169,158,121);'>&nbsp;</span>&nbsp;도시재개발/재개발구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(155,206,255);'>&nbsp;</span>&nbsp;주거환경개선특별/주거환경개선지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(155,206,255);'>&nbsp;</span>&nbsp;도시및주거환경정비/정비구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(128,128,128); background-color: rgb(140,140,140);'>&nbsp;</span>&nbsp;국민임대주택/용도지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,111,69);'>&nbsp;</span>&nbsp;토지형질변경규제지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,255);'>&nbsp;</span>&nbsp;개발제한구역지관리/개발제한구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(222,222,0);'>&nbsp;</span>&nbsp;도시개발/도시개발구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(255,128,128); background-color: rgb(255,128,255);'>&nbsp;</span>&nbsp;도청이전/신도시개발예정지구</li>");
		 }
		 if($('#mtstSpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>산림주제도</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(255,128,128); background-color: rgb(255,128,255);'>&nbsp;</span>&nbsp;산림/기타용도지역지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,208,136);'>&nbsp;</span>&nbsp;산림/보전임지</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(23,46,111);'>&nbsp;</span>&nbsp;산림/준보전임지</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(14,40,226);'>&nbsp;</span>&nbsp;산림/기타용도지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(128,128,128); background-color: rgb(140,140,140);'>&nbsp;</span>&nbsp;산림/이용형태에따른산림</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,200,255);'>&nbsp;</span>&nbsp;조수보호/조수보호</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(200,100,29);'>&nbsp;</span>&nbsp;사방사업/사방지</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(255,100,100);'>&nbsp;</span>&nbsp;초지/초지</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(241,240,0);'>&nbsp;</span>&nbsp;낙농진흥/낙농지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(100,110,150);'>&nbsp;</span>&nbsp;임업진흥촉진/임업진흥촉진권역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(128,128,128); background-color: rgb(140,140,140);'>&nbsp;</span>&nbsp;수목원조성및진흥/용도지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(128,128,128); background-color: rgb(140,140,140);'>&nbsp;</span>&nbsp;산지관리/보전준보전산지</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(128,128,128); background-color: rgb(140,140,140);'>&nbsp;</span>&nbsp;산지관리/기타용도지역</li>");
		 }
		 if($('#marnSpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>수산주제도</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0);'>&nbsp;</span>&nbsp;수산/기타용도지역지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(189,100,231);'>&nbsp;</span>&nbsp;수산/어항구역(육역)</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(23,46,111);'>&nbsp;</span>&nbsp;수산업/수면</li>");
		 }
		 if($('#marnResrce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>수자원주제도</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0);'>&nbsp;</span>&nbsp;수자원/기타용도지역지구</li>");
			 //$('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(23,11,100);'>&nbsp;</span>&nbsp;댐건설예정지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(100,52,231);'>&nbsp;</span>&nbsp;하천/용도구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(234,155,199);'>&nbsp;</span>&nbsp;소하천/소하천구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(231,200,10);'>&nbsp;</span>&nbsp;온천/온천지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,121,0);'>&nbsp;</span>&nbsp;지하수/지하수보전구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(210,100,0);'>&nbsp;</span>&nbsp;공유수면/공유수면</li>");
			 				 
		 }
		 if($('#msfrtnSpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>재난주제도</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0);'>&nbsp;</span>&nbsp;재해재난/기타용도지역지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,200,100);'>&nbsp;</span>&nbsp;재해재난/화재경계지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,111,152);'>&nbsp;</span>&nbsp;자연재해/재해위험지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(51,112,112);'>&nbsp;</span>&nbsp;재난관리/재난위험지역</li>");
			 //$('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(255,128,128); background-color: rgb(255,128,255);'>&nbsp;</span>&nbsp;저수지및댐안전/정비지구</li>");
		 }
		 if($('#irmcSpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>정보통신주제도</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0);'>&nbsp;</span>&nbsp;정통/기타용도지역지구</li>");
			 //$('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(210,100,231);'>&nbsp;</span>&nbsp;전파/전파방해방지구역</li>");
		 }
		 if($('#areaSpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>지역주제도</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0);'>&nbsp;</span>&nbsp;지역/기타용도지역지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(23,46,111);'>&nbsp;</span>&nbsp;지역/수도권정비권역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(23,46,111);'>&nbsp;</span>&nbsp;지역/지역균형개발및중소기업육성</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(128,128,128); background-color: rgb(140,140,140);'>&nbsp;</span>&nbsp;지역특화발전규제/특구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(128,128,128); background-color: rgb(140,140,140);'>&nbsp;</span>&nbsp;대덕연구개발특구/용도구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(23,46,111);'>&nbsp;</span>&nbsp;지역/탄광지역진흥사업추진대상지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(23,46,111);'>&nbsp;</span>&nbsp;지역/폐광지역진흥지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(255,128,128); background-color: rgb(255,128,255);'>&nbsp;</span>&nbsp;혁신도시개발예정/용도지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(255,128,128); background-color: rgb(255,128,255);'>&nbsp;</span>&nbsp;신발전지역육성/발전구역</li>");
		 }
		 if($('#envrnEnergySpce').is(":checked")){
			 $('#legendDiv').append("<li class='legend-nm'>환경에너지주제도</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0);'>&nbsp;</span>&nbsp;에너지/기타용도지역지구</li>");
			 //$('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(200,100,100);'>&nbsp;</span>&nbsp;원자력/제한구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,210,210);'>&nbsp;</span>&nbsp;전원개발/용도구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(30,200,41);'>&nbsp;</span>&nbsp;집단에너지공급대상지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(23,46,111);'>&nbsp;</span>&nbsp;광업/광구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(209,200,21);'>&nbsp;</span>&nbsp;석탄산업/탄좌</li>");
			 //$('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(200,78,100);'>&nbsp;</span>&nbsp;해저광물개발구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0);'>&nbsp;</span>&nbsp;가축분뇨의관리및이용/가축사육제한구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(124,124,155);'>&nbsp;</span>&nbsp;자연공원/용도구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(155,112,112);'>&nbsp;</span>&nbsp;자연공원/용도지구</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(245,0,231);'>&nbsp;</span>&nbsp;자연환경/용도지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(194,14,193);'>&nbsp;</span>&nbsp;자연환경/용도구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(128,128,128); background-color: rgb(140,140,140);'>&nbsp;</span>&nbsp;야생생물보호/용도구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(111,0,177);'>&nbsp;</span>&nbsp;대기환경/대기환경규제지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(161,141,34);'>&nbsp;</span>&nbsp;토양환경/토양보전대책지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(199,199,199);'>&nbsp;</span>&nbsp;폐기물처리시설설치지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(231,123,141);'>&nbsp;</span>&nbsp;소음진동규제/소음진동규제지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,160,162);'>&nbsp;</span>&nbsp;수도/상수원보호</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,174,174);'>&nbsp;</span>&nbsp;상수원관리/환경정비구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(93,138,177);'>&nbsp;</span>&nbsp;한강수계/수변구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(128,128,128); background-color: rgb(140,140,140);'>&nbsp;</span>&nbsp;낙동강수계/수변구역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(141,111,111);'>&nbsp;</span>&nbsp;환경정책기본/특별대책지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(45,131,135);'>&nbsp;</span>&nbsp;수질환경보전/공공수역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(22,55,99);'>&nbsp;</span>&nbsp;자원절약과재활용촉진/재활용단지</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(161,141,34);'>&nbsp;</span>&nbsp;습지보전/습지보호지역</li>");
			 $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0);'>&nbsp;</span>&nbsp;독도등도시지역의생태계보전/특정도서</li>");
		 }
		 if($('#gisBuildingSpce').is(":checked")){
			  $('#legendDiv').append("<li class='legend-nm'>GIS건물일반주제도</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(190,210,255);'>&nbsp;</span>&nbsp;GIS건물일반</li>");
		 }
		 if($('#gisBuildingSpce2').is(":checked")){
			  $('#legendDiv').append("<li class='legend-nm'>GIS건물집합주제도</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(233,255,190);'>&nbsp;</span>&nbsp;GIS건물집합</li>");
		}
		 if($('#indvdLandPriceSpce').is(":checked")){
			  $('#legendDiv').append("<li class='legend-nm'>개별공시지가주제도</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(205,233,247);'>&nbsp;</span>&nbsp;기타</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(241,225,177);'>&nbsp;</span>&nbsp;전</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(193,254,192);'>&nbsp;</span>&nbsp;답</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(254,197,182);'>&nbsp;</span>&nbsp;과수원</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(236,170,130);'>&nbsp;</span>&nbsp;목장용지</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(151,215,191);'>&nbsp;</span>&nbsp;임야</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(249,211,208);'>&nbsp;</span>&nbsp;광천지</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(230,230,255);'>&nbsp;</span>&nbsp;염전</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(254,206,248);'>&nbsp;</span>&nbsp;대</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(173,209,224);'>&nbsp;</span>&nbsp;공장용지</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(201,147,255);'>&nbsp;</span>&nbsp;학교용지</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(225,225,225);'>&nbsp;</span>&nbsp;주차장</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(193,199,250);'>&nbsp;</span>&nbsp;주유소용지</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(101,247,250);'>&nbsp;</span>&nbsp;창고용지</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(190,194,220);'>&nbsp;</span>&nbsp;도로</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(207,253,354);'>&nbsp;</span>&nbsp;철도용지</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(128,128,255);'>&nbsp;</span>&nbsp;하천</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(117,180,236);'>&nbsp;</span>&nbsp;제방</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(255,255,0);'>&nbsp;</span>&nbsp;구거</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(228,222,143);'>&nbsp;</span>&nbsp;유지</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(141,227,117);'>&nbsp;</span>&nbsp;양어장</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(196,210,142);'>&nbsp;</span>&nbsp;수도용지</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(162,167,210);'>&nbsp;</span>&nbsp;공원</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(168,173,99);'>&nbsp;</span>&nbsp;체육용지</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(209,182,180);'>&nbsp;</span>&nbsp;유원지</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(209,182,225);'>&nbsp;</span>&nbsp;종교용지</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(209,225,180);'>&nbsp;</span>&nbsp;사적지</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(151,182,180);'>&nbsp;</span>&nbsp;묘지</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(243,216,248);'>&nbsp;</span>&nbsp;잡종지</li>");
			}
		 	if($('#referLandPriceSpce').is(":checked")){
			  $('#legendDiv').append("<li class='legend-nm'>표준지공시지가주제도</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(205,233,247);'>&nbsp;</span>&nbsp;기타(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(241,225,177);'>&nbsp;</span>&nbsp;전(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(193,254,192);'>&nbsp;</span>&nbsp;답(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(254,197,182);'>&nbsp;</span>&nbsp;과수원(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(236,170,130);'>&nbsp;</span>&nbsp;목장용지(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(151,215,191);'>&nbsp;</span>&nbsp;임야(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(249,211,208);'>&nbsp;</span>&nbsp;광천지(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(230,230,255);'>&nbsp;</span>&nbsp;염전(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(254,206,248);'>&nbsp;</span>&nbsp;대(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(173,209,224);'>&nbsp;</span>&nbsp;공장용지(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(201,147,255);'>&nbsp;</span>&nbsp;학교용지(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(225,225,225);'>&nbsp;</span>&nbsp;주차장(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(193,199,250);'>&nbsp;</span>&nbsp;주유소용지(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(101,247,250);'>&nbsp;</span>&nbsp;창고용지(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(190,194,220);'>&nbsp;</span>&nbsp;도로(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(207,253,354);'>&nbsp;</span>&nbsp;철도용지(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(128,128,255);'>&nbsp;</span>&nbsp;하천(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(117,180,236);'>&nbsp;</span>&nbsp;제방(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(255,255,0);'>&nbsp;</span>&nbsp;구거(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(228,222,143);'>&nbsp;</span>&nbsp;유지(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(141,227,117);'>&nbsp;</span>&nbsp;양어장(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(196,210,142);'>&nbsp;</span>&nbsp;수도용지(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(162,167,210);'>&nbsp;</span>&nbsp;공원(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(168,173,99);'>&nbsp;</span>&nbsp;체육용지(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(209,182,180);'>&nbsp;</span>&nbsp;유원지(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(209,182,225);'>&nbsp;</span>&nbsp;종교용지(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(209,225,180);'>&nbsp;</span>&nbsp;사적지(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(151,182,180);'>&nbsp;</span>&nbsp;묘지(표)</li>");
			  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(243,216,248);'>&nbsp;</span>&nbsp;잡종지(표)</li>");
			}
		 	if($('#indvdHousingPriceSpce').is(":checked")){
		 		  $('#legendDiv').append("<li class='legend-nm'>개별주택가격주제도</li>");
		 		  $('#legendDiv').append("<li><img src='/nsdi/img/eios/sub_img/openapi_exam_icon05.png' width='25' height='25'/>&nbsp;개별주택가격</li>");
		 	}
		 	if($('#apartHousingPriceSpce').is(":checked")){
		 		  $('#legendDiv').append("<li class='legend-nm'>공동주택가격주제도</li>");
		 		  $('#legendDiv').append("<li><img src='/nsdi/img/eios/sub_img/openapi_exam_icon06.png' width='25' height='25'/>&nbsp;아파트</li>");
		 		  $('#legendDiv').append("<li><img src='/nsdi/img/eios/sub_img/openapi_exam_icon07.png' width='25' height='25'/>&nbsp;빌라</li>");
		 		  $('#legendDiv').append("<li><img src='/nsdi/img/eios/sub_img/openapi_exam_icon08.png' width='25' height='25'/>&nbsp;다세대</li>");
		 	}	
		 	if($('#estateDevlopSpce').is(":checked")){
		 		  $('#legendDiv').append("<li class='legend-nm'>부동산개발업주제도</li>");
		 		  $('#legendDiv').append("<li><img src='/nsdi/img/eios/sub_img/openapi_exam_icon03.png' width='25' height='25'/>&nbsp;영업중</li>");
		 		  $('#legendDiv').append("<li><img src='/nsdi/img/eios/sub_img/openapi_exam_icon04.png' width='25' height='25'/>&nbsp;휴업중</li>");
		 	}
		 	if($('#estateBrkpgSpce').is(":checked")){
		 		  $('#legendDiv').append("<li class='legend-nm'>부동산중개업주제도</li>");
		 		  $('#legendDiv').append("<li><img src='/nsdi/img/eios/sub_img/openapi_exam_icon01.png' width='25' height='25'/>&nbsp;영업중</li>");
		 		  $('#legendDiv').append("<li><img src='/nsdi/img/eios/sub_img/openapi_exam_icon02.png' width='25' height='25'/>&nbsp;휴업중</li>");
		 	}
		 	if($('#possessionSpce').is(":checked")){
		 		  $('#legendDiv').append("<li class='legend-nm'>토지소유주제도</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(151,219,242);'>&nbsp;</span>&nbsp;개인</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(230,0,0); background-color: rgb(151,219,242);'>&nbsp;</span>&nbsp;개인(관외)</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(225,225,225);'>&nbsp;</span>&nbsp;국유지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(233,255,190);'>&nbsp;</span>&nbsp;외국인,외국공공기관</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(255,190,190);'>&nbsp;</span>&nbsp;일본인,창씨명등</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(255,234,190);'>&nbsp;</span>&nbsp;시도유지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(255,255,190);'>&nbsp;</span>&nbsp;군유지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(232,190,255);'>&nbsp;</span>&nbsp;법인</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(190,210,255);'>&nbsp;</span>&nbsp;종중</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(222,158,102);'>&nbsp;</span>&nbsp;종교단체</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(246,197,103);'>&nbsp;</span>&nbsp;기타단체</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(239,228,190);'>&nbsp;</span>&nbsp;기타</li>");
		 		}
		 	
		 	//////////////////2017년 추가//////////////////
		 	if($('#buildingAgeSpce').is(":checked")){
		 		  $('#legendDiv').append("<li class='legend-nm'>건축물연령정보</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0); background-color: rgb(241,255,164);'>&nbsp;</span>&nbsp;5년이하</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0); background-color: rgb(251,223,238);'>&nbsp;</span>&nbsp;5~10년</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0); background-color: rgb(250,205,221);'>&nbsp;</span>&nbsp;10~15년</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0); background-color: rgb(237,183,202);'>&nbsp;</span>&nbsp;15~20년</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0); background-color: rgb(236,148,183);'>&nbsp;</span>&nbsp;20~25년</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0); background-color: rgb(231,106,156);'>&nbsp;</span>&nbsp;25~30년</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0); background-color: rgb(239,31,112);'>&nbsp;</span>&nbsp;30년이상</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(0,0,0); background-color: rgb(225,225,225);'>&nbsp;</span>&nbsp;기타</li>");
		 		}
		 	if($('#useBuildingSpce').is(":checked")){
		 		  $('#legendDiv').append("<li class='legend-nm'>용도별건물정보</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(151,219,242);'>&nbsp;</span>&nbsp;주거용</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(255,190,190);'>&nbsp;</span>&nbsp;상업용</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(255,255,190);'>&nbsp;</span>&nbsp;농수산용</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(233,255,190);'>&nbsp;</span>&nbsp;공업용</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(232,190,255);'>&nbsp;</span>&nbsp;공공용</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(250,190,232);'>&nbsp;</span>&nbsp;문교사회용</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(214,133,137);'>&nbsp;</span>&nbsp;기타</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(110,110,110); background-color: rgb(225,225,225);'>&nbsp;</span>&nbsp;미분류</li>");
		 		}
		 	if($('#landcharacterSpce').is(":checked")){
		 		  $('#legendDiv').append("<li class='legend-nm'>토지특성정보</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(205,233,247);'>&nbsp;</span>&nbsp;기타</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(241,225,177);'>&nbsp;</span>&nbsp;전</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(193,254,192);'>&nbsp;</span>&nbsp;답</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(254,197,182);'>&nbsp;</span>&nbsp;과수원</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(236,170,130);'>&nbsp;</span>&nbsp;목장용지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(151,251,191);'>&nbsp;</span>&nbsp;임야</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(249,211,208);'>&nbsp;</span>&nbsp;광천지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(230,230,255);'>&nbsp;</span>&nbsp;염전</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(253,206,248);'>&nbsp;</span>&nbsp;대</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(173,209,224);'>&nbsp;</span>&nbsp;공장용지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(201,147,255);'>&nbsp;</span>&nbsp;학교용지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(225,225,225);'>&nbsp;</span>&nbsp;주차장</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(193,199,250);'>&nbsp;</span>&nbsp;주유소용지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(101,247,250);'>&nbsp;</span>&nbsp;창고용지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(190,194,220);'>&nbsp;</span>&nbsp;도로</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(207,253,254);'>&nbsp;</span>&nbsp;철도용지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(128,128,255);'>&nbsp;</span>&nbsp;하천</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(117,180,236);'>&nbsp;</span>&nbsp;제방</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(255,255,0);'>&nbsp;</span>&nbsp;구거</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(228,222,143);'>&nbsp;</span>&nbsp;유지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(141,227,117);'>&nbsp;</span>&nbsp;양어장</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(196,210,142);'>&nbsp;</span>&nbsp;수도용지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(162,167,210);'>&nbsp;</span>&nbsp;공원</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(168,173,99);'>&nbsp;</span>&nbsp;체육용지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(209,182,180);'>&nbsp;</span>&nbsp;유원지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(209,182,225);'>&nbsp;</span>&nbsp;종교용지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(209,225,180);'>&nbsp;</span>&nbsp;사적지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(151,182,180);'>&nbsp;</span>&nbsp;묘지</li>");
		 		  $('#legendDiv').append("<li><span class='legend-color' style='border:2px solid rgb(19,19,19); background-color: rgb(243,216,248);'>&nbsp;</span>&nbsp;잡종지</li>");
		 		}
		 	
			 if($("#legendDiv").children().length > 0){
				$("#legendBox").show();
			}else{
				$("#legendBox").hide();
			}
	}
	
	//레이어 목록 드롭 다운 클릭
	$('.layerMenu_btn').click(function(){
// 		$(this).next('.servieContent').toggle();
		
		var submenu = $(this).next(".servieContent");
		if( submenu.is(":visible") ){
			submenu.slideUp();
		}else{
			submenu.slideDown();
		}
	});
	
});
 


</script>

</head>
<body onload="init()">

<div class="wrap-sub-container">

	<div class="wrap-map-content">
		<div class="map-service" id='map-service'>
			<button type="button" class="btn-mapService">메뉴 열기/닫기</button>
			<div class="map-title">
				<p class="logo">국토교통부 국가공간정보포털</p>
				<!--<h1>국가공간정보포털</h1>-->
			</div><!-- //.map-title -->
			
			<h2>오픈 API 지도 사용예제</h2>
			<div class="map_wrap">
				<div class = 'layerMenu_btn'>
					<h3 >부동산 개방데이터 서비스 항목</h3>
				</div>
				<div class="servieContent back-gray cont">
					<ul class="map-serviceList clearFix">
						<li><input type="checkbox" disabled="true" checked="true" id="spce"/><label for="spce">행정구역정보</label></li>
						<li><input type="checkbox" class="checkClass" id="ctnlgsSpce" /><label for="ctnlgsSpce">연속지적도형정보</label></li>
						<li><input type="checkbox" class="checkClass" id="bldgisSpce" /><label for="bldgisSpce">GIS건물통합정보</label></li>
						<li><input type="checkbox" class="checkClass" id="lgstspSpce" /><label for="lgstspSpce">지적도근점정보</label></li>
						<li><input type="checkbox" class="checkClass" id="lgstgsSpce" /><label for="lgstgsSpce">지적삼각보조점정보</label></li>
						<li><input type="checkbox" class="checkClass" id="lgstrgSpce" /><label for="lgstrgSpce">지적삼각정보</label></li>
						<li><input type="checkbox" class="checkClass" id="indstrySpce" /><label for="indstrySpce">공업주제도</label></li>
						<li><input type="checkbox" class="checkClass" id="edcClturSpce" /><label for="edcClturSpce">교육문화주제도</label></li>
						<li><input type="checkbox" class="checkClass" id="trnsportSpce" /><label for="trnsportSpce">교통주제도</label></li>
						<li><input type="checkbox" class="checkClass" id="tritPlnSpce" /><label for="tritPlnSpce">국토계획주제도</label></li>
						<li><input type="checkbox" class="checkClass" id="tritGnrlzSpce" /><label for="tritGnrlzSpce">국토종합주제도</label></li>
						<li><input type="checkbox" class="checkClass" id="farmngSpce" /><label for="farmngSpce">농업주제도</label></li>
						<li><input type="checkbox" class="checkClass" id="ctySpce" /><label for="ctySpce">도시주제도</label></li>
						<li><input type="checkbox" class="checkClass" id="mtstSpce" /><label for="mtstSpce">산림주제도</label></li>
						<li><input type="checkbox" class="checkClass" id="marnSpce" /><label for="marnSpce">수산주제도</label></li>
						<li><input type="checkbox" class="checkClass" id="marnResrce" /><label for="marnResrce">수자원주제도</label></li>
						<li><input type="checkbox" class="checkClass" id="msfrtnSpce" /><label for="msfrtnSpce">재난주제도</label></li>
						<li><input type="checkbox" class="checkClass" id="irmcSpce" /><label for="irmcSpce">정보통신주제도</label></li>
						<li><input type="checkbox" class="checkClass" id="areaSpce" /><label for="areaSpce">지역주제도</label></li>
						<li><input type="checkbox" class="checkClass" id="envrnEnergySpce" /><label for="envrnEnergySpce">환경에너지주제도</label></li>
					</ul>
				</div><!-- //.servieContent -->
				<div class = 'layerMenu_btn'>
					<h3>국가공간 개방데이터 서비스 항목</h3>
				</div>
				<div class="servieContent back-gray cont left_menu_sub">
					<ul class="map-serviceList clearFix">
						<li><input type="checkbox" class="checkClass" id="gisBuildingSpce" /><label for="gisBuildingSpce">GIS건물일반정보</label></li>
						<li><input type="checkbox" class="checkClass" id="gisBuildingSpce2" /><label for="gisBuildingSpce2">GIS건물집합정보</label></li>
						<li><input type="checkbox" class="checkClass" id="indvdLandPriceSpce" /><label for="indvdLandPriceSpce">개별공시지가정보</label></li>
						<li><input type="checkbox" class="checkClass" id="referLandPriceSpce" /><label for="referLandPriceSpce">표준지공시지가정보</label></li>
						<li><input type="checkbox" class="checkClass" id="indvdHousingPriceSpce" /><label for="indvdHousingPriceSpce">개별주택가격정보</label></li>
						<li><input type="checkbox" class="checkClass" id="apartHousingPriceSpce" /><label for="apartHousingPriceSpce">공동주택가격정보</label></li>
						<li><input type="checkbox" class="checkClass" id="islandsSpce" /><label for="islandsSpce">도서정보</label></li>
						<li><input type="checkbox" class="checkClass" id="estateDevlopSpce" /><label for="estateDevlopSpce">부동산개발업정보</label></li>
						<li><input type="checkbox" class="checkClass" id="estateBrkpgSpce" /><label for="estateBrkpgSpce">부동산중개업정보</label></li>
						<li><input type="checkbox" class="checkClass" id="possessionSpce" /><label for="possessionSpce">토지소유정보</label></li>
					</ul>
				</div><!-- //.servieContent -->
				<div class = 'layerMenu_btn'>
					<h3>공간융합 개방데이터 서비스 항목</h3>
				</div>
				<div class="servieContent back-gray cont left_menu_sub">
					<ul class="map-serviceList clearFix">
						<li><input type="checkbox" class="checkClass" id="buildingAgeSpce" /><label for="buildingAgeSpce">건축물연령정보</label></li>
						<li><input type="checkbox" class="checkClass" id="useBuildingSpce" /><label for="useBuildingSpce">용도별건물정보</label></li>
						<li><input type="checkbox" class="checkClass" id="landcharacterSpce" /><label for="landcharacterSpce">토지특성정보</label></li>
					</ul>
				</div>
			</div>	<!-- //.servieContent -->
			<h3>검색</h3>
			<div class="servieContent">
				<table>
					<caption class="hidden">지도서비스 검색 조건</caption>
					<colgroup>
						<col />
						<col />
						<col />
						<col />
					</colgroup>

					<tbody>
						<tr>
							<th>시도</th>
							<td colspan="3">
								<select title="시도 선택" class="w100p" name='doArea' id='doArea'></select>
							</td>
						</tr>
						<tr>
							<th>시군구</th>
							<td colspan="3">
								<select title="시군구 선택" class="w100p" name='siArea' id='siArea'></select>
							</td>
						</tr>
						<tr>
							<th>읍면동</th>
							<td colspan="3">
								<select title="읍면동 선택" class="w100p" name='dongArea' id='dongArea'></select>
							</td>
						</tr>
						<tr class="mobile-hidden">
							<th>리</th>
							<td colspan="3">
								<select title="리 선택" class="w100p" name='reeArea' id='reeArea'></select>
							</td>
						</tr>
					</tbody>
				</table>	
				<div class="area-btn">
					<button type="button" class="btn-search w100p m-w100p" id="searchBtn" >이동</button>
				</div><!-- .area-btn -->
			</div><!-- //.servieContent -->
		</div><!-- //.map-service -->
		<div class="area-mapControl" style="position:absolute;z-index:999;">
				<button type="button" id="zoomIn">영역확대</button>
				<button type="button" id="zoomOut">영역축소</button>
				<button type="button" id="zoomFullExt">전체보기</button>
				<button type="button" id="deactivate" >이동</button>
				<button type="button" id="clear">서비스초기화</button>
			</div><!-- //.area-mapControl -->
		<div class="area-map"> 
				<!-- Map Setting -->
			<div id="map"  class="claro"></div>
			<!-- 지도 삽입 위치 --> 
			

			
			
			<div class="map-service-legend mobile-hidden" id="legendBox" style="display: none;z-index:999;">
				<button type="button" class="btn-mapService-legend" >범례 열기/닫기</button>
					<h2 id="legend-h2" style="text-align: center;">범례</h2>
					<div class="servieContent-legend back-gray" id="legendBox1" >
						<ul class="map-serviceList-legend clearFix" id='legendDiv'>
						</ul>
					</div><!-- //.servieContent -->
			</div><!-- //.map-service -->
			
			<div id="scaleline" style="position:absolute; left:120px; bottom:0px; z-index:999;font-weight:bold">
			
			</div>
			<div style="position:absolute; right:10px; bottom:30px; z-index:999; color:#EE0000;font-weight:bold">
			모든정보는 오픈API서비스 사용예제 목적이며 이에 대한 법적효력을 보증하지 않습니다.
			</div>
		</div><!-- //.area-map -->
	
	</div><!-- //.wrap-map-content -->
	
</div><!-- //.wrap-sub-container -->

</body>
</html>

