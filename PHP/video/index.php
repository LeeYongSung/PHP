<?php
require_once('D:/thejoeunAcademy/PHP/git/PHP/PHP/PHP/video/js/vendor/autoload.php'); //getID3 라이브러리를 불러옵니다. 경로는 실제 getID3가 설치된 경로로 대체해야 합니다.

$getID3 = new getID3;  //getID3 객체를 생성합니다.

$filename = 'D:/thejoeunAcademy/PHP/git/PHP/PHP/PHP/video/video/music.mp4';  //분석하려는 동영상 파일의 경로를 지정합니다. 실제 동영상 파일 경로로 대체해야 합니다.

$file = $getID3->analyze($filename);  //동영상 파일을 분석합니다.

$playtime_seconds = $file['playtime_seconds'];  //분석 결과에서 재생 시간(초 단위)을 가져옵니다.

// echo $playtime_seconds;  //재생 시간을 출력합니다.

?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>강의</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<video id="myVideo" controls>
        <source src="./video/music.mp4" type="video/mp4" />
    </video>
    <a class="check_btn btn btn-lg btn-outline-success none py-3 mt-2 rounded-0">
        시험페이지로이동
    </a>
    <p>총 재생 시간 : <?= $playtime_seconds ?></p>
    <p id="currentTime">재생된 시간 : 0</p>
    <p id="currentPersent">재생된 퍼센트 : 0%</p>


    <script>
        // 제이쿼리로 구성할 때
        $(document).ready(function() {
            var video = $('#myVideo')[0];
            var currentTimeDisplay = $('#currentTime');
            var currentPersentDisplay = $('#currentPersent');
            var playtime = <?= $playtime_seconds ?>;
            let persent = 0;

            $(video).on('timeupdate', function() {
                currentTimeDisplay.text("재생된 시간 : " + Math.floor(video.currentTime));
                currentPersentDisplay.text("재생된 퍼센트 : " + (video.currentTime / playtime) * 100 + "%");
                persent = (video.currentTime / playtime) * 100;
                console.log(Math.floor(persent))
                
                if(Math.floor(persent) == 80) {
                    // alert('시험페이지 입장 가능')
                    $('.check_btn').removeClass('none');
                    $('.check_btn').addClass('active');

                    
                }
            });

            console.log(playtime);
        });

        // 자바스크립트로 구성할 때
        // var video = document.getElementById('myVideo');                          // 비디오 태그의 아이디값으로 해당 비디오 태그 가져오기
        // var currentTimeDisplay = document.getElementById('currentTime');         // 현재 재생시간 출력을 위한 변수
        // var currentPersentDisplay = document.getElementById('currentPersent);    // 퍼센트 계산 출력을 위한 변수
        // let playtime =  <?= $playtime_seconds ?>;                                // 자바스크립트에서 처리를 위한 php 변수값 담기

        // // 실시간 시간 업데이트를 위한 함수
        // video.addEventListener('timeupdate', function() {
        //     currentTimeDisplay.textContent = video.currentTime;
        //     currentPersentDisplay.textContent = (video.currentTime / playtime) * 100'%'
        //     console.log( (video.currentTime / play.time) * 100 + "%");
        // });


        // console.log(playtime);

    </script>
</body>
</html>