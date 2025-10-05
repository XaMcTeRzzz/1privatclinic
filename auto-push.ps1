# Скрипт автоматического push на GitHub
param(
    [string]$Message = "Auto-commit: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')"
)

# Переходим в папку темы
$repoPath = "c:\Users\PC\Local Sites\newprivatclinic\app\public\wp-content\themes\privatclinic"
Set-Location $repoPath

Write-Host "🚀 Автоматический push на GitHub..." -ForegroundColor Cyan

# Проверяем статус
$status = git status --porcelain
if ($status) {
    Write-Host "📁 Найдены изменения, выполняем push..." -ForegroundColor Yellow
    
    # Добавляем все изменения
    git add .
    
    # Создаем коммит
    git commit -m "$Message"
    
    # Пушим изменения
    git push origin main
    
    Write-Host "✅ Изменения успешно отправлены на GitHub!" -ForegroundColor Green
    Write-Host "🌐 Репозиторий: https://github.com/XaMcTeRzzz/1privatclinic" -ForegroundColor Cyan
} else {
    Write-Host "📝 Нет изменений для отправки" -ForegroundColor Yellow
}

# Показываем последние коммиты
Write-Host "`n📊 Последние коммиты:" -ForegroundColor Cyan
git log --oneline -5
