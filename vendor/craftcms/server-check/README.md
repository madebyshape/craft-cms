# Craft Server Check

This script checks if a server meets the minimum requirements to run a Craft 3 installation.

You can upload the `server` folder to your web server's public html folder and load `checkit.php` from your browser
or upload `server` anywhere on your server and execute `php checkit.php` from the console to see the results.

If you supply credentials in `config/db.php` to your database, then the script will perform some additional database checks as well. 
