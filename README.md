University Result Management System
A lightweight PHP/MySQL app for uploading student result PDFs (admin) and letting students view/download their results.

Setup
Clone the repo: git clone https://github.com/your‑username/university-result-system.git && cd university-result-system

Install dependencies: composer install

Database: import schema.sql into MySQL and edit db_connect.php with your host, database name, user and password

Secure uploads: protect upload.php (e.g. via .htaccess or an admin‑login check)

Run: point your web server document root here and open upload.php (for admin) or login.php (for students)

Usage
Admin: go to upload.php, select and upload a result PDF → the system parses it and stores all student scores

Student: visit login.php, enter your StudentID → view/download your individual result at result.php and download full class results at class_results.php

Libraries
smalot/pdfparser | phpoffice/phpspreadsheet | dompdf/dompdf

Security
All inputs are sanitized; uploaded files are checked for size and type; session‑based access controls protect admin and student pages.