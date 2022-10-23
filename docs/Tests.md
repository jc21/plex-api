# Tests

## Intro

PHPUnit is added for development purposes to be able to perform unit tests and make sure that all functions operate as expected.  To accomplish this an `.env` file needs to be created in the `/tests` folder with the following information:

| **Env**                | **Value**      | **Description**                                                            |
| ---------------------- | -------------- | -------------------------------------------------------------------------- |
| **PLEX_HOST**          | *ip\|hostname* | IP or host name of the Plex server                                         |
| **PLEX_PORT**          | *port*         | Port to connect to Plex server (optional, defaults 32400)                  |
| **PLEX_USER**          | *email*        | Username to login to Plex.tv (only needed once)                            |
| **PLEX_PASSWORD**      | *password*     | Password to login to Plex.tv (only needed once)                            |
| **PLEX_SSL**           | *0\|1*         | Boolean to connect to Plex server over SSL                                 |
| **MOVIE_TESTS**        | *0\|1*         | Boolean to conduct tests on movie library (optional)                       |
| **MOVIE_SECTION_KEY**  | *int*          | Integer of movie library (run `composer sections` to see list              |
| **MOVIE_ITEM_ID**      | *int*          | Integer key of a specific movie to pull metadata for                       |
| **MOVIE_SEARCH_QUERY** | *string*       | String query to search for in Movie library                                |
| **MOVIE_FILTER_QUERY** | *string*       | String query to filter for in Movie library (must be a 'title')            |
| **TV_TESTS**           | *0\|1*         | Boolean to conduct tests of TV library (optional)                          |
| **TV_SECTION_KEY**     | *int*          | Integer of TV library (run `composer sections` to see list)                |
| **TV_ITEM_ID**         | *int*          | Integer key of a specific TV show, season, or episode to pull metadata for |
| **TV_SEARCH_QUERY**    | *string*       | String query to search for in TV library                                   |
| **TV_FILTER_QUERY**    | *string*       | String query to filter for in TV library (must be 'title')                 |
| **MUSIC_TESTS**        | *0\|1*         | Boolean to conduct tests of Music library (optional)                       |
| **MUSIC_SECTION_KEY**  | *int*          | Integer of Music library (run `composer sections` to see list              |
| **MUSIC_SEARCH_QUERY** | *string*       | String query to search for in Music library                                |
| **MUSIC_FILTER_QUERY** | *string*       | String query to filter for in Music library                                |

The `PLEX_*` values are required. The username and password values can be deleted after the token is retrieved

`*_TESTS` are optional, if they are not present, those tests will not be run.  If they are present, then the similar ENV values are required.

Once you have the PLEX_* values present you can run `composer sections` to retrieve the section keys for your libraries.  Put in the section keys for the tests you want to run.  After you've made the changes, run `composer test` to run php tests
