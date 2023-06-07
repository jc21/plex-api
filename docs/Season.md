# Season

This represents a single season within a show

## Property List

| Data type | Property | Description |
|:----------|:---------|:------------|
| int | ratingKey | The key index for the season |
| int | parentRatingKey | The key index of the show |
| string | key | The key for the season (used to get the details and children) |
| string | parentKey | The key for the parent show |
| string | guid | The guid for the season |
| string | parentGuid | The GUID of the parent show |
| string | type | The type of the media (`season`) |
| string | title | The title of the season |
| string | parentTitle | The title of the parent show |
| string | summary | Th sumary of the season |
| string | index | The index for the season |
| int | parentYear | The year the parent show was released |
| string | thumb | The thumbnail for this season |
| string | art | The artwork for the season |
| string | parentThumb | The thumbnail of the parent |
| string | parentTheme | The theme of the parent |
| int | leafCount | The number of episodes in this season |
| int | viewedLeafCount | The number of times an episode in this season was viewed |
| `DateTime` | addedAt | The date and time this season was added to the library |
| `DateTime` | updatedAt | The date and time this season was last updated in the library |
| `ItemCollection`:`Episode`(Episode.md) | episodes | An array to store all the episodes in this season |

## Function List

| Visibility | Function (parameters,...): return |
|:-----------|:---------|
| public | <strong>__construct()</strong>: <em>void</em><br /> |
| public | <strong>__get(</strong><em>string</em> <strong>$var)</strong>: <em>mixed</em><br />Magic getter |
| public | <strong>__set(</strong><em>string</em> <strong>$var</strong>, <em>mixed</em> <strong>$val)</strong>: <em>void</em><br />Magic setter |
| public | <strong>getChildren()</strong>: <em>ItemCollection:Episodes</em><br />Method to get all episodes within this season |
| public | <strong>addEpisode(</strong><em>Episode</em> <strong>$episode)</strong>: <em>void</em><br />Method to add an episode to the season |
| public static | <strong>fromLibrary(</strong><em>array</em> <strong>$lib)</strong>: <em>Season</em><br />Method to create a season |
