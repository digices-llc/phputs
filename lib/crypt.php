<?php

/**
 * @package PhpUts
 * @version 0.0.1
 * @author  Roderic Linguri
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class PhpUtsCrypt
{

  /**
   * encrypt a string
   * @param  *str* $str
   * @param  *str* $key
   * @return *str*
   */
  public static function encrypt($str,$key)
  {
    $hsh = '';

    for ($i=0;$i<strlen($str);$i++) {

      $cha = substr($str,$i,1);
      $kch = substr($key, ($i % strlen($key))-1, 1);
      $och = ord($cha);
      $okc = ord($kch);
      $sum = $och + $okc;
      $cha = chr($sum);
      $hsh .= $cha;

    }

    $enc = base64_encode($hsh);

    return $enc;

  }

  /**
   * decode an encrypted string
   * @param  *str* $enc
   * @param  *str* $key
   * @return *str*
   */
  public static function decrypt($enc,$key)
  {

    $str = '';

    $hsh = base64_decode($enc);

    for ($i=0;$i<strlen($hsh);$i++) {

      $cha = substr($hsh,$i,1);
      $kch = substr($key, ($i % strlen($key))-1, 1);
      $och = ord($cha);
      $okc = ord($kch);
      $sum = $och - $okc;
      $cha = chr($sum);
      $str .= $cha;
    }

    return $str;

  }

}
