<?php
namespace WercLib\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Rewrite extends AbstractHelper
{

    /**
     * Vraci retezec pro url tvar
     * 
     * @param string $string
     * @return string
     */
    public function __invoke ($string)
    {
        //setlocale(LC_ALL, 'en_US.UTF8');
        $replace = array(
            "ě", 
            "š", 
            "č", 
            "ř", 
            "ž", 
            "ý", 
            "á", 
            "í", 
            "é", 
            "ú", 
            "ů", 
            "ť", 
            "ď", 
            "ó", 
            "ň", 
            "Ý", 
            "Ú", 
            "&", 
            "„", 
            "“", 
            "!", 
            "Š", 
            "Č", 
            "Ř", 
            "Í", 
            "Ž", 
            "ö", 
            "ć", 
            "Ć", 
            "ä", 
            "ü", 
            "Ö",
            "ô",
            "ľ",
            "ł",
            "Ś",
            "ą",
            "ź",
            "ż",
            "ś", 
            "ę",
            "ń",
            "ő",
            "Á",       
        );
        
        $replacement = array(
            "e", 
            "s", 
            "c", 
            "r", 
            "z", 
            "y", 
            "a", 
            "i", 
            "e", 
            "u", 
            "u", 
            "t", 
            "d", 
            "o", 
            "n", 
            "y", 
            "u", 
            "", 
            "", 
            "", 
            "", 
            "s", 
            "c", 
            "r", 
            "i", 
            "z", 
            "o", 
            "c", 
            "c", 
            "a", 
            "u", 
            "o",
            "o",
            "l",
            "l",
            "s",
            "a",
            "z",
            "z",
            "s",
            "e",
            "n",
            "o",
            "A",    
        );
        
        $string = trim($string);
        $string = str_replace($replace, $replacement, $string);
        $output = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $output = preg_replace('#[^a-zA-Z0-9\/_|+ -]#', '', $output);
        $output = strtolower(trim($output, '-'));
        $output = preg_replace('#[\/_|+ -]+#', '-', $output);
        
        return $output;
    }
}