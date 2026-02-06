# Z1 Helpdesk

Minimal helpdesk MVP built with PHP 8.2+, Nginx, MariaDB, and Bootstrap 5.3.

## Requirements

- PHP 8.2+ with PDO MySQL extension
- Composer
- Nginx
- MariaDB / MySQL

## Setup

1) Install dependencies:

```bash
composer install
composer run build-assets
```

2) Environment:

```bash
copy .env.example .env
```

Edit .env with your database credentials.

3) Database:

Run the SQL files in order:

```bash
mysql -u root -p z1helpdesk < sql/001_init.sql
mysql -u root -p z1helpdesk < sql/010_auth.sql
mysql -u root -p z1helpdesk < sql/020_customers.sql
mysql -u root -p z1helpdesk < sql/021_organizations.sql
mysql -u root -p z1helpdesk < sql/030_tickets.sql
mysql -u root -p z1helpdesk < sql/040_faq.sql
mysql -u root -p z1helpdesk < sql/050_settings.sql
mysql -u root -p z1helpdesk < sql/060_audit.sql
mysql -u root -p z1helpdesk < sql/900_seed.sql
```

4) Nginx:

Use the example in docs/nginx.conf.example and point root to public/.

## Access

- Admin login: /admin/login
- Seed user: admin@local
- Seed password: password

## Notes

- Session settings are in config/security.php
- Logs: storage/logs/app.log
- Uploads: storage/private_uploads

## Scripts

- composer run build-assets (copy Bootstrap assets)
- composer run post-install-cmd (create storage directories)
