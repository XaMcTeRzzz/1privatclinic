# Скрипт автоматического мониторинга и push при изменениях файлов
Write-Host "👀 Запуск мониторинга изменений в папке темы..." -ForegroundColor Cyan
Write-Host "📁 Папка: c:\Users\PC\Local Sites\newprivatclinic\app\public\wp-content\themes\privatclinic" -ForegroundColor Yellow
Write-Host "⏱️  Интервал проверки: каждые 30 секунд" -ForegroundColor Yellow
Write-Host "🛑 Нажмите Ctrl+C для остановки" -ForegroundColor Red
Write-Host ""

$repoPath = "c:\Users\PC\Local Sites\newprivatclinic\app\public\wp-content\themes\privatclinic"
$lastCheck = Get-Date

while ($true) {
    Set-Location $repoPath
    
    # Проверяем есть ли изменения
    $status = git status --porcelain
    
    if ($status) {
        Write-Host "🔄 $(Get-Date -Format 'HH:mm:ss') - Обнаружены изменения, выполняем push..." -ForegroundColor Green
        
        # Запускаем auto-push
        & "$repoPath\auto-push.ps1"
        
        Write-Host "✅ Push выполнен!" -ForegroundColor Green
        Write-Host ""
    } else {
        Write-Host "⏳ $(Get-Date -Format 'HH:mm:ss') - Изменений нет, ожидаем..." -ForegroundColor Gray
    }
    
    # Ждем 30 секунд
    Start-Sleep -Seconds 30
}
