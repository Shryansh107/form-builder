# self-contained-setup.ps1
# This script sets up a local, isolated environment for PHP and Composer inside this folder.
# It does NOT modify your system-wide environment variables or require administrator privileges.

$localDir = Join-Path $PSScriptRoot ".local"
$phpDir = Join-Path $localDir "php"
$zipPath = Join-Path $localDir "php.zip"
$composerPath = Join-Path $localDir "composer.phar"

if (-not (Test-Path $localDir)) {
    New-Item -ItemType Directory -Path $localDir | Out-Null
}

# 1. Download and Extract PHP
if (-not (Test-Path $phpDir)) {
    Write-Host "[1/3] Downloading portable PHP 8.2..." -ForegroundColor Cyan
    $phpUrl = "https://windows.php.net/downloads/releases/php-8.2.20-Win32-vs16-x64.zip"
    try {
        Invoke-WebRequest -Uri $phpUrl -OutFile $zipPath
    } catch {
        Write-Host "Error downloading PHP: $_" -ForegroundColor Red
        Exit
    }
    
    Write-Host "Extracting PHP..." -ForegroundColor Cyan
    Expand-Archive -Path $zipPath -DestinationPath $phpDir -Force
    Remove-Item $zipPath
    
    # Configure php.ini
    Write-Host "Configuring php.ini..." -ForegroundColor Cyan
    $iniDev = Join-Path $phpDir "php.ini-development"
    $ini = Join-Path $phpDir "php.ini"
    Copy-Item $iniDev $ini
    
    # Enable necessary extensions for Laravel
    $iniContent = Get-Content $ini
    $iniContent = $iniContent -replace ';extension_dir = "ext"', 'extension_dir = "ext"'
    $iniContent = $iniContent -replace ';extension=curl', 'extension=curl'
    $iniContent = $iniContent -replace ';extension=fileinfo', 'extension=fileinfo'
    $iniContent = $iniContent -replace ';extension=mbstring', 'extension=mbstring'
    $iniContent = $iniContent -replace ';extension=openssl', 'extension=openssl'
    $iniContent = $iniContent -replace ';extension=pdo_mysql', 'extension=pdo_mysql'
    $iniContent = $iniContent -replace ';extension=zip', 'extension=zip'
    
    Set-Content $ini $iniContent
} else {
    Write-Host "[1/3] Local PHP already set up." -ForegroundColor Green
}

# 2. Download Composer
if (-not (Test-Path $composerPath)) {
    Write-Host "[2/3] Downloading Composer..." -ForegroundColor Cyan
    $composerUrl = "https://getcomposer.org/composer.phar"
    try {
        Invoke-WebRequest -Uri $composerUrl -OutFile $composerPath
    } catch {
        Write-Host "Error downloading Composer: $_" -ForegroundColor Red
        Exit
    }
} else {
    Write-Host "[2/3] Local Composer already set up." -ForegroundColor Green
}

# 3. Install dependencies
Write-Host "[3/3] Installing composer dependencies..." -ForegroundColor Cyan
& "$phpDir\php.exe" "$composerPath" install

# 4. Copy .env if not exists
if (-not (Test-Path ".env")) {
    Write-Host "Copying .env.example to .env..." -ForegroundColor Cyan
    Copy-Item ".env.example" ".env"
    & "$phpDir\php.exe" artisan key:generate
}

# 5. Build front-end dependencies
Write-Host "Installing npm packages..." -ForegroundColor Cyan
npm install

Write-Host "`n=== SETUP SUCCESSFUL ===" -ForegroundColor Green
Write-Host "To run the application:"
Write-Host "1. Start Laravel server:      .local\php\php.exe artisan serve"
Write-Host "2. Start WebRTC/Socket server: node server.js"
Write-Host "========================" -ForegroundColor Green
