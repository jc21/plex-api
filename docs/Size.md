# Size

This represents the size of a media file (in bytes)

## Property List
| Data type | Property | Description |
|:----------|:---------|:------------|
| int | size | The size, in bytes, of whatever is being checked |

## Function List
| Visibility | Function (parameters,...): return |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>int</em> <strong>$size)</strong>: <em>void</em><br /> |
| public | <strong>GB()</strong>: <em>string</em><br />Convert the size to a GB formatted string |
| public | <strong>MB()</strong>: <em>string</em><br />Convert the size to a MB formatted string |
| public | <strong>KB()</strong>: <em>string</em><br />Convert the size to a KB formatted string |
| public | <strong>bytes()</strong>: <em>int</em><br />Return the size

## Examples

```php
$size = new Size(1894113877);
print $size->GB().PHP_EOL;  // 1.764 gb
print $size->MB().PHP_EOL;  // 1,806.368 mb
print $size->KB();          // 1,849,720.583 kb
```
