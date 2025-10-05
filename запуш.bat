@echo off
chcp 65001 >nul
echo 🚀 Автоматический push на GitHub...
echo.

cd /d "c:\Users\PC\Local Sites\newprivatclinic\app\public\wp-content\themes\privatclinic"

echo 📁 Добавляем все изменения...
git add .

echo 💬 Создаем коммит...
git commit -m "Auto-commit: %date% %time%"

echo 🌐 Отправляем на GitHub...
git push origin main

if %errorlevel%==0 (
    echo.
    echo ✅ Успешно отправлено на GitHub!
    echo 🌐 https://github.com/XaMcTeRzzz/1privatclinic
) else (
    echo.
    echo ❌ Ошибка при отправке
)

echo.
echo Нажмите любую клавишу для закрытия...
pause >nul
