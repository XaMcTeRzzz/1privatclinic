# Создание ярлыка "ЗАПУШ" на рабочем столе
$WshShell = New-Object -comObject WScript.Shell
$Shortcut = $WshShell.CreateShortcut("$([Environment]::GetFolderPath('Desktop'))\🚀 ЗАПУШ.lnk")
$Shortcut.TargetPath = "powershell.exe"
$Shortcut.Arguments = "-ExecutionPolicy Bypass -File `"c:\Users\PC\Local Sites\newprivatclinic\app\public\wp-content\themes\privatclinic\запуш.ps1`""
$Shortcut.WorkingDirectory = "c:\Users\PC\Local Sites\newprivatclinic\app\public\wp-content\themes\privatclinic"
$Shortcut.Description = "Команда ЗАПУШ - автоматический push на GitHub"
$Shortcut.IconLocation = "shell32.dll,137"
$Shortcut.Save()

Write-Host "✅ Ярлык 'ЗАПУШ' создан на рабочем столе!" -ForegroundColor Green
Write-Host "🎯 Теперь просто дважды кликните ярлык для push на GitHub" -ForegroundColor Cyan
