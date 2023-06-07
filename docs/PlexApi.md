# PlexAPI

## Function List

| Visibility       | Function (parameters,...): return |
| :--------------- | :---------------- |
| public | <strong>__construct(</strong><em>string</em> <strong>$host = `'127.0.0.1'`</strong>, <em>mixed/int</em> <strong>$port = 32400</strong>, <em>bool</em> <strong>$ssl = false</strong>)</strong> : <em>void</em><br /><em>Instantiate the class with your Host/Port</em> |
| public | <strong>getBaseInfo()</strong> : <em>array\|bool</em><br /><em>Get Plex Server basic info</em> |
| public | <strong>getAccount()</strong> : <em>array\|bool</em><br /><em>Get account info</em> |
| public | <strong>getLastCallStats()</strong> : <em>array</em><br /><em>Get last curl stats, for debugging purposes</em> |
| public | <strong>getLibrarySections()</strong> : <em>array\|bool</em><br /><em>Get Library Sections ie Movies, TV Shows etc</em> |
| public | <strong>getLibrarySectionContents(</strong><em>int</em> <strong>$sectionKey</strong>, <em>bool</em> <strong>$returnCollection = `false`)</strong> : <em>array\|ItemCollection\|bool</em><br /><em>Get Library Section contents</em> |
| public | <strong>getMetadata(</strong><em>int</em> <strong>$item</strong>)</strong> : <em>array\|bool</em><br /><em>Get Metadata for an Item</em> |
| public | <strong>getArtwork(</strong><em>Movie</em> <strong>$item</strong>, <em>string</em> <strong>$tag</strong>) : <em>string</em><br /><em>Get binary data for artwork, can store as `jpg` at return</em> |
| public | <strong>getOnDeck(</strong><em>bool</em> <strong>$returnCollection = `false`)</strong> : <em>array\|ItemCollection\|bool</em><br /><em>Get On Deck Info</em> |
| public | <strong>getRecentlyAdded(</strong><em>bool</em> <strong>$returnCollection = `false`)</strong> : <em>array\|ItemCollection\|bool</em><br /><em>Get Recently Added</em> |
| public | <strong>getServers()</strong> : <em>array\|bool</em><br /><em>Get Servers</em> |
| public | <strong>getSessions()</strong> : <em>array\|bool</em><br /><em>Get Sessions from Plex</em> |
| public | <strong>getToken()</strong> : <em>string/bool</em><br /><em>Tests the set username and password and returns the auth token</em> |
| public | <strong>getTranscodeSessions()</strong> : <em>array\|bool</em><br /><em>Get Transcode Sessions from Plex</em> |
| public | <strong>refreshLibrarySection(</strong><em>int</em> <strong>$sectionKey</strong>, <em>bool</em> <strong>$force = `false`</strong>)</strong> : <em>null/bool</em><br /><em>Refresh a Library Section. This makes Plex search for new and removed items from the Library paths. Doesn't return anything when successful.</em> |
| public | <strong>refreshMetadata(</strong><em>int</em> <strong>$item</strong>, <em>bool</em> <strong>$force = `false`</strong>)</strong> : <em>null/bool</em><br /><em>Refresh a specific item. Doesn't return anything when successful.</em> |
| public | <strong>search(</strong><em>string</em> <strong>$query</strong>, <em>bool</em> <strong>$returnCollection = `false`)</strong> : <em>array\|ItemCollection\|bool</em><br /><em>Search for Items</em> |
| public | <string>filter(</strong><em>int</em> <strong>$sectionKey</strong>, <em>array</em> <strong>$filters</strong>, <em>bool</em> <strong>$returnCollection = `false`)</strong>: <em>array\|ItemCollection\|bool</em><br /><em>Filter a library section using common syntax</em> |
| public | <strong>setAuth(</strong><em>string</em> <strong>$username</strong>, <em>string</em> <strong>$password</strong>)</strong> : <em>void</em><br /><em>Credentials for logging into Plex.tv. Username can also be an email address.</em> |
| public | <strong>setToken(</strong><em>string</em> <strong>$token</strong>)</strong> : <em>void</em><br /><em>A valid token for a logged in device, obtainable using setAuth().</em> |
| public | <strong>setClientIdentifier(</strong><em>string</em> <strong>$identifier</strong>)</strong> : <em>void</em><br /><em>setClientIdentifier</em> |
| public | <strong>setDevice(</strong><em>string</em> <strong>$name</strong>)</strong> : <em>void</em><br /><em>setDevice</em> |
| public | <strong>setDeviceName(</strong><em>string</em> <strong>$name</strong>)</strong> : <em>void</em><br /><em>setDeviceName</em> |
| public | <strong>setProductName(</strong><em>string</em> <strong>$name</strong>)</strong> : <em>void</em><br /><em>setProductName</em> |
| public | <strong>setTimeout(</strong><em>int</em> <strong>$timeout</strong>)</strong> : <em>void</em><br /><em>setTimeout</em> |
| protected | <strong>call(</strong><em>string</em> <strong>$path</strong>, <em>array</em> <strong>$params=array()</strong>, <em>string</em> <strong>$method = `'GET'`</strong>, <em>bool</em> <strong>$isLoginCall = `false`</strong>)</strong> : <em>array\|bool</em><br /><em>Make an API Call or Login Call</em> |
| private | <strong>buildHttpQuery(</strong><em>array</em> <strong>$query)</strong>: <em>string</em><br /><em>Build http query string from array of `Filter` objects</em> |
| protected static | <strong>normalizeSimpleXML(</strong><em>mixed</em> <strong>$obj</strong>, <em>mixed</em> <strong>$result</strong>)</strong> : <em>void</em><br /><em>normalizeSimpleXML</em> |
| protected static | <strong>xml2array(</strong><em>mixed</em> <strong>$xml</strong>)</strong> : <em>mixed</em><br /><em>xml2array</em> |
| public static | <strong>array2collection(</strong><em>array</em> <strong>$array)</strong>: <em>ItemCollection</em> |
| public static | <strong>array2object(</strong><em>array</em> <strong>$array)</strong>: <em>Movie\|Show\|Season\|Episode\|Artist\|Album\|Track</em> |
