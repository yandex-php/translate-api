Yandex.Translate API
====================
[![Latest Stable Version](https://poser.pugx.org/yandex-php/translate-api/v/stable.svg)](https://packagist.org/packages/yandex-php/translate-api) [![Total Downloads](https://poser.pugx.org/yandex-php/translate-api/downloads.svg)](https://packagist.org/packages/yandex-php/translate-api) [![Latest Unstable Version](https://poser.pugx.org/yandex-php/translate-api/v/unstable.svg)](https://packagist.org/packages/yandex-php/translate-api) [![License](https://poser.pugx.org/yandex-php/translate-api/license.svg)](https://packagist.org/packages/yandex-php/translate-api)

[Api reference](http://api.yandex.com/translate/doc/dg/concepts/About.xml)

Versioning
----------

Package version corresponds to the version of the API.

Installation
------------

Add into your `composer.json`:

```json
{
  "require": {
    "yandex-php/translate-api": "~1.0"
  }
}
```

Usage
-----

[Get your own api key](http://api.yandex.com/key/form.xml?service=trnsl)

```php
use Yandex\Translate\Translator;
use Yandex\Translate\Exception;

try {
  $translator = new Translator($key);
  $translation = $translator->translate('Hello world', 'en-ru');

  echo $translation; // Привет мир

  echo $translation->getSource(); // Hello world;

  echo $translation->getSourceLanguage() // en
  echo $translation->getResultLanguage() // ru
} catch (Exception $e) {
  // handle exception
}
```

License
-------

MIT
