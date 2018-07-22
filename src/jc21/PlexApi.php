<?php

namespace jc21;

/**
 * Plex API Class - Communicate with your Plex Media Server.
 *
 * @license BSD
 * @author  Jamie Curnow  <jc@jc21.com>
 * @version 1.0
 *
 * @example
 * <code>
 *  <?php
 *      $client = new jc21\PlexApi('192.168.0.10');
 *      $client->setAuth('username', 'password');
 *      $sections = $client->getLibrarySections();
 * </code>
 *
 */

class PlexApi {

    const GET    = 'GET';
    const POST   = 'POST';
    const PUT    = 'PUT';
    const DELETE = 'DELETE';

    /**
     * The hostname/ip of the Plex server
     *
     * @var string
     */
    protected $host = null;

    /**
     * The Port of the Plex Server
     *
     * @var int
     */
    protected $port = 32400;

    /**
     * Use SSL communicating with Plex server
     *
     * @var int
     */
    protected $ssl = false;

    /**
     * Your Plex.tv Username or Email
     *
     * @var string
     */
    protected $username = null;

    /**
     * Your Plex.tv Password
     *
     * @var string
     */
    protected $password = null;

    /**
     * The Plex client identifier for this App/Script.
     * This shows up in the Devices section of Plex.
     *
     * @var string
     */
    protected $clientIdentifier = 'ec87b5d1-b5e4-4114-ad66-19c747d87c1f';

    /**
     * The Plex product name.
     * This shows up in the Devices section of Plex.
     *
     * @var string
     */
    protected $productName = 'PHPClient';

    /**
     * The Plex device.
     * This shows up in the Devices section of Plex.
     *
     * @var string
     */
    protected $device = 'Script';

    /**
     * The Plex device name
     * This shows up in the Devices section of Plex.
     *
     * @var string
     */
    protected $deviceName = 'Script';

    /**
     * The Socket Timeout limit in seconds
     *
     * @var int
     *
     **/
    protected $timeout = 30;

    /**
     * The last curl connection stats
     *
     * @var array
     *
     **/
    protected $lastCallStats = null;

    /**
     * The Auth Token obtained from Plex.tv login
     *
     * @var string
     *
     **/
    protected $token = null;


    /**
     * Instantiate the class with your Host/Port
     *
     * @param string $host
     * @param int    $port
     */
    public function __construct($host = '127.0.0.1', $port = 32400, $ssl = false)
    {
        $this->host = $host;
        $this->port = (int) $port;
        $this->ssl = (bool) $ssl;
    }


    /**
     * Credentials for logging into Plex.tv.
     * Username can also be an email address.
     *
     * @param  string  $username
     * @param  string  $password
     * @return void
     */
    public function setAuth($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Tests the set username and password and returns the auth token
     *
     * @return string
     */
    public function getToken()
    {
        if($this->getBaseInfo() !== false)
        {
            return $this->token;
        }
        return false;
    }

    /**
     * Sets the token
     *
     * @return string
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Get Plex Server basic info
     *
     * @return array|bool
     */
    public function getBaseInfo()
    {
        return $this->call('/');
    }


    /**
     * Get Sessions from Plex
     *
     * @return array|bool
     */
    public function getSessions()
    {
        return $this->call('/status/sessions');
    }


    /**
     * Get Transcode Sessions from Plex
     *
     * @return array|bool
     */
    public function getTranscodeSessions()
    {
        return $this->call('/transcode/sessions');
    }


    /**
     * Get On Deck Info
     *
     * @return array|bool
     */
    public function getOnDeck()
    {
        return $this->call('/library/onDeck');
    }


    /**
     * Get Library Sections ie Movies, TV Shows etc
     *
     * @return array|bool
     */
    public function getLibrarySections()
    {
        return $this->call('/library/sections');
    }

    /**
     * Get Library Section contents
     *
     * @param  int   $sectionKey  Obtained using getLibrarySections()
     * @return array|bool
     */
    public function getLibrarySectionContents($sectionKey)
    {
        return $this->call('/library/sections/' . $sectionKey . '/all');
    }


    /**
     * Refresh a Library Section.
     * This makes Plex search for new and removed items from the Library paths.
     * Doesn't return anything when successful.
     *
     * @param  int   $sectionKey  Obtained using getLibrarySections()
     * @param  bool  $force
     * @return null|bool
     */
    public function refreshLibrarySection($sectionKey, $force = false)
    {
        $options = [];
        if ($force) {
            $options['force'] = 1;
        }

        return $this->call('/library/sections/' . $sectionKey . '/refresh', $options);
    }


    /**
     * Refresh a specific item.
     * Doesn't return anything when successful.
     *
     * @param  int   $item
     * @param  bool  $force
     * @return null|bool
     */
    public function refreshMetadata($item, $force = false)
    {
        $options = [];
        if ($force) {
            $options['force'] = 1;
        }

        return $this->call('/library/metadata/' . (int) $item . '/refresh', $options, self::PUT);
    }


    /**
     * Get Recently Added
     *
     * @return array|bool
     */
    public function getRecentlyAdded()
    {
        return $this->call('/library/recentlyAdded');
    }


    /**
     * Get Metadata for an Item
     *
     * @param  int   $item
     * @return array|bool
     */
    public function getMetadata($item)
    {
        return $this->call('/library/metadata/' . (int) $item);
    }


    /**
     * Search for Items
     *
     * @param  string  $query
     * @return array|bool
     */
    public function search($query)
    {
        return $this->call('/search', ['query' => $query]);
    }

    /**
     * Analyze an item
     *
     * @param  int   $item
     * @return bool
     */
    public function analyze($item)
    {
        return $this->call('/library/metadata/' . (int) $item . '/analyze', [], self::PUT);
    }

    /**
     * Get Potential Metadata Matches for an item
     *
     * @param  int      $item
     * @param  string   $agent
     * @param  string   $language
     * @return array
     */
    public function getMatches($item, $agent = 'com.plexapp.agents.imdb', $language = 'en')
    {
        return $this->call('/library/metadata/' . (int) $item . '/matches', ['manual' => 1, 'agent' => $agent, 'language' => $language], self::GET);
    }

    /**
     * Set the Metadata Match for an item
     *
     * @param  int      $item
     * @param  string   $name
     * @param  string   $guid
     * @return array
     */
    public function setMatch($item, $name, $guid)
    {
        return $this->call('/library/metadata/' . (int) $item . '/match', ['name' => $name, 'guid' => $guid], self::PUT);
    }


    /**
     * Get Servers
     *
     * @return array|bool
     */
    public function getServers()
    {
        return $this->call('/servers');
    }


    /**
     * setClientIdentifier
     *
     * @param  string  $identifier
     * @return void
     */
    public function setClientIdentifier($identifier)
    {
        $this->clientIdentifier = $identifier;
    }


    /**
     * setProductName
     *
     * @param  string  $name
     * @return void
     */
    public function setProductName($name)
    {
        $this->productName = $name;
    }


    /**
     * setDevice
     *
     * @param  string  $name
     * @return void
     */
    public function setDevice($name)
    {
        $this->device = $name;
    }


    /**
     * setDeviceName
     *
     * @param  string  $name
     * @return void
     */
    public function setDeviceName($name)
    {
        $this->deviceName = $name;
    }


    /**
     * setTimeout
     *
     * @param  int    $timeout
     * @return void
     */
    public function setTimeout($timeout)
    {
        $this->timeout = (int) $timeout;
    }


    /**
     * Get last curl stats, for debugging purposes
     *
     * @return array
     */
    public function getLastCallStats()
    {
        return $this->lastCallStats;
    }


    /**
     * Make an API Call or Login Call
     *
     * @param  string $path
     * @param  array $params
     * @param  string $method
     * @param  bool $isLoginCall
     * @return array|bool
     * @throws \Exception
     */
    protected function call($path, $params = [], $method = self::GET, $isLoginCall = false)
    {
        if (!$this->token && !$isLoginCall) {
            $this->call('https://plex.tv/users/sign_in.xml', [], self::POST, true);
        }

        if ($isLoginCall) {
            $fullUrl = $path;
        } else {
            $fullUrl = $this->ssl ? 'https://' : 'http://';
            $fullUrl .= $this->host . ':' . $this->port . $path;
            if ($params && count($params)) {
                $fullUrl .= '?' . http_build_query($params);
            }
        }

        // Setup curl array
        $curlOptArray = [
            CURLOPT_URL            => $fullUrl,
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => $this->timeout,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_FAILONERROR    => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER     => [
                'X-Plex-Client-Identifier: ' . $this->clientIdentifier,
                'X-Plex-Product: ' . $this->productName,
                'X-Plex-Version: 1.0',
                'X-Plex-Device: ' . $this->device,
                'X-Plex-Device-Name: ' . $this->deviceName,
                'X-Plex-Platform: Linux',
                'X-Plex-Platform-Version: 1.0',
                'X-Plex-Provides: controller',
                'X-Plex-Username: ' . $this->username,
            ],
        ];

        if ($isLoginCall) {
            $curlOptArray[CURLOPT_HTTPAUTH] = CURLAUTH_ANY;
            $curlOptArray[CURLOPT_USERPWD]  = $this->username . ':' . $this->password;
        } else {
            $curlOptArray[CURLOPT_HTTPHEADER][] = 'X-Plex-Token: ' . $this->token;
        }

        if ($method == self::POST) {
            $curlOptArray[CURLOPT_POST] = true;
        } else if ($method != self::GET) {
            $curlOptArray[CURLOPT_CUSTOMREQUEST] = $method;
        }

        // Reset vars
        $this->lastCallStats = null;

        // Send
        $resource = curl_init();
        curl_setopt_array($resource, $curlOptArray);

        // Send!
        $response = curl_exec($resource);

        // Stats
        $this->lastCallStats = curl_getinfo($resource);

        // Errors and redirect failures
        if (!$response) {
            $response        = false;
            error_log(curl_errno($resource) . ': ' . curl_error($resource));
        } else {
            $response = self::xml2array($response);

            if ($isLoginCall) {
                if ($this->lastCallStats['http_code'] != 201) {
                    throw new \Exception('Invalid status code in authentication response from Plex.tv, expected 201 but got ' . $this->lastCallStats['http_code']);
                }

                $this->token = $response['authentication-token'];
            }
        }

        curl_close($resource);
        return $response;
    }


    /**
     * xml2array
     *
     * @param $xml
     * @return mixed
     */
    protected static function xml2array($xml)
    {
        self::normalizeSimpleXML(simplexml_load_string($xml), $result);
        return $result;
    }


    /**
     * normalizeSimpleXML
     *
     * @param $obj
     * @param $result
     */
    protected static function normalizeSimpleXML($obj, &$result)
    {
        $data = $obj;
        if (is_object($data)) {
            $data = get_object_vars($data);
        }
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $res = null;
                self::normalizeSimpleXML($value, $res);
                if (($key == '@attributes') && ($key)) {
                    $result = $res;
                } else {
                    $result[$key] = $res;
                }
            }
        } else {
            $result = $data;
        }
    }
}
