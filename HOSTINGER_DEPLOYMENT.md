# Hostinger hPanel Deployment Guide

## 📋 Pre-Deployment Checklist

- [ ] Database exported from localhost
- [ ] Source code zipped
- [ ] `.env` file ready for editing

---

## 🚀 Step-by-Step Deployment on Hostinger

### 1. **Upload Files**

1. Login to **Hostinger hPanel**
2. Go to **File Manager**
3. Navigate to `public_html` directory
4. Upload your zipped file
5. Extract the zip file
6. Move all contents from the extracted folder directly into `public_html`
   - **Important**: `public_html` should contain `index.php`, `config/`, `assets/`, etc. directly
   - NOT `public_html/p/index.php`

### 2. **Create Database**

1. In hPanel, go to **Databases** → **MySQL Databases**
2. Click **Create New Database**
3. Note down:
   - Database Name (e.g., `u123456789_zic`)
   - Database User (e.g., `u123456789_user`)
   - Database Password (create a strong password)
   - Database Host (usually `localhost` or provided by Hostinger)
4. Click on **phpMyAdmin**
5. Select your database
6. Go to **Import** tab
7. Upload your `zic.sql` file
8. Click **Go** to import

### 3. **Update .env File**

1. In File Manager, navigate to `public_html`
2. Right-click on `.env` and select **Edit**
3. Update with your Hostinger database credentials:

```properties
# Database Configuration
DB_HOST=localhost
DB_NAME=u123456789_zic
DB_USER=u123456789_user
DB_PASS=your_strong_password_here

# Admin Configuration
ADMIN_EMAIL=admin@yourdomain.com
ADMIN_PASSWORD=YourSecurePassword123

# File Upload Settings
MAX_FILE_SIZE=2097152
ALLOWED_IMAGE_TYPES=jpg,jpeg,png,webp

# Application Settings
APP_URL=https://yourdomain.com
APP_NAME=ZEGNEN
TIMEZONE=Asia/Kolkata
```

4. Save the file

### 4. **Set Directory Permissions** ⚠️ CRITICAL

**These folders MUST be writable (755 or 777):**

In File Manager, right-click each folder → **Permissions** → Set to **755** or **777**:

```
✅ uploads/                    → 755 or 777
✅ uploads/products/            → 755 or 777
✅ uploads/products/parallax/   → 755 or 777
✅ uploads/gallery/             → 755 or 777
✅ uploads/banners/             → 755 or 777
✅ uploads/brands/              → 755 or 777
✅ uploads/popup/               → 755 or 777
✅ uploads/resumes/             → 755 or 777
✅ uploads/reviews/             → 755 or 777
✅ uploads/settings/            → 755 or 777
✅ config/logs/                 → 755 or 777
```

**How to Set Permissions in hPanel:**
1. Right-click folder → **Permissions**
2. Set to **755** (or **777** if 755 doesn't work)
3. Check **"Apply to subdirectories"** if available
4. Click **Change**

**Permission Explanation:**
- **755** = Owner can read/write/execute, others can read/execute (recommended)
- **777** = Everyone can read/write/execute (less secure but works if 755 fails)

### 5. **Fix Image Display Issue** 🔧

**Problem:** Images upload but don't show

**Solution A - Check File Permissions:**
```bash
All image files should have 644 permissions
All directories should have 755 permissions
```

**Solution B - Verify .htaccess (if needed):**

Create/edit `.htaccess` in `public_html`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Force HTTPS (optional)
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    
    # Allow access to uploads directory
    RewriteCond %{REQUEST_URI} !^/uploads/
    
    # Clean URLs
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^([^/]+)$ $1.php [L]
</IfModule>

# Allow image access
<FilesMatch "\.(jpg|jpeg|png|gif|webp|svg|ico)$">
    Allow from all
</FilesMatch>
```

**Solution C - Check Image Paths:**

The code already handles this automatically via `FileUploader::getImagePath()`, but verify:

1. Open any product page
2. Right-click on missing image → **Inspect**
3. Check the `src` attribute in the `<img>` tag
4. Should be: `/uploads/products/filename.png`
5. NOT: `/p/uploads/products/filename.png`

### 6. **Verify Upload Functionality**

1. Login to admin panel: `https://yourdomain.com/admin`
2. Try uploading a new product image
3. Check if it appears on the frontend
4. If not, check:
   - Directory permissions (Step 4)
   - PHP upload limits (see below)

### 7. **Check PHP Upload Limits**

In hPanel:
1. Go to **Advanced** → **PHP Configuration**
2. Set these values:
   ```
   upload_max_filesize = 10M
   post_max_size = 10M
   max_execution_time = 300
   memory_limit = 256M
   ```
3. Save changes

### 8. **Troubleshooting Images Not Showing**

**Check 1 - File Exists?**
```
Navigate to: File Manager → public_html/uploads/products/
Verify image files are present
```

**Check 2 - Direct URL Access**
```
Try accessing: https://yourdomain.com/uploads/products/yourimage.png
If "403 Forbidden" → Permission issue (go to Step 4)
If "404 Not Found" → File doesn't exist or wrong path
If image shows → Frontend code issue (contact support)
```

**Check 3 - Browser Console**
```
1. Open browser DevTools (F12)
2. Go to Console tab
3. Refresh page
4. Look for 404 or 403 errors on image URLs
5. Check the exact path being requested
```

**Check 4 - Database Paths**
```
In phpMyAdmin:
1. Go to your database
2. Open 'products' table
3. Check 'main_image' column
4. Path should be: uploads/products/filename.png
5. NOT: /p/uploads/products/filename.png
```

### 9. **Test Your Website**

✅ Homepage loads
✅ Products display with images
✅ Product details page works
✅ Admin login works
✅ Upload new image from admin
✅ New image appears on frontend
✅ Gallery images show
✅ Popup displays correctly

---

## 🔒 Security Recommendations

1. **Change .env permissions to 644** after editing
   ```
   Right-click .env → Permissions → Set to 644
   ```

2. **Protect admin directory** (optional - add to .htaccess in admin folder):
   ```apache
   # Limit login attempts by IP
   <Limit POST>
       Order Allow,Deny
       Allow from all
   </Limit>
   ```

3. **Regular backups:**
   - Use Hostinger's automatic backup feature
   - Download database weekly from phpMyAdmin
   - Download `uploads/` folder regularly

---

## 📞 Common Issues & Solutions

### Issue: "Images upload but show broken icon"
**Fix:** Set upload folders to 755/777 permissions

### Issue: "Database connection failed"
**Fix:** Double-check .env credentials match hPanel database

### Issue: "403 Forbidden on images"
**Fix:** Set image files to 644, folders to 755

### Issue: "File upload fails silently"
**Fix:** Check PHP upload limits in hPanel

### Issue: "Admin login doesn't work"
**Fix:** Verify database imported correctly, check admin table

---

## 📂 Final Directory Structure on Server

```
public_html/
├── .env                    ← Updated with server credentials
├── .htaccess              ← Created if needed
├── index.php
├── about.php
├── product-details.php
├── admin/
│   ├── index.php
│   ├── login.php
│   └── ...
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── components/
├── config/
│   ├── Database.php
│   ├── FileUploader.php
│   └── logs/              ← 755 permission
├── uploads/               ← 755 or 777 permission
│   ├── products/          ← 755 or 777 permission
│   ├── gallery/           ← 755 or 777 permission
│   ├── banners/           ← 755 or 777 permission
│   ├── brands/            ← 755 or 777 permission
│   ├── popup/             ← 755 or 777 permission
│   └── ...
└── ...
```

---

## ✅ Post-Deployment Checklist

- [ ] Website loads at https://yourdomain.com
- [ ] All images display correctly
- [ ] Admin panel accessible at https://yourdomain.com/admin
- [ ] Can upload new images from admin
- [ ] New images appear on frontend
- [ ] All upload directories have correct permissions (755/777)
- [ ] .env file has correct database credentials
- [ ] SSL certificate active (HTTPS working)
- [ ] PHP upload limits configured
- [ ] Database imported successfully

---

**Need Help?** Contact Hostinger support with:
- Error messages from browser console (F12)
- Screenshot of File Manager permissions
- phpMyAdmin screenshot of products table
