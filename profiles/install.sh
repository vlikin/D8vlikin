#!/bin/bash
#>sudo sh ./install.sh vlp1

profile_name=$1
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


chown -R www-data:www-data $site_path
chmod u+wx $site_path
ls -la $site_path
rm -Rf $site_path/settings.php $site_path/services.yml $site_path/files

sudo -uwww-data $drush si -y $profile_name \
    --root="$root_path" \
    --sites-subdir="$site" \
    --site-name="$site_name" \
    --account-name="$site_user" \
    --account-pass="$site_pass" \
    --db-url="mysql://$site_db_user:$site_db_pass@localhost/$site_db_name"