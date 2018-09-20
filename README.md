# String builder
[![Build Status](https://travis-ci.org/Greg0/string-builder.svg?branch=master)](https://travis-ci.org/Greg0/string-builder)
[![Current Version](https://img.shields.io/packagist/v/greg0/string-builder.svg)](https://packagist.org/packages/greg0/string-builder#latest)
![PHP Version](https://img.shields.io/packagist/php-v/greg0/string-builder.svg)

Simple PHP string builder inspired by C# [StringBuilder](https://docs.microsoft.com/pl-pl/dotnet/api/system.text.stringbuilder)

## Install

`composer require greg0/string-builder`

## Sample usages

Creating string

```php
$sb = new StringBuilder('Initial string');
$sb->append(' appended string');
$sb->appendLine();
$sb->appendLine('Other paragraph');
$sb->appendFormat('%s: %d', 'Value', 23);
$sb->appendLine();
$sb->append('End of poem.');

echo $sb->toString(); // echo (string)$sb;
```

Result:
```text
Initial string appended string
Other paragraph
Value: 23
End of poem.
```

There are provided some string manipulation methods:

#### Insert string into position:
```php
$sb = new StringBuilder('---[]---');
$sb->insert(4, 'o.o');

echo $sb->toString(); // ---[o.o]---
```

```php
$sb = new StringBuilder('---[]---');
$sb->insert(4, 'o', 2);

echo $sb->toString(); // ---[oo]---
```

#### Removes the specified range of characters

```php
$sb = new StringBuilder('Lorem ipsum dolor sit amet.');
$sb->remove(6, 5); // remove "ipsum"
echo $sb->toString(); // Lorem  dolor sit amet.
```


#### Replaces all occurrences of a specified string with another specified string

```php
$sb = new StringBuilder('Lorem ipsum dolor sit amet.');
$sb->replace('ipsum', 'lirum');
echo $sb->toString(); // Lorem lirum dolor sit amet.
```

#### Clear string

```php
$sb = new StringBuilder('Lorem ipsum dolor sit amet.');
$sb->clear();
echo $sb->toString(); // will return empty string
```

More examples provided in unit tests.

## TODO

- [ ] Encoding support
- [ ] More test cases
- [ ] Advanced "Format" method (see [StringBuilder.AppendFormat](https://docs.microsoft.com/pl-pl/dotnet/api/system.text.stringbuilder.appendformat))
- [ ] Many different interface implementations (e.g. Streams)
