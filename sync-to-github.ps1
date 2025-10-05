# PowerShell скрипт для автоматической синхронизации с GitHub

# Параметры
$REPO_DIR = "c:\Users\PC\Local Sites\newprivatclinic\app\public\wp-content\themes\privatclinic"
$GIT_REPO = "https://github.com/XaMcTeRzzz/1privatclinic.git"
$COMMIT_MESSAGE = "Automatic sync: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')"

# Переходим в папку репозитория
Set-Location -Path $REPO_DIR

# Проверяем статус git
$status = git status --porcelain

if ($status) {
    # Добавляем все изменения
    git add .
    
    # Создаем коммит
    git commit -m "$COMMIT_MESSAGE"
    
    # Пушим изменения
    git push origin master
    
    Write-Host "✅ Changes pushed to GitHub" -ForegroundColor Green
} else {
    Write-Host "🔄 No changes to push" -ForegroundColor Yellow
}
