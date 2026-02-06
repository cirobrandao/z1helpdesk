# Security Checklist

- Use PDO prepared statements everywhere
- Store passwords with Argon2id when available
- Store tokens hashed (SHA-256) only
- Enable HTTPS in production and set SESSION_SECURE=true
- Ensure session cookies are HttpOnly and SameSite
- Use CSRF tokens for all mutating requests
- Validate uploads: size, extension, and mime type
- Store uploads in storage/private_uploads
- Lock access to .env, /storage, /config, /sql, /vendor
- Review logs in storage/logs/app.log
