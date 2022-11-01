# Artist

The object to represent a music artist

## Property List

| Data type | Property     | Description                                         |
| :-------- | :----------- | :-------------------------------------------------- |
| int       | ratingKey    |                                                     |
| string    | key          | The key to get the details of the artist            |
| string    | guid         |                                                     |
| string    | type         | The media type `artist`                             |
| string    | title        | The artist's name                                   |
| string    | summary      |                                                     |
| int       | index        |                                                     |
| int       | viewCount    | Number of times the artist details have been viewed |
| int       | skipCount    |                                                     |
| DateTime  | lastViewedAt | Date/time somebody viewed this artist               |
| DateTime  | addedAt      | Date/time this artist was added to the database     |
| DateTime  | updatedAt    | Date/time this artist's database entry was updated  |
| string    | thumb        | URL to thumbnail image                              |
| string    | art          |                                                     |
| array     | genre        | Genre's of music the artist has performed in        |
| array     | country      | Country's the albums were recorded in               |

## Function List
| Visibility    | Function (parameters,...): return                                                                                                          |
| :------------ | :----------------------------------------------------------------------------------------------------------------------------------------- |
| public        | <strong>__construct()</strong>: <em>void</em><br />                                                                                        |
| public        | <strong>__get(</strong><em>string</em> <strong>$var)</strong>: <em>mixed</em><br />Magic getter                                            |
| public        | <strong>__set(</strong><em>string</em> <strong>\$var</strong>, <em>mixed</em> <strong>$val)</strong>: <em>void</em><br />Magic setter      |
| public | <strong>getChildren()</strong>: <em>ItemCollection:Album</em><br />Method to retrieve all albums written by this artist |
| public        | <strong>addAlbum(</strong><em>Album</em> <strong>$a)</strong>: <em>void</em> |
| public static | <strong>fromLibrary(</strong><em>array</em> <strong>$library)</strong>: <em>Artist</em><br />Create a Artist from the Plex API call return |
