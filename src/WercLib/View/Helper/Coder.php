<?php
namespace WercLib\View\Helper;

/**
 * Code, decode url query
 *
 * @author Tom
 *        
 */
class Coder
{

    const SALT = '';

    public static function encode($input)
    {
        return trim(strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, self::SALT, $input, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))), '+/=', '-_,'));
    }

    public static function decode($input)
    {
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, self::SALT, base64_decode(strtr($input, '-_,', '+/=')), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }
}
