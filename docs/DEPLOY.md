# Deploy Guide

1) Install PHP 8.2+, Composer, Nginx, and MariaDB.
2) Point the web root to public/.
3) Copy .env.example to .env and set DB credentials.
4) Run composer install and composer run build-assets.
5) Import SQL files in order from /sql.
6) Use the example Nginx config in docs/nginx.conf.example.
7) Access /admin/login with the seeded admin account.
