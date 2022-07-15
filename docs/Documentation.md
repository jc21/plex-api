# Documentation

### Main Class

[PlexApi](PlexApi.md)<br />

### Collection Classes

`ItemCollection` - enables collection functionality and implements the `\IteratorAggregate` interface<br />
`ItemIterator` - enables iterator functionality and implements the `\Iterator` interface

### Media Classes

[Movie](Movie.md)<br />
[Show](Show.md)<br />
[Season](Season.md)<br />
[Episode](Episode.md)<br />

### Utility Classes

[Duration](Duration.md)<br />
[Filter](Filter.md)<br />
Item - only present for inheritance and `ItemCollection`<br />
[Location](Location.md)<br />
[Media](Media.md)<br />
[Size](Size.md)<br />
[Section](Section.md)

<hr />

## PlexApi

> Plex API Class - Communicate with your Plex Media Server.

**Note**: There is no formal documentation referencing the lifespan of a token. These appear to have a long shelf-life, but it is possible they rotate occasionally.

### Example
```php
$client = new jc21\PlexApi('{Plex server IP}');
$client->setAuth('username', 'password');
$sections = $client->getLibrarySections();
```
If you wish to store the authentication token for later usage:
```php
$client = new jc21\PlexApi('{Plex server IP}');
$client->setAuth('username', 'password');
$token = $client->getToken();
//Store the $token for later
```
The token can be reused on new requests later:
```php
$token = FakeModel::get('token');
$client = new jc21\PlexApi('{Plex server IP}');
$client->setToken($token);
//Now able to make requests just as if you started with a username / password
$sections = $client->getLibrarySections();
```

If you know which library section contains the data content you want (e.g. all your public movies).  The following will return an `ItemCollection` of all items in library section 1.  I can then loop through that collection to output each item in JSON.

```php
$client = new jc21\PlexApi('{Plex server IP}');
$movieLibrary = $client->getLibrarySectionContents(1, true);
foreach($movieLibrary as $movie) {
    print json_encode($movie).PHP_EOL;
}
```
