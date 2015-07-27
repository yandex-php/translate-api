<?php

namespace Yandex\Translate;

/**
 * Translate
 * @author Nikita Gusakov <dev@nkt.me>
 * @link   http://api.yandex.com/translate/doc/dg/reference/translate.xml
 */
class Translator
{
    const BASE_URL = 'https://translate.yandex.net/api/v1.5/tr.json/';
    const MESSAGE_UNKNOWN_ERROR = 'Unknown error';
    const MESSAGE_JSON_ERROR = 'JSON parse error';
    const MESSAGE_INVALID_RESPONSE = 'Invalid response from service';

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
     * @link http://api.yandex.com/translate/doc/dg/reference/getLangs.xml
     *
     * @param string $culture If set, the service's response will contain a list of language codes
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
     * @return string
     */
    public function detect($text)
    {
        $data = $this->execute('detect', array(
            'text' => $text
        ));

        return $data['lang'];
    }

    /**
     * Translates the text.
     * @link http://api.yandex.com/translate/doc/dg/reference/translate.xml
     *
     * @param string|array $text     The text to be translated.
     * @param string       $language Translation direction (for example, "en-ru" or "ru").
     * @param bool         $html     Text format, if true - html, otherwise plain.
     * @param int          $options  Translation options.
     *
     * @return array
     */
    public function translate($text, $language, $html = false, $options = 0)
    {
        $data = $this->execute('translate', array(
            'text'    => $text,
            'lang'    => $language,
            'format'  => $html ? 'html' : 'plain',
            'options' => $options
        ));

        // @TODO: handle source language detecting
        return new Translation($text, $data['text'], $data['lang']);
    }

    /**
     * @param string $uri
     * @param array  $parameters
     *
     * @throws Exception
     * @return array
     */
    protected function execute($uri, array $parameters)
    {
        $parameters['key'] = $this->key;
        $url = static::BASE_URL . $uri . '?' . http_build_query($parameters);
        curl_setopt($this->handler, CURLOPT_URL, $url);
        
        $remoteResult = curl_exec($this->handler);
        if ($remoteResult === false) {
            throw new Exception(curl_error($this->handler), curl_errno($this->handler));
        }

        $result = json_decode($remoteResult, true);
        if (!$result) {
            $errorMessage = self::MESSAGE_UNKNOWN_ERROR;
            if (version_compare(PHP_VERSION, '5.3', '>=')) {
                if (json_last_error() !== JSON_ERROR_NONE) {
                    if (version_compare(PHP_VERSION, '5.5', '>=')) {
                        $errorMessage = json_last_error_msg();
                    } else {
                        $errorMessage = self::MESSAGE_JSON_ERROR;
                    }
                }
            }
            throw new Exception(sprintf('%s: %s', self::MESSAGE_INVALID_RESPONSE, $errorMessage));
        } elseif (isset($result['code']) && $result['code'] > 200) {
            throw new Exception($result['message'], $result['code']);
        }

        return $result;
    }
}
