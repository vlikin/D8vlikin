#!/bin/bash
# It reinstalls the site and execute custom drush commands these tune the site.
#>sudo sh ./install.sh

profile_name="standard"
site_name="Test site"
site_user="admin"
site_pass="admin"
site_db_user="root"
site_db_pass=""
site_db_name="d8"
root_path="/var/www/d8/public_html"
site="default"
site_path=$root_path/sites/$site
drush="/github/drush-ops/drush/drush"
www_drush="sudo -uwww-data $drush"
uri="http://d8.local"

# It prepares the file system.
chown -R www-data:www-data $site_path
chmod u+wx $site_path
rm -Rf $site_path/settings.php
rm -Rf $site_path/services.yml
rm -Rf $site_path/files

# It installs the site.
$www_drush si -y $profile_name \
    --root="$root_path" \
    --sites-subdir="$site" \
    --uri="$uri" \
    --site-name="$site_name" \
    --account-name="$site_user" \
    --account-pass="$site_pass" \
    --db-url="mysql://$site_db_user:$site_db_pass@localhost/$site_db_name"

# It tunes the site.
$www_drush en vtc1
$www_drush en simpletest