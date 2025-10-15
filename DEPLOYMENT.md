# Panduan Deployment e-Pajak KTT Indonesia

## 📋 Checklist Sebelum Deploy

### 1. Keamanan Database
- [ ] Ubah password database dari default
- [ ] Gunakan user database dengan privilege terbatas
- [ ] Backup database sebelum deploy
- [ ] Setup environment variables untuk kredensial DB

### 2. Konfigurasi Server
- [ ] Enable HTTPS/SSL certificate
- [ ] Set PHP version minimal 7.4 atau 8.x
- [ ] Enable mod_rewrite Apache
- [ ] Enable mod_headers Apache
- [ ] Set proper file permissions (755 untuk folder, 644 untuk file)

### 3. File Configuration
- [ ] Copy `.env.example` ke `.env` dan isi dengan nilai production
- [ ] Update `config/database.php` dengan kredensial production
- [ ] Set `expose_php = Off` di php.ini
- [ ] Pastikan `.htaccess` aktif
- [ ] Upload `.user.ini` ke root directory

### 4. Security Checklist
- [ ] Semua password sudah diganti dari default
- [ ] Display errors dimatikan (`display_errors = Off`)
- [ ] File sensitif tidak bisa diakses langsung (test: `/config/database.php`)
- [ ] HTTPS aktif dan redirect dari HTTP ke HTTPS
- [ ] Session cookie secure enabled
- [ ] Content Security Policy configured

### 5. Testing Production
- [ ] Test login/logout
- [ ] Test pembayaran
- [ ] Test upload file
- [ ] Test report generation
- [ ] Test session timeout
- [ ] Test di multiple browsers
- [ ] Test responsiveness mobile

---

## 🚀 Langkah Deploy

### Step 1: Persiapan File
```bash
# Compress project (exclude development files)
zip -r epajak-production.zip . -x "*.git*" "*.zip" "*.md" "node_modules/*" "vendor/*"
```

### Step 2: Upload ke Server
- Upload via FTP/SFTP atau cPanel File Manager
- Extract di folder public_html atau domain root

### Step 3: Setup Database
```sql
-- Import database
mysql -u username -p database_name < database.sql

-- Create production user with limited privileges
CREATE USER 'epajak_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT SELECT, INSERT, UPDATE, DELETE ON epajak_ktt.* TO 'epajak_user'@'localhost';
FLUSH PRIVILEGES;
```

### Step 4: Configure Environment
```bash
# Copy and edit environment file
cp .env.example .env
nano .env  # Edit dengan kredensial production
```

### Step 5: Set Permissions
```bash
# Set folder permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;

# Make uploads writable
chmod 775 uploads/
```

### Step 6: Enable HTTPS
```apache
# Uncomment di .htaccess:
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 🔒 Security Best Practices

### 1. Hide PHP Version
- ✅ Set `expose_php = Off` di php.ini
- ✅ Remove `X-Powered-By` header via .htaccess
- ✅ Custom error pages (404, 403, 500)

### 2. Protect Config Files
- ✅ Block direct access via .htaccess
- ✅ Store credentials in environment variables
- ✅ Never commit `.env` file

### 3. Database Security
- ✅ Use prepared statements (already implemented)
- ✅ Limit database user privileges
- ✅ Regular backups
- ✅ Strong passwords

### 4. Session Security
- ✅ HTTPOnly cookies
- ✅ Secure flag for HTTPS
- ✅ Session timeout (5 minutes)
- ✅ Regenerate session ID on login

---

## 🛠️ Troubleshooting

### Problem: .htaccess tidak berfungsi
**Solution:**
```apache
# Pastikan AllowOverride enabled di Apache config
<Directory /var/www/html>
    AllowOverride All
</Directory>
```

### Problem: 500 Internal Server Error
**Solution:**
- Check Apache error log: `/var/log/apache2/error.log`
- Check PHP error log di `logs/php_errors.log`
- Verify file permissions
- Check .htaccess syntax

### Problem: Database connection error
**Solution:**
- Verify database credentials di `.env`
- Check if database exists
- Test connection with mysql CLI
- Check MySQL user privileges

---

## 📊 Monitoring

### Check Application Health
```bash
# Check error logs
tail -f logs/php_errors.log

# Check Apache logs
tail -f /var/log/apache2/access.log
tail -f /var/log/apache2/error.log

# Monitor disk space
df -h

# Check MySQL status
systemctl status mysql
```

### Security Scan
- Run security scanner (Sucuri, Wordfence, etc)
- Check for SQL injection vulnerabilities
- Test XSS protection
- Verify HTTPS certificate

---

## 🔄 Maintenance

### Regular Tasks
- [ ] Weekly database backups
- [ ] Monthly security updates
- [ ] Review error logs
- [ ] Update dependencies
- [ ] Monitor disk space

### Update Process
```bash
# Backup current version
tar -czf backup-$(date +%Y%m%d).tar.gz /path/to/site

# Upload new files
# Test in staging first
# Deploy to production
```

---

## 📞 Support

Jika ada masalah deployment:
1. Check dokumentasi ini
2. Review error logs
3. Test di local environment dulu
4. Hubungi tim IT KTT Indonesia

---

**Last Updated:** October 15, 2025
**Version:** 1.0.0
