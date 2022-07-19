# Duration

The object is created to represent the duration of a media file.  The duration can then be output in `H:i:s` format

## Property List

| Data type | Property | Description |
|:----------|:---------|:------------|
| int | duration | The duration in milliseconds |

## Function List

| Visibility | Function (parameters,...): return |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>int</em> <strong>$duration)</strong>: <em>void</em><br /> |
| public | <strong>minutes()</strong>: <em>string</em><br />The duration represented in minutes |
| public | <strong>seconds()</strong>: <em>string</em><br />The duration represented in seconds |
| public | <strong>__toString()</strong>: <em>string</em><br />Auto convert the object to a string and output in `H:i:s` format |
| 

## Examples

```php
$dur = new Duration(20152000);
print $dur->seconds().PHP_EOL; // 20152
print $dur->minutes().PHP_EOL; // 335
print (string) $dur; // 05:35:52
```