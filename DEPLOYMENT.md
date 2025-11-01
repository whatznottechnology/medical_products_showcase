# ZEGNEN Medical Products Showcase - Deployment Guide

## Quick Start Deployment

### Method 1: Using the Installation Wizard (Recommended)

1. **Upload files to your server**
   - Upload all project files to your hosting server
   - Ensure the `install/` directory is accessible

2. **Run the installer**
   - Visit: `https://yourdomain.com/install/`
   - Follow the step-by-step wizard:
     - **Step 1:** Enter site name, email, and phone
     - **Step 2:** Configure database connection
     - **Step 3:** Create admin account
     - **Step 4:** Review settings and install
     - **Step 5:** Done! Access admin panel

3. **Access your website**
   - Frontend: `https://yourdomain.com`
   - Admin Panel: `https://yourdomain.com/admin`
   - Login with your admin credentials from Step 3

---

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher / MariaDB 10.3 or higher
- Apache with mod_rewrite enabled
- 50MB free disk space
- SSL Certificate (recommended for production)

---

## Server Configuration

### Apache Configuration

Ensure these modules are enabled:
```bash
mod_rewrite
mod_headers
mod_deflate
```

Enable with:
```bash
a2enmod rewrite
a2enmod headers
a2enmod deflate
systemctl restart apache2
```

### PHP Configuration

Update `/etc/php/[version]/apache2/php.ini`:
```ini
upload_max_filesize = 50M
post_max_size = 50M
max_execution_time = 300
memory_limit = 256M
display_errors = Off
error_reporting = E_ALL
log_errors = On
error_log = /var/log/php_errors.log
```

---

## Manual Installation

If you prefer manual setup:

1. Create database:
```sql
CREATE DATABASE zegnen CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Import SQL:
```bash
mysql -u root -p zegnen < zic.sql
```

3. Create `.env` file:
```env
APP_NAME=ZEGNEN
DB_HOST=localhost
DB_NAME=zegnen
DB_USER=root
DB_PASSWORD=your_password
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=admin_password
APP_ENV=production
DEBUG=false
```

4. Create admin marker:
```bash
touch config/.installed
```

---

## File Structure

```
/
├── admin/                 # Admin panel
│   └── .htaccess         # Admin routing
├── api/                   # API endpoints
├── assets/               # CSS, JS, images
├── components/           # Reusable components
├── config/               # Configuration files
├── includes/             # Helper functions
├── install/              # Installation wizard
├── uploads/              # User-uploaded files
├── .htaccess            # Main routing
├── .env                 # Environment variables
├── index.php            # Homepage
├── 404.php              # Error page
└── zic.sql             # Database schema
```

---

## URL Routing

### Frontend Routes
- `domain.com/` → Homepage
- `domain.com/our-products` → Products listing
- `domain.com/product/[id]` → Product details
- `domain.com/about` → About page
- `domain.com/contact-us` → Contact page
- `domain.com/career` → Career page
- `domain.com/why-zegnen` → Why section
- `domain.com/search-results` → Search results

### Admin Routes
- `domain.com/admin` → Admin dashboard
- `domain.com/admin/login` → Admin login
- `domain.com/admin/products` → Product management
- `domain.com/admin/settings` → Site settings
- `domain.com/admin/inquiries` → Inquiries
- `domain.com/admin/leads` → Leads

---

## Security Checklist

- [ ] Enable HTTPS (SSL/TLS)
- [ ] Set proper file permissions:
  ```bash
  chmod 755 .
  chmod 644 *.php
  chmod 755 admin/
  chmod 755 uploads/
  chmod 644 .htaccess
  chmod 644 .env
  ```
- [ ] Protect sensitive files (.env, config/):
  ```bash
  # Already configured in .htaccess
  ```
- [ ] Regular backups of:
  - Database
  - Uploaded files
  - Configuration
- [ ] Monitor error logs:
  ```bash
  tail -f /var/log/php_errors.log
  ```

---

## Database Tables

The installer automatically creates:
- `admin` - Admin users
- `settings` - Site settings (name, email, phone, social links, etc.)
- `products` - Product listing
- `product_images` - Product images
- `inquiries` - Contact form submissions
- `gallery` - Gallery images
- `brands` - Brand logos
- `reviews` - Customer testimonials
- `popup` - Promotional popups
- `careers` - Job applications
- `leads` - Lead information

---

## Backup & Restore

### Backup Database
```bash
mysqldump -u root -p zegnen > backup_$(date +%Y%m%d_%H%M%S).sql
```

### Backup Files
```bash
tar -czf zegnen_backup_$(date +%Y%m%d_%H%M%S).tar.gz .
```

### Restore Database
```bash
mysql -u root -p zegnen < backup_file.sql
```

---

## Maintenance

### Regular Tasks
- Monitor server logs
- Update content through admin panel
- Back up database weekly
- Review inquiries and leads
- Clear old uploaded files periodically

### Performance
- Enable caching (configured in .htaccess)
- Compress images before uploading
- Optimize database queries
- Monitor server resources

---

## Troubleshooting

### 404 Errors on all pages
- **Cause:** Apache mod_rewrite not enabled
- **Solution:** Enable mod_rewrite and restart Apache

### Database connection errors
- **Cause:** Wrong credentials or database not created
- **Solution:** Verify .env file and database credentials

### Admin panel not accessible
- **Cause:** Authentication cookie issues
- **Solution:** Clear browser cookies and log in again

### File upload errors
- **Cause:** Permissions on uploads folder
- **Solution:** `chmod 755 uploads/`

### Blank pages or 500 errors
- **Cause:** PHP errors
- **Solution:** Check `/var/log/php_errors.log`

---

## Support

For issues or questions:
- Email: support@zegnen.com
- Phone: +91 89020 56626
- Website: https://zegnen.com

---

## License

© 2025 ZEGNEN International Company. All rights reserved.

Developed by Whatznot Technology
