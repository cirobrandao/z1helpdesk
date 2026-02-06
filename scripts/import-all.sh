#!/usr/bin/env sh

DB="${DB:-z1helpdesk}"
USER="${DB_USER:-root}"
HOST="${DB_HOST:-127.0.0.1}"
PORT="${DB_PORT:-3306}"

files="\
sql/001_init.sql \
sql/010_auth.sql \
sql/020_customers.sql \
sql/021_organizations.sql \
sql/030_tickets.sql \
sql/040_faq.sql \
sql/050_settings.sql \
sql/060_audit.sql \
sql/900_seed.sql"

for file in $files; do
  echo "Importing $file..."
  mysql -h "$HOST" -P "$PORT" -u "$USER" -p "$DB" < "$file" || exit 1
done

echo "All SQL files imported successfully."
