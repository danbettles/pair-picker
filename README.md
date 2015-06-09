# Pair Picker

Pair Picker is a basic library for calculating possible pairings of people in a group.  

Originally, it was built to calculate all the *unique* combinations of pairings of people in a group.

Under the bonnet, you'll find a simple recursive algorithm does the picking.  

It really is nothing special: it was built only as a little exercise.

## Examples

Given the following array of names...

```php
[
    'foo', 
    'bar', 
    'baz',
    'qux',
]
```

...`PairPicker::createUniqueCombinations()` will return the following combinations of pairings.

```php
[
    [['foo', 'bar'], ['baz', 'qux']],
    [['foo', 'baz'], ['bar', 'qux']],
    [['foo', 'qux'], ['bar', 'baz']],
]
```

`PairPicker::createUniqueCombinations()` will cope with an odd number of people.  The following array of names...

```php
[
    'foo', 
    'bar', 
    'baz',
]
```

...Will yield the following combinations of pairings.

```php
[
    [['foo', 'bar'], ['baz', null]],
    [['foo', 'baz'], ['bar', null]],
    [['foo', null], ['bar', 'baz']],
]
```