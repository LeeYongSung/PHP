# Windows 환경
### getID3 라이브러리를 설치하기 위해서는 Composer라는 PHP의 의존성 관리 도구를 사용

### Composer가 없는 경우, 먼저 Composer를 설치해야 함

## Composer 설치:
### Composer의 공식 홈페이지(https://getcomposer.org/download/)에서 Windows용 설치 파일을 다운로드
### 다운로드 받은 설치 파일을 실행
### 설치가 완료되면, 명령 프롬프트(cmd)에서 composer -V 명령어를 실행하여 정상적으로 설치되었는지 확인

## getID3 설치:
### 설치하려는 프로젝트의 디렉토리로 명령 프롬프트를 이동 후, 프로젝트 디렉토리가 C:\myproject인 경우, cd C:\myproject 명령어를 실행
### 프로젝트 디렉토리에서 composer require james-heinrich/getid3 명령어를 실행하여 getID3 라이브러리를 설치
### 설치가 완료되면, 해당 디렉토리에 vendor 폴더가 생성되고 그 안에 getID3 라이브러리가 설치됨
### 설치가 완료된 후에는 PHP 코드에서 require_once('vendor/autoload.php');를 통해 getID3 라이브러리를 불러와서 사용할 수 있으며, 
### require_once에 지정한 경로는 getID3 라이브러리가 설치된 경로를 정확하게 지정해야 함.



# 그누보드 (리눅스 서버 환경)
### 리눅스 환경에서 getID3 라이브러리를 설치하기 위해서도 Composer를 사용, 먼저 Composer가 설치되어 있는지 확인

## Composer 설치:
### 터미널에서 composer -V 명령어를 입력하여 Composer가 이미 설치되어 있는지 확인
### Composer가 없다면, 아래의 명령어를 통해 설치할 수 있음
### bash
### curl -sS https://getcomposer.org/installer | php
### mv composer.phar /usr/local/bin/composer

## getID3 설치:
### 설치하려는 프로젝트의 디렉토리로 터미널을 이동
### 예를 들어, 프로젝트 디렉토리가 /var/www/myproject인 경우, 
### cd /var/www/myproject 명령어를 실행
### 프로젝트 디렉토리에서 composer require james-heinrich/getid3 명령어를 실행하여 getID3 라이브러리를 설치
### 설치가 완료되면, 해당 디렉토리에 vendor 폴더가 생성되고 그 안에 getID3 라이브러리가 설치
### 설치가 완료된 후에는 PHP 코드에서 require_once('vendor/autoload.php');를 통해 getID3 라이브러리를 불러와서 사용할 수 있음. 이때, 
### require_once에 지정한 경로는 getID3 라이브러리가 설치된 경로를 정확하게 지정해야 함.


### 에러 발생 시 명령 프롬프트로 getID3 기능을 담을 폴더 경로에 들어가
# git config --global --add safe.directory D:/thejoeunAcademy/PHP/git/PHP/PHP/PHP/video/js/vendor/james-heinrich/getid3
# 그 후 다시 시도
