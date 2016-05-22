<?php

namespace mhndev\ap;

class Crypto
{

    /**
     * @var string
     */
    protected $KEY;

    /**
     * @var string
     */
    protected $IV;


    /**
     * Crypto constructor.
     * @param $KEY
     * @param $IV
     */
    public function __construct($KEY, $IV)
    {
        $this->KEY = $KEY;
        $this->IV  = $IV;
    }


    /**
     * @param string $KEY
     * @return $this
     */
    public function setKEY($KEY)
    {
        $this->KEY = $KEY;

        return $this;
    }

    /**
     * @param string $IV
     * @return $this
     */
    public function setIV($IV)
    {
        $this->IV = $IV;

        return $this;
    }

    /**
     * @param $string
     * @param int $blockSize
     * @return string
     */
    public function addPadding($string, $blockSize = 32)
    {
        $len = strlen($string);
        $pad = $blockSize - ($len % $blockSize);
        $string .= str_repeat(chr($pad), $pad);

        return $string;
    }

    /**
     * @param $string
     * @return bool
     */
    public function stripPadding($string)
    {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if(preg_match("/$slastc{".$slast."}/", $string)){
            $string = substr($string, 0, strlen($string)-$slast);
            return $string;
        } else {
            return false;
        }
    }

    /**
     * @param string $string
     * @return string
     */
    public function encrypt($string = "")
    {
        $key = \base64_decode($this->KEY);
        $iv = \base64_decode($this->IV);

        return \base64_encode(\mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $this->addPadding($string),
            MCRYPT_MODE_CBC, $iv));
    }

    public function decrypt($string = "")
    {
        $key = \base64_decode($this->KEY);
        $iv = \base64_decode($this->IV);

        $string = \base64_decode($string);
        return $this->stripPadding(\mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_CBC,
            $iv));
    }
}
