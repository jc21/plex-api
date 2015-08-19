<?php

require_once __DIR__ . '/../vendor/autoload.php';

use jc21\PlexApi;



$client = new PlexApi('192.168.0.10');

$client->setAuth('username', 'password');

$result = $client->getLibrarySections();

foreach ($result['Directory'] as $section) {
    // Output
    print $section['key'] . ': ' . $section['title'] . ' (type: ' . $section['type'] . ')' . PHP_EOL;

    // Refresh
    $client->refreshLibrarySection($section['key']);
}
