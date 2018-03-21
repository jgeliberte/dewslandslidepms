# dewslandslidepms
Performance Monitoring System for Dewslandslide website.

**INSTALLATION FOR UBUNTU**
1. Pull dewslandslidepms repository to /var/www
2. Configure Virtualhost for pms (/etc/hosts)
3. Configure Apache Virtualhost (/etc/apache2/sites-enabled)
4. Restart Apache2 server

**TO RUN DATABASE MIGRATION**
1. On command line, go to codeigniter folder.
2. Run this command "php index.php migrate help" for options.
3. Run "php index.php migrate latest" to migrate