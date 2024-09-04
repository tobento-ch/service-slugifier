# Slugifier Service

The slugifier service provides interfaces to convert a string into a slug with a default implementation.

## Table of Contents

- [Getting started](#getting-started)
    - [Requirements](#requirements)
    - [Highlights](#highlights)
- [Documentation](#documentation)
    - [Basic Usage](#basic-usage)
        - [Creating Slugifier](#creating-slugifier)
        - [Creating Custom Slugifier](#creating-custom-slugifier)
        - [Generating Slugs](#generating-slugs)
    - [Available Modifiers](#available-modifiers)
        - [Alpha Num Only Modifier](#alpha-num-only-modifier)
        - [Limit Length Modifier](#limit-length-modifier)
        - [Lowercase Modifier](#lowercase-modifier)
        - [Modify Modifier](#modify-modifier)
        - [Prevent Dublicate Modifier](#prevent-dublicate-modifier)
        - [Regex Modifier](#regex-modifier)
        - [Replace Modifier](#replace-modifier)
        - [Strip Tags Modifier](#strip-tags-modifier)
        - [Trim Modifier](#trim-modifier)
        - [Dictionaries](#dictionaries)
            - [English Dictionary Modifier](#english-dictionary-modifier)
            - [French Dictionary Modifier](#french-dictionary-modifier)
            - [German Dictionary Modifier](#german-dictionary-modifier)
            - [Italian Dictionary Modifier](#italian-dictionary-modifier)
            - [Latin Dictionary Modifier](#latin-dictionary-modifier)
    - [Custom Modifier](#custom-modifier)
    - [Slugs](#slugs)
        - [Available Resources](#available-resources)
            - [Array Resource](#array-resource)
        - [Custom Resource](#custom-resource)
    - [Slugifiers](#slugifiers)
- [Credits](#credits)
___

# Getting started

Add the latest version of the Slugifier service project running this command.

```
composer require tobento/service-slugifier
```

## Requirements

- PHP 8.0 or greater

## Highlights

- Framework-agnostic, will work with any project
- Decoupled design
- Creating custom slugifier to fit your requirements

# Documentation

## Basic Usage

### Creating Slugifier

You may use the ```SlugifierFactory``` to easily create a slugifier.

```php
use Tobento\Service\Slugifier\SlugifierFactory;
use Tobento\Service\Slugifier\SlugifierInterface;

$slugifier = (new SlugifierFactory())->createSlugifier();

var_dump($slugifier instanceof SlugifierInterface);
// bool(true)
```

### Creating Custom Slugifier

You may use the ```Slugifier``` class to build a custom slugifier by using the [Available Modifiers](#available-modifiers).

```php
use Tobento\Service\Slugifier\Modifier;
use Tobento\Service\Slugifier\Modifiers;
use Tobento\Service\Slugifier\Slugifier;
use Tobento\Service\Slugifier\SlugifierInterface;

$slugifier = new Slugifier(
    modifiers: new Modifiers(
        new Modifier\StripTags(),

        // locale specific dictionaries:
        new Modifier\Dictionary\English(),
        new Modifier\Dictionary\German(),
        new Modifier\Dictionary\French(),
        new Modifier\Dictionary\Italian(),
        // supports all locales, acts as a fallback:
        new Modifier\Dictionary\Latin(),

        new Modifier\Lowercase(),
        new Modifier\Trim(),
        new Modifier\AlphaNumOnly(separator: '-'),
        new Modifier\Trim('-'),
        
        // removes repeated separators like -- to -:
        new Modifier\Regex(pattern: '#-+#', separator: '-'),
        
        new Modifier\LimitLength(250),
    )
);

var_dump($slugifier instanceof SlugifierInterface);
// bool(true)
```

### Generating Slugs

Use the ```slugify``` method to generate a slug from the given string.

```php
$slug = $slugifier->slugify('Hello World!');
var_dump($slug);
// string(11) "hello-world"
```

## Available Modifiers

### Alpha Num Only Modifier

This modifier replaces non-alpha-num characters with the defined ```separator```.

```php
use Tobento\Service\Slugifier\Modifier\AlphaNumOnly;

$modifier = new AlphaNumOnly(
    separator: '-', // default
);

$string = $modifier->modify(
    string: 'lorem ipsum!',
    locale: 'en'
);

var_dump($string);
// string(12) "lorem-ipsum-"
```

### Limit Length Modifier

This modifier limits a string to the defined ```length```.

```php
use Tobento\Service\Slugifier\Modifier\LimitLength;

$modifier = new LimitLength(
    length: 10, // default 255
);

$string = $modifier->modify(
    string: 'Some very long string ...',
    locale: 'en'
);

var_dump($string);
// string(10) "Some very "
```

### Lowercase Modifier

This modifier make a string lowercase.

```php
use Tobento\Service\Slugifier\Modifier\Lowercase;

$modifier = new Lowercase(
    // you may change the encoding:
    encoding: null, // 'UTF-8'
);

$string = $modifier->modify(
    string: 'Lorem Ipsum',
    locale: 'en'
);

var_dump($string);
// string(11) "lorem ipsum"
```

### Modify Modifier

Use this modifier to create a custom modifier using a ```callable```.

```php
use Tobento\Service\Slugifier\Modifier\Modify;

$modifier = new Modify(
    modifier: fn (string $string, string $locale): string => strtoupper($string),
    
    // you may set the supported locales:
    supportedLocales: ['de', 'de-CH'],
    
    // or you may use an asterisk as a wildcard:
    // supportedLocales: ['de*', 'fr*'],
    
    // or empty all supported (default):
    // supportedLocales: [],
);

$string = $modifier->modify(
    string: 'Lorem Ipsum',
    locale: 'de'
);

var_dump($string);
// string(11) "LOREM IPSUM"
```

### Prevent Dublicate Modifier

This modifier prevents dublicate slugs. This modifier should be added last!

```php
use Tobento\Service\Slugifier\Modifier\PreventDublicate;
use Tobento\Service\Slugifier\Resource;
use Tobento\Service\Slugifier\Slugs;

$modifier = new PreventDublicate(
    slugs: new Slugs(
        new Resource\ArrayResource(['login', 'register']),
    ),
    
    // you may change the separator:
    separator: '-', // default
);

$string = $modifier->modify(
    string: 'login',
    locale: 'en'
);

var_dump($string);
// string(7) "login-1"
```

You may check out the [Slugs](#slugs) section to learn more about it.

### Regex Modifier

Use this modifier to modify the given string using the defined ```pattern```.

```php
use Tobento\Service\Slugifier\Modifier\Regex;

$modifier = new Regex(
    pattern: '#-+#',
    
    // you may change the separator:
    separator: '-', // default
    
    // you may set the supported locales:
    supportedLocales: ['de', 'de-CH'],
    
    // or you may use an asterisk as a wildcard:
    // supportedLocales: ['de*', 'fr*'],
    
    // or empty all supported (default):
    // supportedLocales: [],
);

$string = $modifier->modify(
    string: 'Lorem--Ipsum',
    locale: 'de'
);

var_dump($string);
// string(11) "Lorem-Ipsum"
```

### Replace Modifier

This modifier replaces the defined ```replace``` list from the given string.

```php
use Tobento\Service\Slugifier\Modifier\Replace;

$modifier = new Replace(
    replace: ['ö' => 'oe'],
    
    // you may set the supported locales:
    supportedLocales: ['de', 'de-CH'],
    
    // or you may use an asterisk as a wildcard:
    // supportedLocales: ['de*', 'fr*'],
    
    // or empty all supported (default):
    // supportedLocales: [],
);

$string = $modifier->modify(
    string: 'schönes Wetter',
    locale: 'de'
);

var_dump($string);
// string(15) "schoenes Wetter"
```

### Strip Tags Modifier

This modifier strip tags from the given string.

```php
use Tobento\Service\Slugifier\Modifier\StripTags;

$modifier = new StripTags();

$string = $modifier->modify(
    string: '<p>lorem ipsum</p>',
    locale: 'en'
);

var_dump($string);
// string(11) "lorem ipsum"
```

### Trim Modifier

This modifier strip tags from the given string.

```php
use Tobento\Service\Slugifier\Modifier\Trim;

$modifier = new Trim(
    // you may set the characters to trim:
    chars: '-', // default null
);

$string = $modifier->modify(
    string: '-lorem ipsum-',
    locale: 'en'
);

var_dump($string);
// string(11) "lorem ipsum"
```

### Dictionaries

#### English Dictionary Modifier

This modifier uses the english dictionary for replacements on locales starting with ```en```.

```php
use Tobento\Service\Slugifier\Modifier\Dictionary\English;

$modifier = new English(
    // you may set whether to use the words dictionary:
    withWords: true, // default
    
    // you may change the words separator:
    separator: '', // '-' is default
);

$string = $modifier->modify(
    string: 'Blue & green',
    locale: 'en'
);

var_dump($string);
// string(14) "Blue and green"
```

#### French Dictionary Modifier

This modifier uses the french dictionary for replacements on locales starting with ```fr```.

```php
use Tobento\Service\Slugifier\Modifier\Dictionary\French;

$modifier = new French(
    // you may set whether to use the words dictionary:
    withWords: true, // default
    
    // you may change the words separator:
    separator: '', // '-' is default
);

$string = $modifier->modify(
    string: 'Bleu & vert',
    locale: 'fr'
);

var_dump($string);
// string(14) "Bleu et vert"
```

#### German Dictionary Modifier

This modifier uses the german dictionary for replacements on locales starting with ```de```.

```php
use Tobento\Service\Slugifier\Modifier\Dictionary\German;

$modifier = new German(
    // you may set whether to use the words dictionary:
    withWords: true, // default
    
    // you may change the words separator:
    separator: '', // '-' is default
);

$string = $modifier->modify(
    string: 'Blau & grün',
    locale: 'de'
);

var_dump($string);
// string(14) "Blau und gruen"
```

#### Italian Dictionary Modifier

This modifier uses the italian dictionary for replacements on locales starting with ```it```.

```php
use Tobento\Service\Slugifier\Modifier\Dictionary\Italian;

$modifier = new Italian(
    // you may set whether to use the words dictionary:
    withWords: true, // default
    
    // you may change the words separator:
    separator: '', // '-' is default
);

$string = $modifier->modify(
    string: 'Blu & verde',
    locale: 'it'
);

var_dump($string);
// string(11) "Blu e verde"
```

#### Latin Dictionary Modifier

This modifier uses the latin dictionary for replacements on all locales.

```php
use Tobento\Service\Slugifier\Modifier\Dictionary\Latin;

$modifier = new Latin();

$string = $modifier->modify(
    string: 'Blau & grün',
    locale: 'en'
);

var_dump($string);
// string(12) "Blau & gruen"
```

## Custom Modifier

You may create a custom modifier by implementing the ```ModifierInterface```:

```php
use Tobento\Service\Slugifier\ModifierInterface;

class CustomModifier implements ModifierInterface
{
    /**
     * Returns the modified string.
     *
     * @param string $string
     * @param string $locale
     * @return string The modified string
     */
    public function modify(string $string, string $locale): string
    {
        // do any modification:
        return $string;
    }
}
```

## Slugs

You may use the ```Slugs``` class to check if a slug exists to prevent dublicate slugs.

```php
use Tobento\Service\Slugifier\Resource;
use Tobento\Service\Slugifier\Slugs;
use Tobento\Service\Slugifier\SlugsInterface;

$slugs = new Slugs(
    new Resource\ArrayResource(['login', 'register']),
);

var_dump($slugs instanceof SlugsInterface);
// bool(true)
```

**addResource**

You may use the ```addResource``` method to add resources.

```php
use Tobento\Service\Slugifier\Resource;
use Tobento\Service\Slugifier\Slugs;

$slugs = new Slugs();
$slugs->addResource(new Resource\ArrayResource(['login', 'register']));
```

**exists**

Use the ```exists``` method to check whether a slug exists or not.

```php
use Tobento\Service\Slugifier\Resource;
use Tobento\Service\Slugifier\Slugs;

$slugs = new Slugs(
    new Resource\ArrayResource(['login', 'register'], ['en']),
);

var_dump($slugs->exists(slug: 'login', locale: 'en'));
// bool(true)

var_dump($slugs->exists(slug: 'login', locale: 'de'));
// bool(false)
```

**findSlug**

Use the ```findSlug``` method which returns a single slug by the specified parameters or null if not found.

```php
use Tobento\Service\Slugifier\Resource;
use Tobento\Service\Slugifier\Slugs;
use Tobento\Service\Slugifier\SlugInterface;

$slugs = new Slugs(
    new Resource\ArrayResource(['login', 'register'], ['en']),
);

$slug = $slugs->findSlug(slug: 'login', locale: 'en');
var_dump($slug instanceof SlugInterface);
// bool(true)

var_dump($slug->slug());
// string(5) "login"

var_dump($slug->locale());
// string(2) "en"

var_dump($slug->resourceKey());
// NULL or string

var_dump($slug->resourceId());
// NULL or string|int

var_dump($slugs->findSlug(slug: 'login', locale: 'de'));
// NULL
```

### Available Resources

#### Array Resource

```php
use Tobento\Service\Slugifier\Resource\ArrayResource;
use Tobento\Service\Slugifier\SlugInterface;

$resource = new ArrayResource(
    slugs: ['login', 'register'],
    
    // you may set the supported locales:
    supportedLocales: ['en', 'en-GB'],
    
    // or you may use an asterisk as a wildcard:
    // supportedLocales: ['en*'],
    
    // or empty all supported (default):
    // supportedLocales: [],
    
    // you may set a resource key:
    key: 'routes',
    
    // you may change the priority (highest first):
    priority: 1500, // 1000 is default
);

var_dump($resource->slugExists(slug: 'login', locale: 'en'));
// bool(true)

$slug = $resource->findSlug(slug: 'login', locale: 'en');
var_dump($slug instanceof SlugInterface);
// bool(true)
```

#### Custom Resource

You may create a custom resource by implementing the ```ResourceInterface```:

```php
use Tobento\Service\Slugifier\ResourceInterface;
use Tobento\Service\Slugifier\Slug;
use Tobento\Service\Slugifier\SlugInterface;

class BlogResource implements ResourceInterface
{
    public function __construct(
        protected BlogRepositoryInterface $blogRepository
    ) {}
    
    /**
     * Returns true if the given slug exists, otherwise false.
     *
     * @param string $slug
     * @param string $locale
     * @return bool
     */
    public function slugExists(string $slug, string $locale = 'en'): bool
    {
        return $this->blogRepository->hasSlug($slug, $locale);
    }
    
    /**
     * Returns a single slug by the specified parameters or null if not found.
     *
     * @param string $slug
     * @param string $locale
     * @return null|SlugInterface
     */
    public function findSlug(string $slug, string $locale = 'en'): null|SlugInterface
    {
        $blog = $this->blogRepository->findBySlug($slug, $locale);
        
        if (is_null($blog)) {
            return null;
        }
        
        return new Slug(
            slug: $slug,
            locale: $locale,
            resourceKey: $this->key(),
            resourceId: $blog->id(),
        );
    }
    
    /**
     * Returns the key.
     *
     * @return null|string
     */
    public function key(): null|string
    {
        return 'blog';
    }
    
    /**
     * Returns the priority.
     *
     * @return int
     */
    public function priority(): int
    {
        return 100;
    }
}
```

## Slugifiers

You may use the ```Slugifiers``` class to add multiple slugifiers for later usage.

```php
use Tobento\Service\Slugifier\SlugifierFactory;
use Tobento\Service\Slugifier\SlugifierFactoryInterface;
use Tobento\Service\Slugifier\SlugifierInterface;
use Tobento\Service\Slugifier\Slugifiers;
use Tobento\Service\Slugifier\SlugifiersInterface;

$slugifiers = new Slugifiers([
    'default' => new SlugifierFactory(), // SlugifierFactoryInterface|SlugifierInterface
]);

var_dump($slugifiers instanceof SlugifiersInterface);
// bool(true)
```

**add**

You may prefer the ```add``` method to add a slugifier.

```php
use Tobento\Service\Slugifier\SlugifierFactory;
use Tobento\Service\Slugifier\SlugifierFactoryInterface;
use Tobento\Service\Slugifier\SlugifierInterface;

$slugifiers->add(
    name: 'foo',
    slugifier: new SlugifierFactory(), // SlugifierFactoryInterface|SlugifierInterface
);
```

**has**

Use the ```has``` method to check whether a slugifier exists or not.

```php
var_dump($slugifiers->has(name: 'foo'));
// bool(false)
```

**get**

Use the ```get``` method to get a slugifier. If the slugifier does not exist a fallback slugifier is returned.

```php
use Tobento\Service\Slugifier\SlugifierInterface;

$slugifier = $slugifiers->get(name: 'foo');

var_dump($slugifier instanceof SlugifierInterface);
// bool(true)
```

**names**

The ```names``` method returns all slugifier names.

```php
var_dump($slugifiers->names());
// array(2) { [0]=> string(7) "default" [1]=> string(3) "foo" }
```


# Credits

- [Tobias Strub](https://www.tobento.ch)
- [All Contributors](../../contributors)