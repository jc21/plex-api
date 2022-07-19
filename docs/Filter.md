# Filter

This class is specifically intended to filter a library section, but could be used for other purposes.  Objects are `immutable` as there are no publicly available properties or setter methods.

## Function List

| Visibility | Function (parameters,...): return |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string</em> <strong>$field</strong>, <em>string</em> <strong>$value</strong>, <em>string</em> <strong>$operator = `'='`)</strong>: <em>void</em> |
| public | <strong>__toString()</strong>: <em>string</em><br />Convert the object to a string |

## Examples

The `field` parameter in the constructor can accept, `title`, `studio`, `year`, `rating`, `contentRating`.  Any other value will throw an `Exception`

Searching for *George of the Jungle*

```php
$filter1 = new Filter('title', 'George');
$filter2 = new Filter('year', 1997, ">=");
$res = $api->filter(1, [$filter1, $filter2], true);
// Returns any movie with George in the title and released in or after 1997
```