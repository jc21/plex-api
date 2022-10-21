<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use jc21\PlexApi;
use Symfony\Component\Dotenv\Dotenv;

$dot = new Dotenv();
$dot->loadEnv("tests/.env");

$client = new PlexApi($_ENV['PLEX_HOST']);
$client->setToken($_ENV['PLEX_TOKEN']);
$result = $client->getLibrarySections();

foreach ($result['Directory'] as $section) {
    // Output
    print "{$section['key']}: {$section['title']} (type: {$section['type']})".PHP_EOL;
}
