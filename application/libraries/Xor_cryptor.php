<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Xor_cryptor {

    /**
     * Xor encode / decode
     *
     * @param type $str
     * @param type $key
     * @return type
     */
    public function encode($str, $key = null)
    {
        if ($key === null) {
            $key = sha1(md5($GLOBALS['adflex']['appkey']));
        }

        $key_hash = sha1($key);
        $str_len  = strlen($str);
        $seq      = $key;
        $gamma    = '';
        $salt     = sha1($key_hash);

        while (strlen($gamma) < $str_len) {
            $seq   = sha1($gamma . $seq . $salt);
            $gamma .= substr($seq, 0, 8);
        }

        return $str ^ $gamma;
    }


    /**
     * Xor encrypt
     *
     * @param type $str
     * @param type $key
     * @return type
     */
    public function encrypt($str, $key = null)
    {
        $str = serialize($str);

        $encode_str = $this->encode($str, $key);
        return $this->base64EncodeUrl($encode_str);
    }


    /**
     * Xor decrypt
     *
     * @param type $str
     * @param type $key
     * @return type
     */
    public function decrypt($str, $key = null)
    {
        $str = $this->base64DecodeUrl($str);

        $decrypted_data = @unserialize($this->encode($str, $key));

        return $decrypted_data ? $decrypted_data : null;
    }


    /**
     * Prep the base64 text for the URL
     *
     * @param type $str
     * @return type
     */
    public function base64EncodeUrl($str)
    {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }


    /**
     * Reverse operation
     *
     * @param type $str
     * @return type
     */
    public function base64DecodeUrl($str)
    {
        return base64_decode(str_pad(strtr($str, '-_', '+/'), strlen($str) % 4, '=', STR_PAD_RIGHT));
    }


}
