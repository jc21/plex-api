# Documentation

[PlexApi](PlexApi.md)<br />
[ItemCollection](ItemCollection.md)<br />
[ItemIterator](ItemIterator.md)<br />
[Movie](Movie.md)<br />
[Show](Show.md)<br />
[Season](Season.md)<br />
[Episode](Episode.md)<br />

<hr />
### Class: \jc21\PlexApi

> Plex API Class - Communicate with your Plex Media Server.

###### Example
```php
<?php
$env = new Dotenv('.env');
$client = new jc21\PlexApi($_ENV['PLEX_HOST']);
$client->setAuth($_ENV['PLEX_USERNAME'], $_ENV['PLEX_PASSWORD']);
$sections = $client->getLibrarySections();
```
If you wish to store the authentication token for later usage:
```php
<?php
$env = new Dotenv('.env');
$client = new jc21\PlexApi($_ENV['PLEX_HOST']);
$client->setAuth($_ENV['PLEX_USERNAME'], $_ENV['PLEX_PASSWORD']);
$token = $client->getToken();
//Store the $token for later
```
The token can be reused on new requests later:
```php
<?php
$token = FakeModel::get('token');
$env = new Dotenv('.env');
$client = new jc21\PlexApi($_ENV['PLEX_HOST']);
$client->setToken($token);
//Now able to make requests just as if you started with a username / password
$sections = $client->getLibrarySections();
```
**Note**: There is no formal documentation referencing the lifespan of a token. These appear to have a long shelf-life, but it is possible they rotate occasionally.

