<?php

namespace jc21\PlexApi\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

use jc21\PlexApi;
use jc21\Util\Filter;
use jc21\Collections\ItemCollection;
use jc21\TV\Episode;

/**
 * @coversDefaultClass PlexApi
 */
class TestPlexApi extends TestCase
{

    /**
     * Constant message to output when test skipped
     *
     * @var string
     */
    private const MOVIE_OFF_MSG = "Movie tests turned off";

    /**
     * Constant message to output when test skipped
     *
     * @var string
     */
    private const TV_OFF_MSG = "TV tests turned off";

    /**
     * Constant message to output when test skipped
     *
     * @var string
     */
    private const MUSIC_OFF_MSG = "Music tests turned off";

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
     * Variable to decide if we are running movie tests
     *
     * @var bool
     */
    private bool $runMovieTests;

    /**
     * Variable to decide if we are running TV tests
     *
     * @var bool
     */
    private bool $runTVTests;

    /**
     * Variable to decide if we are running music tests
     *
     * @var bool
     */
    private bool $runMusicTests;

    /**
     * Setup function
     */
    public function setUp(): void
    {
        $this->runMovieTests = false;
        $this->runTVTests = false;
        $this->runMusicTests = false;

        $dot = new Dotenv();

        $envfname = __DIR__.'/.env';
        if (!file_exists($envfname) || !is_readable($envfname)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist or is not readable', $envfname));
        }

        $dot->loadEnv($envfname);

        $this->api = null;
        if (!$this->envCheck()) {
            die;
        }

        $this->api = new PlexApi($this->host, $this->port, $this->ssl);
        if ($this->token) {
            $this->api->setToken($this->token);
        } else {
            $this->api->setAuth($this->user, $this->password);

            die("Put this token in your .env file {$envfname} as 'PLEX_TOKEN={$this->api->getToken()}' and then you can remove PLEX_USER and PLEX_PASSWORD if you like");
        }

        $GLOBALS['client'] = $this->api;
    }

    /**
     * Helper method to check available environment variables
     *
     * @return bool
     */
    private function envCheck()
    {
        $this->host = (isset($_ENV['PLEX_HOST']) ? $_ENV['PLEX_HOST'] : false);
        $this->token = (isset($_ENV['PLEX_TOKEN']) ? $_ENV['PLEX_TOKEN'] : '');
        $this->user = (isset($_ENV['PLEX_USER']) ? $_ENV['PLEX_USER'] : false);
        $this->password = (isset($_ENV['PLEX_PASSWORD']) ? $_ENV['PLEX_PASSWORD'] : false);
        $this->port = (isset($_ENV['PLEX_PORT']) ? $_ENV['PLEX_PORT'] : 32400);
        $this->ssl = (isset($_ENV['PLEX_SSL']) ? (bool) $_ENV['PLEX_SSL'] : false);
        $ret = true;

        if ($this->host === false) {
            print("PLEX_HOST not found in .env file".PHP_EOL);
        }

        if (empty($this->token) && ($this->user === false || $this->password === false)) {
            print("PLEX_TOKEN not found in .env file".PHP_EOL);
            $ret = false;
        }

        if (isset($_ENV['MOVIE_TESTS']) && ((bool) $_ENV['MOVIE_TESTS'])) {
            $this->runMovieTests = true;

            if (!isset($_ENV['MOVIE_SECTION_KEY']) || !is_numeric($_ENV['MOVIE_SECTION_KEY'])) {
                print("MOVIE_SECTION_KEY not found or not INT in .env, populate with ID of library you want to test".PHP_EOL);
                $ret = false;
            }

            if (!isset($_ENV['MOVIE_ITEM_ID']) || !is_numeric($_ENV['MOVIE_ITEM_ID'])) {
                print("MOVIE_ITEM_ID not found or not INT in .env".PHP_EOL);
                $ret = false;
            }

            if (!isset($_ENV['MOVIE_SEARCH_QUERY'])) {
                print("MOVIE_SEARCH_QUERY not found in .env".PHP_EOL);
                $ret = false;
            }

            if (!isset($_ENV['MOVIE_FILTER_QUERY'])) {
                print("MOVIE_FILTER_QUERY not found in .env, MUST be a title filter".PHP_EOL);
                $ret = false;
            }
        }

        if (isset($_ENV['TV_TESTS']) && ((bool) $_ENV['TV_TESTS'])) {
            $this->runTVTests = true;

            if (!isset($_ENV['TV_SECTION_KEY']) || !is_numeric($_ENV['TV_SECTION_KEY'])) {
                print("TV_SECTION_KEY not found or not INT in .env, populate with ID of library you want to test".PHP_EOL);
                $ret = false;
            }

            if (!isset($_ENV['TV_ITEM_ID']) || !is_numeric($_ENV['TV_ITEM_ID'])) {
                print("TV_ITEM_ID not found or not INT in .env".PHP_EOL);
                $ret = false;
            }

            if (!isset($_ENV['TV_SEARCH_QUERY'])) {
                print("TV_SEARCH_QUERY not found in .env".PHP_EOL);
                $ret = false;
            }

            if (!isset($_ENV['TV_FILTER_QUERY'])) {
                print("TV_FILTER_QUERY not found in .env, MUST be a title filter".PHP_EOL);
                $ret = false;
            }
        }

        if (isset($_ENV['MUSIC_TESTS']) && ((bool) $_ENV['MUSIC_TESTS'])) {
            $this->runMusicTests = true;

            if (!isset($_ENV['MUSIC_SECTION_KEY']) || !is_numeric($_ENV['MUSIC_SECTION_KEY'])) {
                print("MUSIC_SECTION_KEY not found in .env".PHP_EOL);
                $ret = false;
            }

            if (!isset($_ENV['MUSIC_SEARCH_QUERY'])) {
                print("MUSIC_SEARCH_QUERY not found in .env".PHP_EOL);
                $ret = false;
            }

            if (!isset($_ENV['MUSIC_FILTER_QUERY'])) {
                print("MUSIC_FILTER_QUERY not found in .env MUST be a title filter".PHP_EOL);
                $ret = false;
            }
        }

        return $ret;
    }

    public function testConnection()
    {
        $this->assertTrue(is_a($this->api, "jc21\PlexApi"));
    }

    public function testGetBaseInfo()
    {
        $res = $this->api->getBaseInfo();
        $this->assertIsArray($res);
        $this->assertArrayHasKey('size', $res);
        $this->assertGreaterThan(0, $res['size']);
    }

    public function testGetAccount()
    {
        $res = $this->api->getAccount();
        $this->assertIsArray($res);
        $this->assertArrayHasKey('signInState', $res);
        $this->assertEquals('ok', $res['signInState']);
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

    public function testGetRecentlyAdded()
    {
        $res = $this->api->getRecentlyAdded();
        $this->assertIsArray($res);
        $this->assertArrayHasKey('size', $res);
        $this->assertGreaterThan(0, $res['size']);
    }

    public function testGetSections()
    {
        $sec = $this->api->getLibrarySections();
        $this->assertArrayHasKey('size', $sec);
        $this->assertGreaterThan(0, $sec['size']);
    }

    public function testGetMovieLibrarySectionContents()
    {
        if (!$this->runMovieTests) {
            $this->markTestSkipped(self::MOVIE_OFF_MSG);
            return;
        }

        $res = $this->api->getLibrarySectionContents($_ENV['MOVIE_SECTION_KEY']);
        $this->assertArrayHasKey('size', $res);
        $this->assertGreaterThan(0, $res['size']);
    }

    public function testGetMovieLibrarySectionContentsAsCollection()
    {
        if (!$this->runMovieTests) {
            $this->markTestSkipped(self::MOVIE_OFF_MSG);
            return;
        }

        $res = $this->api->getLibrarySectionContents($_ENV['MOVIE_SECTION_KEY'], true);
        $this->assertInstanceOf(ItemCollection::class, $res);
        $this->assertGreaterThan(0, $res->count());
    }

    public function testGetMetadata()
    {
        if (!$this->runMovieTests) {
            $this->markTestSkipped(self::MOVIE_OFF_MSG);
            return;
        }

        $res = $this->api->getMetadata($_ENV['MOVIE_ITEM_ID']);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('size', $res);
        $this->assertGreaterThan(0, $res['size']);
    }

    public function testMovieSearch()
    {
        if (!$this->runMovieTests) {
            $this->markTestSkipped(self::MOVIE_OFF_MSG);
            return;
        }

        $res = $this->api->search($_ENV['MOVIE_SEARCH_QUERY']);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('Video', $res);
        $this->assertGreaterThan(0, count($res['Video']));
    }

    public function testMovieSearchReturnCollection()
    {
        if (!$this->runMovieTests) {
            $this->markTestSkipped(self::MOVIE_OFF_MSG);
            return;
        }

        $res = $this->api->search($_ENV['MOVIE_SEARCH_QUERY'], true);
        $this->assertInstanceOf(ItemCollection::class, $res);
        $this->assertGreaterThan(0, $res->count());
    }

    public function testMovieFilterAsFilterArray()
    {
        if (!$this->runMovieTests) {
            $this->markTestSkipped(self::MOVIE_OFF_MSG);
            return;
        }

        $res = $this->api->filter($_ENV['MOVIE_SECTION_KEY'], ['title' => $_ENV['MOVIE_FILTER_QUERY']]);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('size', $res);
        $this->assertGreaterThan(0, $res['size']);
    }

    public function testMovieFilterWithFilterObject()
    {
        if (!$this->runMovieTests) {
            $this->markTestSkipped(self::MOVIE_OFF_MSG);
            return;
        }

        $filter = new Filter('title', $_ENV['MOVIE_FILTER_QUERY']);
        $res = $this->api->filter($_ENV['MOVIE_SECTION_KEY'], [$filter]);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('size', $res);
        $this->assertGreaterThan(0, $res['size']);
    }

    public function testMovieFilterReturnCollection()
    {
        if (!$this->runMovieTests) {
            $this->markTestSkipped(self::MOVIE_OFF_MSG);
            return;
        }

        $res = $this->api->filter($_ENV['MOVIE_SECTION_KEY'], ['title' => $_ENV['MOVIE_FILTER_QUERY']], true);
        $this->assertInstanceOf(ItemCollection::class, $res);
        $this->assertGreaterThan(0, $res->count());
    }

    public function testMovieFilterWithFilterObjectReturnCollection()
    {
        if (!$this->runMovieTests) {
            $this->markTestSkipped(self::MOVIE_OFF_MSG);
            return;
        }

        $filter = new Filter('title', $_ENV['MOVIE_FILTER_QUERY']);
        $res = $this->api->filter($_ENV['MOVIE_SECTION_KEY'], [$filter], true);
        $this->assertInstanceOf(ItemCollection::class, $res);
        $this->assertGreaterThan(0, $res->count());
    }

    public function testMovieGetMatches()
    {
        if (!$this->runMovieTests) {
            $this->markTestSkipped(self::MOVIE_OFF_MSG);
            return;
        }

        $res = $this->api->getMatches($_ENV['MOVIE_ITEM_ID']);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('size', $res);
        $this->assertGreaterThan(0, $res['size']);
    }

    public function testGetTVLibrarySectionContents()
    {
        if (!$this->runTVTests) {
            $this->markTestSkipped(self::TV_OFF_MSG);
            return;
        }

        $res = $this->api->getLibrarySectionContents($_ENV['TV_SECTION_KEY']);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('size', $res);
        $this->assertGreaterThan(0, $res['size']);
    }

    public function testGetTVLibrarySectionContentsReturnCollection()
    {
        if (!$this->runTVTests) {
            $this->markTestSkipped(self::TV_OFF_MSG);
            return;
        }

        $res = $this->api->getLibrarySectionContents($_ENV['TV_SECTION_KEY'], true);
        $this->assertInstanceOf(ItemCollection::class, $res);
        $this->assertGreaterThan(0, $res->count());
    }

    public function testGetTVItemMetadata()
    {
        if (!$this->runTVTests) {
            $this->markTestSkipped(self::TV_OFF_MSG);
            return;
        }

        $res = $this->api->getMetadata($_ENV['TV_ITEM_ID']);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('size', $res);
        $this->assertGreaterThan(0, $res['size']);
    }

    public function testGetTVItemMetadataAsObject()
    {
        if (!$this->runTVTests) {
            $this->markTestSkipped(self::TV_OFF_MSG);
            return;
        }

        $res = $this->api->getMetadata($_ENV['TV_ITEM_ID'], true);
        $this->assertInstanceOf(Episode::class, $res);
    }

    public function testTVSearch()
    {
        if (!$this->runTVTests) {
            $this->markTestSkipped(self::TV_OFF_MSG);
            return;
        }

        $res = $this->api->search($_ENV['TV_SEARCH_QUERY']);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('Video', $res);
        $this->assertGreaterThan(0, count($res['Video']));
    }

    public function testTVFilterWithFilterObjectReturnCollection()
    {
        if (!$this->runTVTests) {
            $this->markTestSkipped(self::TV_OFF_MSG);
            return;
        }

        $filter = new Filter('title', $_ENV['TV_FILTER_QUERY']);
        $res = $this->api->filter($_ENV['TV_SECTION_KEY'], [$filter], true);
        $this->assertInstanceOf(ItemCollection::class, $res);
        $this->assertGreaterThan(0, $res->count());
    }

    public function testGetMusic()
    {
        if (!$this->runMusicTests) {
            $this->markTestSkipped(self::MUSIC_OFF_MSG);
            return;
        }

        $res = $this->api->getLibrarySectionContents($_ENV['MUSIC_SECTION_KEY'], true);
        $this->assertGreaterThan(0, $res->count());
    }

    public function testMusicSearch()
    {
        if (!$this->runMusicTests) {
            $this->markTestSkipped(self::MUSIC_OFF_MSG);
            return;
        }

        $res = $this->api->search($_ENV['MUSIC_SEARCH_QUERY']);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('Directory', $res);
        $this->assertGreaterThan(0, count($res['Directory']));
    }

    public function testMusicFilterAsObject()
    {
        if (!$this->runMusicTests) {
            $this->markTestSkipped(self::MUSIC_OFF_MSG);
            return;
        }

        $filter = new Filter('title', $_ENV['MUSIC_FILTER_QUERY']);
        $res = $this->api->filter($_ENV['MUSIC_SECTION_KEY'], [$filter], true);
        $this->assertGreaterThan(0, $res->count());
    }
}
