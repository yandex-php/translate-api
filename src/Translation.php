<?php

namespace Yandex\Translate;

/**
 * Translation
 * @author Nikita Gusakov <dev@nkt.me>
 */
class Translation
{
    /**
     * @var string
     */
    protected $source;
    /**
     * @var string
     */
    protected $result;

    /**
     * @var array
     */
    protected $language;

    /**
     * @param string $source   The source text
     * @param string $result   The translation result
     * @param string $language Translation language
     */
    public function __construct($source, $result, $language)
    {
        $this->source = $source;
        $this->result = $result;
        $this->language = explode('-', $language);
    }

    /**
     * @return string The source text
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string The source language.
     */
    public function getSourceLanguage()
    {
        return $this->language[0];
    }

    /**
     * @return string The translation language.
     */
    public function getResultLanguage()
    {
        return $this->language[1];
    }

    /**
     * @return string The translation text.
     */
    public function __toString()
    {
        return $this->result;
    }
} 
