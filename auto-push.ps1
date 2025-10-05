# Скрипт автоматической синхронизации с GitHub

# Параметры
$REPO_PATH = "c:\Users\PC\Local Sites\newprivatclinic\app\public\wp-content\themes\privatclinic"
$GIT_REPO = "https://github.com/XaMcTeRzzz/1privatclinic.git"

# Переходим в папку репозитория
Set-Location -Path $REPO_PATH

# Инициализируем репозиторий если нужно
if (-not (Test-Path -Path ".git")) {
    git init
    git remote add origin $GIT_REPO
    git checkout -b main
}

# Добавляем все изменения
git add .

# Создаем коммит с текущей датой/временем
$COMMIT_MSG = "Automatic sync: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')"
git commit -m "$COMMIT_MSG"

# Пушим изменения
git push -u origin main --force

Write-Host "✅ Changes pushed to GitHub" -ForegroundColor Green
