start /d "C:\wamp64" wampmanager.exe
start /d "G:\phpstorm\PhpStorm 2018.1.3\bin" phpstorm64.exe
start /d "F:\BaiduYunDownload\Navicat for MySQL" navicat.exe
start /d "G:\redis" redis-server.exe
@echo off
G:
start  cmd /k call fan_bbs_watch-poll.bat
cd ricecode/fanbbs
start "C:\Program Files\cmder" Cmder.exe
start  cmd /k call php artisan queue:listen



