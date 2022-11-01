# Album

The object to represent a music album

## Property List

| Data type | Property                | Description                                         |
| :-------- | :---------------------- | :-------------------------------------------------- |
| int       | ratingKey               |                                                     |
| int       | parentRatingKey         |                                                     |
| string    | key                     | The key to get the details of the album             |
| string    | parentKey               | The link back to the artist                         |
| string    | guid                    |                                                     |
| string    | parentGuid              |                                                     |
| string    | studio                  | The studio that produced the album                  |
| string    | type                    | The media type `album`                              |
| string    | title                   | The title of the album                              |
| string    | titleSort               | The title used in sorting the album in the UI       |
| string    | parentTitle             | The name of the parent artist                       |
| string    | summary                 |                                                     |
| string    | rating                  | User rating                                         |
| int       | index                   |                                                     |
| int       | viewCount               |                                                     |
| int       | skipCount               |                                                     |
| int       | year                    | The year the album was released                     |
| DateTime  | lastVeiwedAt            | Date/time the album was last played                 |
| DateTime  | originallyAvailableAt   | The date/time the album was released                |
| DateTime  | addedAt                 | Date/time the album was added to the library        |
| DateTime  | updatedAt               | Date/time the album database entry was last changed |
| string    | thumb                   | URL to thumbnail                                    |
| string    | parentThumb             | URL to artist thumbnail                             |
| int       | loudnessAnalysisVersion |                                                     |
| array     | directory               |                                                     |
| array     | genre                   | Genre's of music on the album                       |

## Function List

| Visibility    | Function (parameters,...): return                                                                                                        |
| :------------ | :--------------------------------------------------------------------------------------------------------------------------------------- |
| public        | <strong>__construct()</strong>: <em>void</em><br />                                                                                      |
| public        | <strong>__get(</strong><em>string</em> <strong>$var)</strong>: <em>mixed</em><br />Magic getter                                          |
| public        | <strong>__set(</strong><em>string</em> <strong>\$var</strong>, <em>mixed</em> <strong>$val)</strong>: <em>void</em><br />Magic setter    |
| public | <strong>getChildren()</strong>: <em>ItemCollection:Track</em><br />Method to retrieve collection of tracks on this album |
| public        | <strong>addTrack(</strong><em>Track</em> <strong>$a)</strong>: <em>void</em>                                                             |
| public static | <strong>fromLibrary(</strong><em>array</em> <strong>$library)</strong>: <em>Album</em><br />Create a Album from the Plex API call return |
