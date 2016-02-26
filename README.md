# Framework Installer

<img src="framework.png" alt="Framework Installer" />

## How To Use
```php
# Download and unzip Wordpress (or a framework of your choosing).

$install = new installer($url);
$install->download($install->framework['wordpress']);
$install->unpack();
```
or
```php
# Download and unzip your custom framework.  Then create the database connection file.

$install = new installer();
$install->download('http://your-domain.com/framework.zip');
$install->unpack();
$cred = array(
	'DB_HOST' => 'localhost', 
	'DB_DATABASE' => 'user_db12', 
	'DB_USER' => 'user_kewl', 
	'DB_PASSWORD' => 'abc123456'
	);
$install->create($cred, 'db-config.php');
```
