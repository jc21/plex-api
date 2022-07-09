# Section

This class is intended to represent a library

## Property List

| Data type | Property | Description |
|:----------|:---------|:------------|
| bool | allowSync | Does this library allow sync/download |
| string | art | Library artwork |
| string | composite | |
| bool | filters | Are any filters assigned to the library |
| bool | refreshing | Should we refresh the metadata in the library |
| string | thumb | Library thumbnail |
| int | key | Library index |
| string | libraryType | What type of library is this (movie, show, photo, music) |
| string | type | What type of library is this (movie, show, photo, music) |
| string | title | Library title |
| string | agent | Library agent |
| string | scanner | Library scanner |
| string | language | Language the library is in |
| string | uuid | |
| `DateTime` | createdAt | Date and time the library was created |
| `DateTime` | updatedAt | Date/time the library was last updated |
| `DateTime` | scannedAt | Date/time the library was last scanned |
| int | content | |
| int | directory | |
| int | contentChangedAt | |
| bool | hidden | Is the library hidden |
| [Location](Location.md) | location | Location data for the library |

## Function List

| Visibility | Function (parameters,...): return |
|:-----------|:---------|
| public | <strong>__construct()</strong>: <em>void</em><br /> |
| public | <strong>__get(</strong><em>string</em> <strong>$var)</strong>: <em>mixed</em><br />Magic getter |
| public | <strong>__set(</strong><em>string</em> <strong>$var</strong>, <em>mixed</em> <strong>$val)</strong>: <em>void</em><br />Magic getter |
| public static | <strong>fromLibrary(</strong><em>array</em> <strong>$lib)</strong>: <em>Section</em><br />Create a Section of PlexApi call |
