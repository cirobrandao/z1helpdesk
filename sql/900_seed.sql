INSERT INTO roles (name) VALUES
('admin'),('agent'),('customer'),('guest');

INSERT INTO permissions (name) VALUES
('settings.manage'),('users.manage'),('orgs.manage'),('teams.manage'),('departments.manage'),('sectors.manage'),('faq.manage'),('tickets.manage_all'),
('tickets.view_assigned'),('tickets.reply'),('tickets.assign'),('tickets.close'),
('tickets.create'),('tickets.view_own'),('tickets.reply_own'),
('tickets.create_public'),('tickets.view_by_token');

INSERT INTO permission_role (permission_id, role_id)
SELECT p.id, r.id FROM permissions p
JOIN roles r ON r.name = 'admin'
WHERE p.name IN ('settings.manage','users.manage','orgs.manage','teams.manage','departments.manage','sectors.manage','faq.manage','tickets.manage_all');

INSERT INTO permission_role (permission_id, role_id)
SELECT p.id, r.id FROM permissions p
JOIN roles r ON r.name = 'agent'
WHERE p.name IN ('tickets.view_assigned','tickets.reply','tickets.assign','tickets.close');

INSERT INTO permission_role (permission_id, role_id)
SELECT p.id, r.id FROM permissions p
JOIN roles r ON r.name = 'customer'
WHERE p.name IN ('tickets.create','tickets.view_own','tickets.reply_own');

INSERT INTO permission_role (permission_id, role_id)
SELECT p.id, r.id FROM permissions p
JOIN roles r ON r.name = 'guest'
WHERE p.name IN ('tickets.create_public','tickets.view_by_token');

INSERT INTO users (name, username, email, password_hash, locale)
VALUES ('Admin', 'admin', 'admin@local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'en-US');

INSERT INTO role_user (user_id, role_id)
SELECT u.id, r.id FROM users u
JOIN roles r ON r.name = 'admin'
WHERE u.email = 'admin@local';

INSERT INTO faq_categories (name) VALUES ('General');

INSERT INTO settings (name, value) VALUES
('app_name', 'Z1 Helpdesk'),
('default_locale', 'en-US');
