<?php

namespace Yandex;

/**
 * Translate
 * @author Gusakov Nikita <dev@nkt.me>
 * @link   http://api.yandex.com/translate/doc/dg/reference/translate.xml
 */
class Translate
{
    const BASE_URL = 'https://translate.yandex.net/api/v1.5/tr.json/';
    /**
     * @var string
     */
    protected $key;

    /**
     * @var resource
     */
    protected $handler;

    /**
     * @link http://api.yandex.com/key/keyslist.xml Get a free API key on this page.
     *
     * @param string $key The API key
     */
    public function __construct($key)
    {
        $this->key = $key;
        $this->handler = curl_init();
        curl_setopt($this->handler, CURLOPT_RETURNTRANSFER, true);
    }

    /**
     * Returns a list of translation directions supported by the service.
     *
     * @param string $culture If set, the service's response will contain
     *                        a list of language codes and corresponding names of languages:
     *                        en - in English
     *                        ru - in Russian
     *                        tr - in Turkish
     *                        uk - in Ukrainian
     *
     * @return array
     */
    public function getSupportedLanguages($culture = null)
    {
        return $this->execute('getLangs', array(
            'ui' => $culture
        ));
    }

    /**
     * Detects the language of the specified text.
     * @link http://api.yandex.com/translate/doc/dg/reference/detect.xml
     *
     * @param string $text The text to detect the language for.
     *
     * @return array
     */
    public function detect($text)
    {
        return $this->execute('detect', array(
            'text' => $text
        ));
    }

    /**
     * Translates the text.
     * @link http://api.yandex.com/translate/doc/dg/reference/translate.xml
     *
     * @param string $text     The text to be translated.
     * @param string $language Translation direction (for example, "en-ru" or "ru").
     * @param bool   $html     Text format, if true - html, otherwise plain.
     * @param int    $options  Translation options.
     *
     * @return array
     */
    public function translate($text, $language, $html = false, $options = 1)
    {
        return $this->execute('translate', array(
            'text'   => $text,
            'lang'   => $language,
            'format' => $html ? 'html' : 'plain'
        ));
    }

    /**
     * @param string $uri
     * @param array  $parameters
     *
     * @return array
     */
    protected function execute($uri, array $parameters)
    {
        $parameters['key'] = $this->key;
        $url = static::BASE_URL . $uri . '?' . http_build_query($parameters);
        curl_setopt($this->handler, CURLOPT_URL, $url);

        return json_decode(curl_exec($this->handler));
    }
}
