@echo off
"C:\Users\Zahidin\.config\herd\bin\php82\php.exe" -r "try { \$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', ''); \$pdo->exec('CREATE DATABASE IF NOT EXISTS kasir_bengkel'); echo 'Database created!'; } catch (Exception \$e) { echo \$e->getMessage(); }"
pause