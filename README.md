# PhpUts #
PHP Utilities

*Clone this repository into the 'vendor' directory with the following command:*

```
git clone https://github.com/digices-llc/phputs.git
```

###Crypt###

To encrypt a string, call:

```php
$encrypted_string = PhpUtsCrypt::encrypt($string_to_encrypt,$key_string);
```

To decrypt a string, call:

```php
$decrypted_string = PhpUtsCrypt::encrypt($string_to_encrypt,$key_string);
```

###CSV###

To encode an array into comma-separated values:

```php
$csv = PhpUtsCSV::encode($array);
```
*NOTE: Only values containing commas are quoted. If a single array of strings is passed, resulting CSV string will not be terminated with newline character. For the purposes of normalization, any escaped single-quotes are converted to non-escaped versions and unescaped newline characters or double-quotes are converted to escaped versions. Otherwise, escape-sequences are preserved.*

To decode comma-separated values into an array:

```php
$array = PhpUtsCSV::decode($csv);
```
*NOTE: Any escaped single or double quotes are normalized to non-escaped versions within array values. Otherwise, escape-sequences are preserved.*
