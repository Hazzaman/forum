# Forum web application
This github repo doesn't contain config/app.php as this contains database passwords
    (Must be created from config/app.default.php)

It also doesn't contain the vender/ dir which is where the cakephp framework is actually stored.
Composer has been used for managing dependencies 
    (https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

Run 'php composer.phar install' to install the required dependencies from the composer.json file
For composer to install cakephp 3 the php intl extension is requried
    Ubuntu: (sudo apt-get install php5-intl)
    or (https://secure.php.net/manual/en/intl.installation.php)
    
## Installation

1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephp/app [app_name]`.

If Composer is installed globally, run
```bash
composer create-project --prefer-dist cakephp/app [app_name]
```

You should now be able to visit the path to where you installed the app and see
the setup traffic lights.

## Configuration

Read and edit `config/app.php` and setup the 'Datasources' and any other
configuration relevant for your application.
