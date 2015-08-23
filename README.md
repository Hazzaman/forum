# THIS IS THE GITHUB README NOT FOR THE SUBMITTED FILES
# These steps have already been performed on the files used for final submission
# Forum web application

## Setup using this repo
This github repo doesn't contain config/app.php as this contains database passwords
    (Must be created from config/app.default.php)

It also doesn't contain the vender/ dir which is where the cakephp framework is actually stored.
Composer has been used for managing dependencies 
    (https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

Run 'php composer.phar install' to install the required dependencies from the composer.json file
For composer to install cakephp 3 the php intl extension is requried
    Ubuntu: (sudo apt-get install php5-intl) and you must restart apache2
    or (https://secure.php.net/manual/en/intl.installation.php)
    