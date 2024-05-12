@echo off
set PHP_FCGI_MAX_REQUESTS=0
set "php=%~dp0Yousician.srv\php-cgi.exe"
set "nginx=%~dp0Yousician.srv\nginx.exe"
set "hide=%~dp0Yousician.srv\RunHiddenConsole.exe"
set "scriptDir=%~dp0"

pushd "%scriptDir%"

echo Yousician Local Server
echo.
echo Address of this local Yousician instance:
echo http://127.0.0.1:8535
echo.
echo Run server_shutdown.bat to stop the server (may freeze)
echo.

:phprun
start call "%nginx%" -p "%scriptDir%Yousician.srv/" -c "%scriptDir%Yousician.srv/nginx.conf"
"%hide%" "%php%" -c "%scriptDir%Yousician.srv/php.ini" -b 127.0.0.1:9010
"%hide%" "%php%" -c "%scriptDir%Yousician.srv/php.ini" -b 127.0.0.1:9011
"%hide%" "%php%" -c "%scriptDir%Yousician.srv/php.ini" -b 127.0.0.1:9012
"%hide%" "%php%" -c "%scriptDir%Yousician.srv/php.ini" -b 127.0.0.1:9013
"%hide%" "%php%" -c "%scriptDir%Yousician.srv/php.ini" -b 127.0.0.1:9014
