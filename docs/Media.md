# Media

This object is created for each media file

## Property List

| Data type | Property | Description |
|:----------|:---------|:------------|
| int | id | |
| [Duration](Duration.md) | duration | The duration of the media |
| int | bitrate | The total bitrate |
| int | width | The pixel width of the video |
| int | height | The pixel heigh of the video |
| float | aspectRatio | The aspect ratio (1.6, 1.77, 2.35, etc) |
| int | audioChannels | The number of audio channels |
| string | audioCodec | The audio codec used (mp3, aac, etc) |
| string | videoCodec | The video codec used (hvec, h264, etc) |
| string | videoResolution | The resolution (720, 1080, 4k, etc) |
| string | videoFrameRate | The frame rate |
| bool | optomizedForStreaming |  |
| string | audioProfile | The audio profile info |
| bool | has64bitOffsets |  |
| string | videoProfile | The video profile info |
| string | title | The title of the media |
| [Size](Size.md) | size | The size of the file |
| string | path | The path of the file |

## Function List

| Visibility | Function (parameters,...): return |
|:-----------|:---------|
| public | <strong>__get(</strong><em>string</em> <strong>$var)</strong>: <em>mixed</em><br />Magic getter |
| public | <strong>__set(</strong><em>string</em> <strong>$var</strong>, <em>mixed</em><strong>$val)</strong>: <em>void</em><br />Magic setter |
| public static | <strong>fromLibrary(</strong><em>array</em> <strong>$lib)</strong>: <em>Media</em><br />Method to create Media object from Plex API call |