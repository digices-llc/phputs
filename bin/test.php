<?php

/**
 * @package PhpUts
 * @version 0.0.1
 * @author  Roderic Linguri
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * Test Suite
 */

require_once(dirname(__DIR__).DIRECTORY_SEPARATOR.'autoload.php');

/** Test PhpUtsCrypt **/

$string_to_encrypt = 'test string';

$crypt = PhpUtsCrypt::encrypt($string_to_encrypt,'example');

echo 'encrypted_string: '.$crypt.PHP_EOL;

$decrypt = PhpUtsCrypt::decrypt($crypt,'example');

echo 'decrypted_string: '.$decrypt.PHP_EOL;
