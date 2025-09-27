@echo off
setlocal enabledelayedexpansion

:: Pastikan dijalankan sebagai Administrator
NET SESSION >nul 2>&1
IF %ERRORLEVEL% NEQ 0 (
    echo ❌ Jalankan file ini sebagai Administrator!
    pause
    exit /b
)

set /p IP="Masukkan IP server XAMPP: "
set HOSTS_FILE=%SystemRoot%\System32\drivers\etc\hosts
set HOSTNAME=komunikasi_manager
set TEMP_FILE=%TEMP%\hosts_tmp.txt

:: Buat file sementara tanpa entry lama
(for /f "usebackq tokens=* delims=" %%A in ("%HOSTS_FILE%") do (
    set "line=%%A"
    echo !line! | findstr /C:"%HOSTNAME%" >nul
    if errorlevel 1 (
        echo !line!
    )
)) > "%TEMP_FILE%"

:: Tambahkan entry baru di akhir
echo %IP%    %HOSTNAME%>>"%TEMP_FILE%"

:: Replace file hosts lama
copy /Y "%TEMP_FILE%" "%HOSTS_FILE%" >nul

echo ✅ Entry berhasil diperbarui: %IP% %HOSTNAME%
pause
