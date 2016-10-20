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
echo PHP_EOL.'------TEST PhpUtsCrypt------'.PHP_EOL;

$string_to_encrypt = 'test string';

$crypt = PhpUtsCrypt::encrypt($string_to_encrypt,'example');

echo 'encrypted_string: '.$crypt.PHP_EOL;

$decrypt = PhpUtsCrypt::decrypt($crypt,'example');

echo 'decrypted_string: '.$decrypt.PHP_EOL;

/** Test PhpUtsCSV **/
echo PHP_EOL.'------TEST PhpUtsCSV------'.PHP_EOL;

$values = array(
  'regular string',
  'separated, by a comma',
  'contains "quoted" string',
  'escaping the special char: \\"',
  'multiple, commas, 
and a line break'
);

echo '--original values--:'.PHP_EOL;

echo print_r($values, true).PHP_EOL;

echo '--encoded values--'.PHP_EOL;

$csv = PhpUtsCSV::encode($values);

echo $csv.PHP_EOL;

echo PHP_EOL.'--testing multiple arrays--'.PHP_EOL;

$values2 = array(
  'second, line',
  'another regular string',
  'tab	tab	tab',
  'an escaped \r',
  'line1
line2
line3'
);

$arrays = array($values,$values2);

$file = PhpUtsCSV::encode($arrays);

echo $file.PHP_EOL;

echo PHP_EOL.'--testing read from file--'.PHP_EOL;

$file = file_get_contents(dirname(__DIR__).DIRECTORY_SEPARATOR.'var'.DIRECTORY_SEPARATOR.'test.csv');

$array = PhpUtsCSV::decode($file);

echo print_r($array,true);

echo PHP_EOL.'--writing file back to disk--'.PHP_EOL;

file_put_contents(dirname(__DIR__).DIRECTORY_SEPARATOR.'var'.DIRECTORY_SEPARATOR.'test_out.csv', PhpUtsCSV::encode($array));

