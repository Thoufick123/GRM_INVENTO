# GRM Inventory Management System

[![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MariaDB](https://img.shields.io/badge/MariaDB-10.4%2B-003545?style=for-the-badge&logo=mariadb&logoColor=white)](https://mariadb.org/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com/)
[![Apache](https://img.shields.io/badge/Apache-2.4-D22128?style=for-the-badge&logo=apache&logoColor=white)](https://httpd.apache.org/)

An enterprise-grade, end-to-end apparel manufacturing, central warehousing, multi-channel distribution, and retail management platform.

---

## 🚀 Quickstart & Setup Guide

### 1. Requirements
- **Local Server**: XAMPP (Apache + MySQL/MariaDB) or Linux LAMP/LEMP stack.
- **PHP Version**: `8.1.0` or higher (with `pdo_mysql`, `curl`, `mbstring`, `openssl` extensions enabled).
- **Database**: MySQL `8.0+` or MariaDB `10.4+`.

### 2. Installation & Configuration
1. Clone or copy the repository into your web server's root directory:
   ```bash
   # In XAMPP on Windows:
   C:\xampp\htdocs\grm-inventory\
   ```

2. Copy [`.env.example`](./.env.example) to `.env` and configure the local environment:
   ```env
   APP_ENV=local
   APP_NAME="GRM Inventory Management"
   APP_URL=http://localhost/grm-inventory
   APP_TIMEZONE=Asia/Kolkata
   APP_DEBUG=true

   DB_HOST=127.0.0.1
   DB_PORT=3307
   DB_DATABASE=grm_inventory
   DB_USERNAME=root
   DB_PASSWORD=

   # Cloudinary (Optional, for CDN media uploads)
   CLOUDINARY_CLOUD_NAME=your_cloud_name
   CLOUDINARY_API_KEY=your_api_key
   CLOUDINARY_API_SECRET=your_api_secret

   # Automated Backup SMTP Settings
   BACKUP_EMAIL=your_email@gmail.com
   SMTP_HOST=smtp.gmail.com
   SMTP_PORT=587
   SMTP_USER=your_email@gmail.com
   SMTP_PASS=your_google_app_password
   SMTP_ENCRYPTION=tls
   ```

3. Database Initialization:
   - Create database `grm_inventory` in phpMyAdmin / MySQL CLI.
   - Import [`database/schema.sql`](./database/schema.sql) and [`database/seed.sql`](./database/seed.sql) into a new, empty database.
   - Seed any missing permission records:
     ```bash
     php database/seed_permissions.php
     ```
   - To sync missing columns/tables from the canonical schema:
     ```bash
     php database/migrations/sync_all_schema_columns.php
     ```
   - Other files in `database/migrations/` are incremental upgrades. Back up the database and run only migrations required for the version being deployed. Do not import `schema.sql` over a database containing production data; it drops and recreates tables.

4. Launch Application:
   - Navigate to: **[http://localhost/grm-inventory/](http://localhost/grm-inventory/)**

---

## Hostinger Deployment (GitHub)

This repository is a PHP application with its front controller under `public/` and a root `index.php`/`.htaccess` that route the website. Deploy the **whole repository** into the website's document root (normally `public_html`), keeping the project folders together. Do not deploy only the `public/` folder.

### 1. Check hosting requirements

- Use Hostinger Web/Cloud hosting with PHP 8.1+ and MySQL/MariaDB support.
- In hPanel, select a supported PHP version and enable `pdo_mysql`, `curl`, `mbstring`, `openssl`, and `fileinfo`.
- Connect the domain and enable its SSL certificate before setting `APP_URL`.
- The desktop `printer_service/` helper is for a local Windows receipt printer; it is not needed to serve the PHP website.

### 2. Connect Hostinger Git deployment

1. In hPanel, open the website's **Git** page and create/connect a repository.
2. Select the GitHub repository `Thoufick123/GRM_INVENTO`, branch `main`, and the directory that is the domain's document root (usually `public_html`). Authorize access if the GitHub repository is private.
3. Confirm deployment places root files (`index.php`, `.htaccess`, `app/`, `config/`, and `public/`) directly in that directory, not inside an extra nested project folder.
4. Enable Hostinger's **Auto Deployment** / push webhook for the same branch. Future pushes to `main` will deploy application files. A push does **not** create or migrate database tables or update `.env`.
5. After the first deployment, visit the domain over HTTPS and confirm the login page loads.

### 3. Create and configure the Hostinger database

1. In hPanel, open **Databases → Management** (the menu wording may vary by plan).
2. Create a MySQL database and database user, then grant the user privileges on that database.
3. Record the exact database name, username, hostname, and port shown by Hostinger. Hostinger may prefix the database and username with the account name; use the complete values. Use the displayed hostname—often `localhost` for a database on the same hosting account—and displayed port, usually `3306`.
4. Create `.env` in the repository root on the server by copying `.env.example`. Fill in:

   ```env
   APP_ENV=production
   APP_URL=https://your-real-domain.example
   APP_TIMEZONE=Asia/Kolkata
   APP_DEBUG=false

   DB_HOST=the-hostname-from-hPanel
   DB_PORT=the-port-from-hPanel
   DB_DATABASE=the-full-database-name-from-hPanel
   DB_USERNAME=the-full-database-user-from-hPanel
   DB_PASSWORD=the-database-user-password
   ```

   Keep `.env` out of GitHub. It is ignored by `.gitignore`; `.env.example` contains placeholders only. Do not paste database credentials into chat, source code, or a GitHub commit.

### 4. Initialize the database

1. Make sure the Hostinger database is **empty**. In hPanel's phpMyAdmin, select it and import `database/schema.sql`, then import `database/seed.sql`.
2. `schema.sql` drops and recreates tables, so never import it into a database with data you need to keep. `seed.sql` inserts initial/sample records; change the seeded administrator password immediately after the first login.
3. If Hostinger provides SSH/Terminal, run the permission seeder and schema sync from the repository root:

   ```sh
   php database/seed_permissions.php
   php database/migrations/sync_all_schema_columns.php
   ```

4. Apply any additional migration files required by the app version, once, after taking a database backup. PHP migrations can be run from SSH/Terminal; `.sql` migration files can be imported with phpMyAdmin. Do not rerun historical migrations blindly—some alter enum definitions or remove obsolete columns.

### 5. Finish deployment and verify

- Ensure `.env` is in the repository root (the same level as `config/`) and is not publicly downloadable. The root `.htaccess` blocks environment files and private source directories.
- Ensure `storage/logs/`, `storage/backups/`, and `public/uploads/` are writable by PHP using the least-permissive hosting permissions that work (typically `755` or `775`, not `777`).
- Sign in with the seeded administrator account only if you imported the seed data, change its password, and create unique user accounts for staff.
- Test login/logout, inventory reads, a test inward/sale, uploads, and invoice printing. Check Hostinger's PHP error log if the app displays a server error; keep `APP_DEBUG=false` in production.
- Configure Hostinger's scheduled task/cron only if you use automated backups or other scheduled jobs. Review `cron/backup.php` and set its mail credentials before enabling it.

### 6. Deploy updates

Push application changes to the connected branch (normally `main`) to trigger Hostinger Auto Deployment. Back up the production database before releases with migrations, run the required migration in Hostinger Terminal/phpMyAdmin, and then verify the site. Git deployment transfers files only; it does not transfer local database records or local `.env` values.

---

## 🔑 Default Login Credentials

| Role | Username / Email | Password | Access Scope |
| :--- | :--- | :--- | :--- |
| **System Administrator** | `admin` *(or `admin@grm.com`)* | `admin123` | Full access across all 13 modules, settings & user permissions |
| **Production Staff** | `abiprasath` *(or `abi1@gmail.com`)* | `123456` | Production planning, cutting, stitching, QC, and wastage sales |

---

## 📂 System Architecture & Modules

```text
GRM INVENTORY MANAGEMENT SYSTEM
├── 1. Authentication & RBAC (Role-based permission gating)
├── 2. Production & Manufacturing (Fabric rolls, cutting, stitching, QC, labels, outward)
├── 3. Central Warehouse Hub (GRN inward, rack/bin stock, allocations, picking, packing, dispatch)
├── 4. Retail Store & POS (Barcode touch POS billing, customer 360, thermal receipts)
├── 5. Customer Returns & Exchanges (In-store & warehouse RMA, size swaps, catalog exchanges)
├── 6. Digital Channels (WhatsApp social commerce & Website eCommerce order fulfillment)
├── 7. Financial & Petty Cash (Register shifts, daily float, expense vouchers, bank deposits)
├── 8. Fixed Assets & Machinery (Plant machines, maintenance logs, inter-unit transfers)
├── 9. Executive Reporting & Analytics (Production yields, multi-channel sales, P&L statements)
└── 10. System Tools (Automated encrypted database dumps with direct SMTP Gmail delivery)
```

---

## 📚 Complete Project Documentation

Detailed specifications and architectural guides are available in the [`requirements/`](file:///c:/xampp/htdocs/grm-inventory/requirements/) directory:

1. **[Project Requirements Document (PRD)](file:///c:/xampp/htdocs/grm-inventory/requirements/01_PROJECT_REQUIREMENT_DOCUMENT.md)**: Executive summary, user roles, business goals, and non-functional requirements.
2. **[Architecture & System Design](file:///c:/xampp/htdocs/grm-inventory/requirements/02_PROJECT_DESIGN.md)**: Architectural diagrams, folder structure, stock ledger engine, and lifecycle pipelines.
3. **[Technology Stack](file:///c:/xampp/htdocs/grm-inventory/requirements/03_TECH_STACK.md)**: Complete technology matrix, backend standards, database specs, and printing compatibility.
4. **[Database Schema & Models](file:///c:/xampp/htdocs/grm-inventory/requirements/04_DATABASE_SCHEMA_AND_MODELS.md)**: 82-table relational schema map, column constraints, entity relationships, and indexes.
5. **[Module Workflows & Specifications](file:///c:/xampp/htdocs/grm-inventory/requirements/05_MODULE_WORKFLOWS_AND_SPECIFICATIONS.md)**: Step-by-step sequence diagrams and functional rules for all 10 core domains.
6. **[UI Style Guide & Design System](file:///c:/xampp/htdocs/grm-inventory/requirements/06_UI_STYLE_GUIDE_AND_DESIGN_SYSTEM.md)**: Design tokens, typography hierarchy, status badge taxonomy, POS UI rules, and `@media print` stylesheets.
7. **[API & Routing Catalog](file:///c:/xampp/htdocs/grm-inventory/requirements/07_API_AND_ROUTING_CATALOG.md)**: Complete route reference across all HTTP verbs, controllers, actions, and permission middleware.
8. **[Returns & Exchanges Blueprint](file:///c:/xampp/htdocs/grm-inventory/requirements/member_2_whatsapp_and_website_blueprint.md)**: 2-member collaborative development specifications for RMA portals.

---

## 🛡️ Security & Integrity

- **Double-Entry Stock Ledger**: All inventory modifications write to `stock_balances` with atomic transactions and immutable audit logging to `stock_transactions`.
- **Zero Raw SQL Injection Risk**: 100% prepared PDO statements with bound parameters.
- **CSRF Token Verification**: Every mutating POST request requires a cryptographically validated session CSRF token.
- **XSS Escaping**: Native `e()` view helper sanitizes output across all templates.
- **Audit Logging**: Sensitive events (price modifications, permission grants, expense approvals) automatically log to `audit_logs`.
