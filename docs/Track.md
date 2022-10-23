# Track

The object to represent a music track

## Property List

| Data type | Property             | Description                                       |
| :-------- | :------------------- | :------------------------------------------------ |
| int       | ratingKey            |                                                   |
| int       | parentRatingKey      |                                                   |
| int       | grandparentRatingKey |                                                   |
| string    | key                  | The key to get the track details                  |
| string    | parentKey            | The key to get the album details                  |
| string    | grandparentKey       | The key to get the artist details                 |
| string    | guid                 |                                                   |
| string    | parentGuid           |                                                   |
| string    | grandparentGuid      |                                                   |
| string    | type                 | The media type `track`                            |
| string    | title                | The track title                                   |
| string    | parentTitle          | The album title                                   |
| string    | grandparentTitle     | The artist name                                   |
| string    | parentStudio         | The publishing album studio                       |
| string    | summary              |                                                   |
| int       | index                |                                                   |
| int       | parentIndex          |                                                   |
| int       | ratingCount          |                                                   |
| int       | parentYear           | The release year                                  |
| string    | thumb                |                                                   |
| string    | parentThumb          |                                                   |
| string    | grandparentThumb     |                                                   |
| Duration  | duration             |                                                   |
| DateTime  | addedAt              | The date/time the track was added to the database |
| DateTime  | updatedAt            | The date/time of track was last updated           |
| Media     | media                | The details of the media file itself              |

## Function List

| Visibility    | Function (parameters,...): return                                                                                                        |
| :------------ | :--------------------------------------------------------------------------------------------------------------------------------------- |
| public        | <strong>__construct()</strong>: <em>void</em><br />                                                                                      |
| public        | <strong>__get(</strong><em>string</em> <strong>$var)</strong>: <em>mixed</em><br />Magic getter                                          |
| public        | <strong>__set(</strong><em>string</em> <strong>\$var</strong>, <em>mixed</em> <strong>$val)</strong>: <em>void</em><br />Magic setter    |
| public static | <strong>fromLibrary(</strong><em>array</em> <strong>$library)</strong>: <em>Album</em><br />Create a Album from the Plex API call return |
