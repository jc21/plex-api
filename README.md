Plex API for PHP
================================================

This is a basic API wrapper for Plex. See the
[documentation](docs/Documentation.md) for functionality.

This doesn't use the Plex.tv API apart from
signing in.

XML data returned is interpreted into arrays. 

### Installing via Composer

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version:

```bash
composer.phar require jc21/plex-api
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

### Using

```php
use jc21\PlexApi;

$client = new PlexApi('192.168.0.10');
$client->setAuth('username', 'password');
$result = $client->getOnDeck();
print_r($result);
```

