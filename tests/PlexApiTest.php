<?php

namespace jc21\PlexApi\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

use jc21\PlexApi;
use jc21\Util\Filter;
use jc21\Collections\ItemCollection;

/**
 * @coversDefaultClass PlexApi
 */
class TestPlexApi extends TestCase
{

    /**
     * Api to check
     * 
     * @var PlexApi
     */
    private ?PlexApi $api;

    /**
     * Plex.tv username
     * 
     * @var string
     */
    private string $user;

    /**
     * Plex.tv password
     * 
     * @var string
     */
    private string $password;

    /**
     * Local Plex server
     * 
     * @var string
     */
    private string $host;

    /**
     * Port to connect to Plex through
     * 
     * @var int
     */
    private int $port;

    /**
     * Connect to Plex through SSL
     * 
     * @var bool
     */
    private bool $ssl;

    /**
     * Plex token for authentication
     * 
     * @var string
     */
    private string $token;

    /**
     * Setup function
     */
    public function setUp(): void
    {
        $dot = new Dotenv();

        $envfname = __DIR__.'/.env';
        if(!file_exists($envfname)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', $envfname));
        }

        $dot->loadEnv($envfname);

        $this->api = null;
        if(!$this->envCheck()) {
            die;
        }

        $this->api = new PlexApi($this->host, $this->port, $this->ssl);
        if ($this->token) {
            $this->api->setToken($this->token);
        } else {
            $this->api->setAuth($this->user, $this->password);

            throw new \Exception("Put this token in your .env file {$envfname} as 'PLEX_TOKEN={$this->api->getToken()}'");
        }
    }

    private function envCheck()
    {
        $this->host = (isset($_ENV['PLEX_HOST']) ? $_ENV['PLEX_HOST'] : false);
        $this->token = (isset($_ENV['PLEX_TOKEN']) ? $_ENV['PLEX_TOKEN'] : false);
        $this->user = (isset($_ENV['PLEX_USER']) ? $_ENV['PLEX_USER'] : false);
        $this->password = (isset($_ENV['PLEX_PASSWORD']) ? $_ENV['PLEX_PASSWORD'] : false);
        $this->port = (isset($_ENV['PLEX_PORT']) ? $_ENV['PLEX_PORT'] : false);
        $this->ssl = (isset($_ENV['PLEX_SSL']) ? (bool) $_ENV['PLEX_SSL'] : false);
        $ret = true;

        if ($this->host === false) {
            print("PLEX_HOST not found in .env file".PHP_EOL);
        }

        if ($this->token === false && ($this->user === false || $this->password === false)) {
            print("PLEX_TOKEN not found in .env file".PHP_EOL);
            $ret = false;
        }

        if (!isset($_ENV['SECTION_KEY']) || !is_numeric($_ENV['SECTION_KEY'])) {
            print("SECTION_KEY not found or not INT in .env, populate with ID of library you want to test".PHP_EOL);
            $ret = false;
        }

        if (!isset($_ENV['ITEM_ID']) || !is_numeric($_ENV['ITEM_ID'])) {
            print("ITEM_ID not found or not INT in .env".PHP_EOL);
            $ret = false;
        }

        if (!isset($_ENV['SEARCH_QUERY'])) {
            print("SEARCH_QUERY not found in .env".PHP_EOL);
            $ret = false;
        }

        if (!isset($_ENV['FILTER_QUERY'])) {
            print("FILTER_QUERY not found in .env, MUST be a title filter".PHP_EOL);
            $ret = false;
        }

        return $ret;
    }

    public function testConnection()
    {
        $this->assertTrue(is_a($this->api, "jc21\PlexApi"));
    }

    public function testGetSessions()
    {
        $this->assertArrayHasKey('size', $this->api->getSessions());
    }

    public function testOnDeck()
    {
        $od = $this->api->getOnDeck();
        $this->assertArrayHasKey('size', $od);
    }

    public function testOnDeckReturnCollection()
    {
        $od = $this->api->getOnDeck(true);
        $this->assertInstanceOf(ItemCollection::class, $od);
    }

    public function testOnDeckHasItems()
    {
        $od = $this->api->getOnDeck(true);
        $this->assertGreaterThan(0, $od->count());
    }

    public function testGetSections()
    {
        $sec = $this->api->getLibrarySections();
        $this->assertArrayHasKey('size', $sec);

        $this->assertGreaterThan(0, $sec['size']);
    }

    public function testGetLibrarySectionContents()
    {
        $res = $this->api->getLibrarySectionContents($_ENV['SECTION_KEY']);
        $this->assertArrayHasKey('size', $res);

        $this->assertGreaterThan(0, $res['size']);
    }

    public function testGetLibrarySectionContentsAsCollection()
    {
        $res = $this->api->getLibrarySectionContents($_ENV['SECTION_KEY'], true);
        $this->assertInstanceOf(ItemCollection::class, $res);

        $this->assertGreaterThan(0, $res->count());
    }

    public function testGetRecentlyAdded()
    {
        $res = $this->api->getRecentlyAdded();
        $this->assertIsArray($res);

        $this->assertArrayHasKey('size', $res);

        $this->assertGreaterThan(0, $res['size']);
    }

    public function testGetMetadata()
    {
        $res = $this->api->getMetadata($_ENV['ITEM_ID']);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('size', $res);
        $this->assertGreaterThan(0, $res['size']);
    }

    public function testSearch()
    {
        $res = $this->api->search($_ENV['SEARCH_QUERY']);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('size', $res);
        $this->assertGreaterThan(0, $res['size']);
    }

    public function testSearchReturnCollection()
    {
        $res = $this->api->search($_ENV['SEARCH_QUERY'], true);
        $this->assertInstanceOf(ItemCollection::class, $res);
        $this->assertGreaterThan(0, $res->count());
    }

    public function testFilter()
    {
        $res = $this->api->filter($_ENV['SECTION_KEY'], ['title' => $_ENV['FILTER_QUERY']]);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('size', $res);
        $this->assertGreaterThan(0, $res['size']);
    }

    public function testFilterWithFilterObject()
    {
        $filter = new Filter('title', $_ENV['FILTER_QUERY']);
        $res = $this->api->filter($_ENV['SECTION_KEY'], [$filter]);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('size', $res);
        $this->assertGreaterThan(0, $res['size']);
    }

    public function testFilterReturnCollection()
    {
        $res = $this->api->filter($_ENV['SECTION_KEY'], ['title' => $_ENV['FILTER_QUERY']], true);
        $this->assertInstanceOf(ItemCollection::class, $res);
        $this->assertGreaterThan(0, $res->count());
    }

    public function testFilterWithFilterObjectReturnCollection()
    {
        $filter = new Filter('title', $_ENV['FILTER_QUERY']);
        $res = $this->api->filter($_ENV['SECTION_KEY'], [$filter], true);
        $this->assertInstanceOf(ItemCollection::class, $res);
        $this->assertGreaterThan(0, $res->count());
    }

    public function testGetMatches()
    {
        $res = $this->api->getMatches($_ENV['ITEM_ID']);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('size', $res);
        $this->assertGreaterThan(0, $res['size']);
    }
}
