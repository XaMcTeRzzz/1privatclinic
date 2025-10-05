# Создание ярлыка Git GUI на рабочем столе
$WshShell = New-Object -comObject WScript.Shell
$Shortcut = $WshShell.CreateShortcut("$([Environment]::GetFolderPath('Desktop'))\Git Push - PrivatClinic.lnk")
$Shortcut.TargetPath = "c:\Users\PC\Local Sites\newprivatclinic\app\public\wp-content\themes\privatclinic\open-git-gui.bat"
$Shortcut.WorkingDirectory = "c:\Users\PC\Local Sites\newprivatclinic\app\public\wp-content\themes\privatclinic"
$Shortcut.Description = "Открыть Git GUI для push темы privatclinic"
$Shortcut.Save()

Write-Host "✅ Ярлык создан на рабочем столе: 'Git Push - PrivatClinic'" -ForegroundColor Green
