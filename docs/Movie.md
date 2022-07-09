# Movie 

The object to represent a movie

## Property List

| Data type | Property | Description |
|:----------|:---------|:------------|
| int | ratingKey | |
| string | key | The key to get details of the movie |
| string | guid | |
| string | studio | The movie studio that created the movie |
| string | type | The media type (`movie`) |
| string | title | The title of the movie |
| string | titleSort | The title used to sort the movie for display |
| string | contentRating | The content rating of the movie (G, PG, PG-13, etc) |
| string | summary | The summary of the movie |
| string | audienceRating | The audience rating of the movie | 
| int | viewCount | The number of times this movie has been viewed |
| `DateTime` | lastViewedAt | The last date and time this movie was watched |
| int | year | The year the movie was released |
| string | tagline | Any tagline for the movie |
| string | thumb | Movie thumbnail |
| string | art | Movie artwork |
| [Duration](Duration.md) | duration | The duration of the movie |
| `DateTime` | originallyAvilableAt | The date and time of movie was originally released |
| `DateTime` | addedAt | The date and time the movie was added to the library |
| `DateTime` | updatedAt | The date and time the movie entry in the library was updated |
| string | audienceRatingImage | |
| string | primaryExtraKey | |
| array:string | genre | The genres the movie falls into |
| array:string | director | The directors for the movie |
| array:string | writer | The movie writers |
| array:string | country | The counties the movie was filmed in |
| array:string | role | The actor/actresses in the movie |
| [Media](Media.md) | media | The media for the movie |

## Function List
| Visibility | Function (parameters,...): return |
|:-----------|:---------|
| public | <strong>__construct()</strong>: <em>void</em><br /> |
| public | <strong>__get(</strong><em>string</em> <strong>$var)</strong>: <em>mixed</em><br />Magic getter |
| public | <strong>__set(</strong><em>string</em> <strong>$var</strong>, <em>mixed</em> <strong>$val)</strong>: <em>void</em><br />Magic setter |
| public static | <strong>fromLibrary(</strong><em>array</em> <strong>$library)</strong>: <em>Movie</em><br />Create a movie from the Plex API call return |
