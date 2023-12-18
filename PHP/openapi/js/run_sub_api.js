$(function(){

	// lnb menu action
	$('.btn-openDepth').on('click',function(){
		$('.lnb>ul').slideToggle('slow');
		$(this).toggleClass('on');
	});

	// pagination 선택 컬러
	$('.pagination ul button').on('click',function(){
		$(this).parent().addClass('current').siblings().removeClass('current');
	});

	// 뒤로가기 버튼
	$('.go-back').on('click',function(){
		history.back();
	});

	// 지도서비스(범례 메뉴 숨김)
	$('.btn-mapService-legend').on('click',function(){
		$('#legendBox1').slideToggle('slow');
		$(this).toggleClass('on');
		
		if($(this).hasClass('on')){
			$('.map-service-legend').css("width","85px");
			$("#legendBox1").hide();
			$("#legend-h2").css("text-align","");
			$("#legend-h2").css("padding-left","15px");
		}
		else{
			$('.map-service-legend').css("width","300px");
			$("#legend-h2").css("text-align","center");
			$("#legend-h2").css("padding-left","0px");
		}
	});
	
	// 지도서비스(사용예제 메뉴 숨김)
	$('.btn-mapService').on('click',function(){
		$(this).toggleClass('on');

		if($(this).hasClass('on')){
			$('.map-service').animate({left:-300});
		}
		else{
			$('.map-service').animate({left:0});
		}
	});

	
	
	// 지도 버튼
	$('.area-mapControl button').on('click',function(){
		$(this).addClass('current').siblings().removeClass('current');
	});

	// 달력
	$('.datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
		prevText: '이전 달',
		nextText: '다음 달',
		monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		dayNames: ['일','월','화','수','목','금','토'],
		dayNamesShort: ['일','월','화','수','목','금','토'],
		dayNamesMin: ['일','월','화','수','목','금','토'],
		showMonthAfterYear: true,
		yearSuffix: '년'
	});
	
	
	/*시작일 날짜 유효성 체크*/
	 $("#startDate").change(function(){

        if(!dateCompare($("#startDate").val(),$("#endDate").val())){
			  alert("시작일이 종료일보다 이후입니다.");	
			  $("#startDate").val($("#endDate").val());
			  return;
		  }
		 
    }); 

	 /*시작일 날짜 유효성 체크*/
	 $("#endDate").change(function(){

        if(!dateCompare($("#startDate").val(),$("#endDate").val())){
			  alert("종료일이 시작일보다 이전입니다.");	
			  $("#endDate").val($("#startDate").val());
			  return;
		  }
		 
    }); 

	// 팝업창 호출
	$('.wrap-sub-container .sub-api-popup').hide();
	$('.wrap-sub-container .call-popup').on('click',function(){
		$('.wrap-sub-container .sub-api-popup').show();
	});
	$('.btn-pop-close').on('click',function(){
		$('.wrap-sub-container .sub-api-popup').hide();
	});

	//모바일버전
	$(window).on('load',function(){
		winWidth=$(window).width();
		if(winWidth<=640){
			//모바일 테이블 td 높이
			longTd=$('.long-height').height();
			$('.long-height').prev('th').height(longTd);
			
			//팝업창 호출 위치
			$('.wrap-sub-container .call-popup').on('click',function(){
				popupTop=$(this).offset().top;
				$('.wrap-sub-container .sub-api-popup').css({top:popupTop-150});
			});
		}
	});
		
})
