<?php
namespace WercLib\Entity;

abstract class AbstractEntity
{

    abstract function exchangeArray($data);
    

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * Resi kdy retezec muze byt prazdny nechci null
     *
     * @return unknown string
     */
    public function notNullString($var)
    {
        if (! empty($var)) {
            return $var;
        } else {
            return '';
        }
    }

    /**
     * Vraci not null hodnoty
     *
     * @return array
     */
    public function getArrayPostValues()
    {
        $return = array();
        $_array = $this->getArrayCopy();
        foreach ($_array as $name => $val) {
            if (null !== $val) {
                $return[$name] = $val;
            }
        }
        
        return $return;
    }
}
