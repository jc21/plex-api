<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use jc21\PlexApi;
use Symfony\Component\Dotenv\Dotenv;

$dot = new Dotenv();
$dot->loadEnv('tests/.env');

$client = new PlexApi($_ENV['PLEX_HOST']);
$client->setToken($_ENV['PLEX_TOKEN']);

print PHP_EOL."Select one of the ID's below to put in your .env file for the *_ITEM_ID value".PHP_EOL;

if (isset($_ENV['MOVIE_TESTS']) && (bool) $_ENV['MOVIE_TESTS']) {
    print PHP_EOL."List of 10 Movies".PHP_EOL;
    $movieCollection = $client->getLibrarySectionContents($_ENV['MOVIE_SECTION_KEY'], true);
    for ($x = 0; $x < 10; $x++) {
        $movie = $movieCollection->getData($x);
        print "{$movie->ratingKey}: {$movie->title}".PHP_EOL;
    }
    print PHP_EOL;
}

if (isset($_ENV['TV_TESTS']) && (bool) $_ENV['TV_TESTS']) {
    print "List of 10 TV shows".PHP_EOL;
    $tvCollection = $client->getLibrarySectionContents($_ENV['TV_SECTION_KEY'], true);
    for ($x = 0; $x < 10; $x++) {
        $tv = $tvCollection->getData($x);
        print "{$tv->ratingKey}: {$tv->title}".PHP_EOL;
    }
    print PHP_EOL;
}
