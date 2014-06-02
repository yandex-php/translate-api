Yandex Translate API
====================
[![Latest Stable Version](https://poser.pugx.org/nkt/yandex-translate/v/stable.svg)](https://packagist.org/packages/nkt/yandex-translate) [![Total Downloads](https://poser.pugx.org/nkt/yandex-translate/downloads.svg)](https://packagist.org/packages/nkt/yandex-translate) [![Latest Unstable Version](https://poser.pugx.org/nkt/yandex-translate/v/unstable.svg)](https://packagist.org/packages/nkt/yandex-translate) [![License](https://poser.pugx.org/nkt/yandex-translate/license.svg)](https://packagist.org/packages/nkt/yandex-translate)

[Api reference](http://api.yandex.com/translate/doc/dg/concepts/About.xml)

Usage
-----

Add into your `composer.json`:

```json
{
  "require": {
    "nkt/yandex-translate": "~1.0"
  }
}
```

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
