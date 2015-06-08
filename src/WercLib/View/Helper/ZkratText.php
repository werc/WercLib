<?php
namespace WercLib\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Zkrátí text na zadanou délku, výchozí 135
 *
 * @param string $text            
 * @return string
 */
class ZkratText extends AbstractHelper
{

    public function __invoke($text, $vychoziDelka = 135)
    {
        $text = filter_var($text, FILTER_SANITIZE_STRING);
        if (strlen($text) > $vychoziDelka) {
            $text60 = mb_substr($text, 0, $vychoziDelka, 'UTF-8');
            $second_part = mb_substr($text, $vychoziDelka, 30, 'UTF-8');
            $findfirstspace = strpos($second_part, " ");
            $text60andspace = $text60 . mb_substr($second_part, 0, $findfirstspace, 'UTF-8') . " ...";
            return $text60andspace;
        } else {
            return $text;
        }
    }
}