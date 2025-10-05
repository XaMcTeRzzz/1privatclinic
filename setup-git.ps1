# Скрипт настройки Git и SSH для автоматического push
Write-Host "🔧 Настройка Git и SSH для автоматического push..." -ForegroundColor Cyan

# Переходим в папку темы
$repoPath = "c:\Users\PC\Local Sites\newprivatclinic\app\public\wp-content\themes\privatclinic"
Set-Location $repoPath

# Настройка Git пользователя
Write-Host "📝 Настройка Git пользователя..." -ForegroundColor Yellow
git config --global user.name "XaMcTeRzzz"
git config --global user.email "your_email@example.com"  # Замените на вашу почту

# Создание SSH ключа если его нет
$sshPath = "$env:USERPROFILE\.ssh"
if (-not (Test-Path "$sshPath\id_ed25519")) {
    Write-Host "🔑 Создание SSH ключа..." -ForegroundColor Yellow
    if (-not (Test-Path $sshPath)) {
        New-Item -ItemType Directory -Path $sshPath -Force
    }
    ssh-keygen -t ed25519 -C "your_email@example.com" -f "$sshPath\id_ed25519" -N '""'
}

# Показываем публичный ключ
Write-Host "🔑 Ваш публичный SSH ключ:" -ForegroundColor Green
Get-Content "$sshPath\id_ed25519.pub"
Write-Host ""
Write-Host "📋 Скопируйте ключ выше и добавьте в GitHub:" -ForegroundColor Cyan
Write-Host "   GitHub → Settings → SSH and GPG keys → New SSH key" -ForegroundColor White

# Настройка remote на SSH
Write-Host "🌐 Настройка remote репозитория..." -ForegroundColor Yellow
git remote remove origin 2>$null
git remote add origin git@github.com:XaMcTeRzzz/1privatclinic.git

# Проверка SSH соединения
Write-Host "🔗 Проверка SSH соединения с GitHub..." -ForegroundColor Yellow
ssh -T git@github.com

Write-Host "✅ Настройка завершена! Теперь можно использовать auto-push.ps1" -ForegroundColor Green
