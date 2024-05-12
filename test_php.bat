@echo off
set PHP_FCGI_MAX_REQUESTS=0
set "php=%~dp0Yousician.srv\php-cgi.exe"
set "scriptDir=%~dp0"

"%php%" -c "%scriptDir%Yousician.srv/php.ini" -b 127.0.0.1:9010

pause
