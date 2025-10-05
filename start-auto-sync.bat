@echo off
title GitHub Auto-Sync - privatclinic theme
echo 🚀 Запуск автоматической синхронизации с GitHub...
echo.
powershell -ExecutionPolicy Bypass -NoExit -File "%~dp0watch-and-push.ps1"
