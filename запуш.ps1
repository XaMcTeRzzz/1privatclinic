# Команда "запуш" - автоматический push на GitHub
Write-Host "🚀 Команда ЗАПУШ - автоматический push на GitHub" -ForegroundColor Cyan
Write-Host "=================================================" -ForegroundColor Cyan

# Переходим в папку темы
Set-Location "c:\Users\PC\Local Sites\newprivatclinic\app\public\wp-content\themes\privatclinic"

# Проверяем статус
Write-Host "🔍 Проверяем изменения..." -ForegroundColor Yellow
$status = git status --porcelain

if ($status) {
    Write-Host "📁 Найдено изменений: $($status.Count)" -ForegroundColor Green
    
    # Показываем что изменилось
    Write-Host "`n📝 Измененные файлы:" -ForegroundColor Cyan
    git status --short
    
    Write-Host "`n➕ Добавляем все файлы..." -ForegroundColor Yellow
    git add .
    
    Write-Host "💬 Создаем коммит..." -ForegroundColor Yellow
    $commitMessage = "Auto-commit: $(Get-Date -Format 'dd.MM.yyyy HH:mm:ss')"
    git commit -m $commitMessage
    
    Write-Host "🌐 Отправляем на GitHub..." -ForegroundColor Yellow
    git push origin main
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "`n✅ УСПЕШНО ОТПРАВЛЕНО НА GITHUB!" -ForegroundColor Green
        Write-Host "🌐 Репозиторий: https://github.com/XaMcTeRzzz/1privatclinic" -ForegroundColor Cyan
        
        # Показываем последние коммиты
        Write-Host "`n📊 Последние коммиты:" -ForegroundColor Cyan
        git log --oneline -3
    } else {
        Write-Host "`n❌ ОШИБКА ПРИ ОТПРАВКЕ!" -ForegroundColor Red
        Write-Host "Проверьте подключение к интернету и права доступа" -ForegroundColor Yellow
    }
} else {
    Write-Host "📝 Нет изменений для отправки" -ForegroundColor Yellow
    Write-Host "Все файлы уже синхронизированы с GitHub" -ForegroundColor Gray
}

Write-Host "`n🎯 Команда ЗАПУШ завершена!" -ForegroundColor Green
