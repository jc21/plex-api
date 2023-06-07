# Show

A TV Show

## Property List

| Data type | Property | Description |
|:----------|:---------|:------------|
| int | ratingKey | The key of the show |
| string | key | The string to query the details of the show |
| string | guid | That GUID |
| string | studio | The studio that created the show |
| string | type | The type of the media (`show`) |
| string | title | The title of the show |
| string | titleSort | The string that is used to actually sort the show for display |
| int | episodeSort | An integer representing the way the episodes should be sorted |
| string | contentRating | The content rating (TV-G, TV-PG, etc)  |
| string | summary | The summary of the whole show |
| int | index | The index |
| string | audienceRating |  |
| int | viewCount | The number of times all episodes have been viewed |
| int | skipCount | The number of times an episode was skipped |
| `DateTime` | lastViewedAt | The date the last episode was viewed |
| `DateTime` | addedAt | The date the show was added to the library |
| `DateTime` | updatedAt | The date the show entry in the library was last updated |
| `DateTime` | originallyAvailableAt | The original air date of the first episode in the show |
| int | year | The original air year of the show |
| string | thumb | The show thumbnail |
| string | art | The show artwork |
| [Duration](Duration.md) | duration | The aired duration of each episode |
| int | leafCount | The number of episodes |
| int | viewedLeafCount | The number of viewed episodes |
| int | childCount | The number of child seasons in the show |
| string | audienceRatingImage |  |
| array:string | genre | The genres the show is in |
| array:string | role | The actor/actresses in the show |
| `ItemCollection`:`Season`(Season.md) | seasons | The array containing all the seasons |

## Function List

| Visibility | Function (parameters,...): return |
|:-----------|:---------|
| public | <strong>__construct()</strong>: <em>void</em><br /> |
| public | <strong>__get(</strong><em>string</em> <strong>$var)</strong>: <em>mixed</em><br />Magic getter |
| public | <strong>__set(</strong><em>string</em> <strong>$var</strong>, <em>mixed</em> <strong>$val)</strong>: <em>void</em><br />Magic setter |
| public | <strong>getChildren()</strong>: <em>array:Season</em><br />Method to get the seasons |
| public | <strong>addSeason(</strong><em>Season</em> <strong>$season)</strong>: <em>bool</em><br />Method to add a season to the show |
| public static | <strong>fromLibrary(</strong><em>array</em> <strong>$lib)</strong>: <em>Show</em><br />Method to create a show from the Plex API call |
