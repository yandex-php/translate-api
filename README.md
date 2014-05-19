Yandex Translate API
====================

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
