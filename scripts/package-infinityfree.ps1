# Package Laravel backend for InfinityFree (no SSH / no artisan on server).
$ErrorActionPreference = "Stop"
$root = Resolve-Path (Join-Path $PSScriptRoot "..")
$backend = Join-Path $root "backend"
$outDir = Join-Path $root "deploy\infinityfree"
$zipPath = Join-Path $outDir "backend-infinityfree.zip"

Write-Host "Backend: $backend"
Set-Location $backend

Write-Host "composer install --no-dev --no-scripts ..."
composer install --no-dev --prefer-dist --no-interaction --no-scripts
if ($LASTEXITCODE -ne 0) { throw "composer install failed" }

@(
  "storage\app\public",
  "storage\framework\cache\data",
  "storage\framework\sessions",
  "storage\framework\views",
  "storage\logs",
  "bootstrap\cache"
) | ForEach-Object {
  New-Item -ItemType Directory -Force -Path $_ | Out-Null
}

New-Item -ItemType Directory -Force -Path $outDir | Out-Null
if (Test-Path $zipPath) { Remove-Item $zipPath -Force }

$staging = Join-Path $outDir "staging"
if (Test-Path $staging) { Remove-Item $staging -Recurse -Force }
New-Item -ItemType Directory -Force -Path $staging | Out-Null

Write-Host "Copying files..."
robocopy $backend $staging /E /NFL /NDL /NJH /NJS /nc /ns /np `
  /XD node_modules .git tests `
  /XF .env .env.backup phpunit.xml *.log | Out-Null

Copy-Item (Join-Path $backend "htaccess-infinityfree") (Join-Path $staging ".htaccess") -Force

Write-Host "Zipping with tar..."
tar -a -cf $zipPath -C $staging .
if ($LASTEXITCODE -ne 0) { throw "tar zip failed" }
Remove-Item $staging -Recurse -Force

$sizeMb = [math]::Round((Get-Item $zipPath).Length / 1MB, 1)
Write-Host "Done: $zipPath ($sizeMb MB)"
Write-Host "Upload contents into InfinityFree htdocs/, then add .env and import SQL."
