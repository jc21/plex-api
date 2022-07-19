# Episode

This class stores TV Episode data

## Property List

| Data type | Property | Description |
|:----------|:---------|:------------|
| int | ratingKey | An index |
| int | parentRatingKey | The index for the parent season |
| int | grandparentRatingKey | The index for the grandparent show |
| string | key | A string that can be used to query the object directly |
| string | parentKey | A string that can be used to query the parent season |
| string | grandparentKey | A string to query the grandparent show |
| string | guid | The GUID | 
| string | parentGuid | The parent season GUID |
| string | grandparentGuid | The grandparent show GUID |
| string | type | What type of media is this (`episode`) |
| string | title | The title of the episode |
| string | parentTitle | The title of the season |
| string | grandparentTitle | The title of the show |
| string | contentRating | The content rating of the episode (e.g. TV-G, TV-PG, etc) |
| string | summary | The summary of the episode |
| int | index | |
| int | parentIndex | |
| string | audienceRating | The audience rating |
| string | audienceRatingImage | |
| int | viewCount | The number of times this episode has been viewed |
| string | thumb | The thumbnail image |
| string | parentThumb | The parent season thumbnail image |
| string | grandparentThumb | The grandparent show thumbnail image |
| string | art | The background artwork |
| string | grandparentArt | The shows artwork |
| [Duration](Duration.md) | duration | The duration |
| `DateTime` | lastViewedAt | The last date and time the episode was viewed |
| `DateTime` | originallyAvailableAt | The original air date of the episode |
| `DateTime` | addedAt | The date the episode was added to the library |
| `DateTime` | updatedAt | The date the episode's entry in the library was updated |
| [Media](Media.md) | media | The details of the media |

## Function List

| Visibility | Function (parameters,...): return |
|:-----------|:---------|
| public | <strong>__construct()</strong>: <em>void</em> |
| public | <strong>__get(</strong><em>string</em> <strong>$var)</strong>: <em>mixed</em><br />Magic getter |
| public | <strong>__set(</strong><em>string</em> <strong>$var</strong>, <em>mixed</em> <strong>$val)</strong>: <em>void</em><br />Magic setter |
| public static | <strong>fromLibrary(</strong><em>array</em> <strong>$lib)</strong>: <em>Episode</em><br />Create an object from the array data from the PlexApi |