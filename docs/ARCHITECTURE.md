# Architecture

Z1 Helpdesk is a lightweight PHP 8.2+ MVC-style app with a simple router, controllers, services, and repositories.

- Entry point: public/index.php
- Config: config/*.php loaded by App\Support\Config
- Routing: app/Http/Router.php with middleware pipeline
- Views: app/View/Templates with Components for layout/nav
- Data access: PDO via App\Support\Database and repositories
- Security: CSRF, session hardening, rate limit, hashed tokens
- i18n: resources/lang with a simple loader and fallback

The code is organized by feature directories (Domain/*) and supporting layers (Http, Services, Repositories).
