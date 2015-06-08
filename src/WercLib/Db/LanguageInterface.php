<?php
namespace WercLib\Db;

interface LanguageInterface
{

    /**
     * Gets the language
     *
     * @return string
     */
    public function getLanguage();

    /**
     * Sets the language
     *
     * @param string $language            
     */
    public function setLanguage($language);
}
