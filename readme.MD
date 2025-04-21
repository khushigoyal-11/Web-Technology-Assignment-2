# University Result Management System

## Setup

1. Clone this repo.
2. Run `composer install`.
3. Import `schema.sql` into your MySQL server.
4. Update `db_connect.php` with your DB credentials.
5. Ensure `upload.php` is protected (e.g. via `.htaccess` or admin login).
6. Point your webserver document root here and browse `login.php`.

## Usage

- **Admin:** Go to `upload.php` to upload and parse result PDFs.
- **Students:**
  1. Visit `login.php`, enter your StudentID.
  2. View and download your results at `result.php`.
  3. Download class results at `class_results.php`.

## Libraries

- PDF parsing: `smalot/pdfparser`
- Excel export: `phpoffice/phpspreadsheet`
- PDF generation: `dompdf/dompdf`

## Security

- All inputs are sanitized.
- File‑upload size/type checks in place.
- Session‑based access control.

---
