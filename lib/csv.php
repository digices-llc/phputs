<?php

/**
 * @package PhpUts
 * @version 0.0.1
 * @author  Roderic Linguri
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class PhpUtsCSV
{

  /**
   * encode simple array as comma-separated values
   * @param  *mixed* $values
   * @return *str*
   */
  public static function encodeLine($values)
  {

    // initialize string to return
    $line = '';

    // initialize increment
    $v = 0;

    // iterate through array elements
    foreach($values as $value) {

      // prefix comma, unless first value
      if ($v > 0) {
        $line .= ',';
      }

      // initialize cell
      $cell = '';

      // iterate through characters
      for ($i = 0 ; $i < strlen($value) ; $i++) {

        // isolate character
        $char = substr($value, $i, 1);

        // convert to ascii ord
        $ord = ord($char);

        // conditionally add char based on ord
        switch ($ord) {
          case 9:
            $cell .= "\\t";
            break;
          case 10:
            $cell .= "\\n";
            break;
          case 13:
            $cell .= "\\r";
            break;
          case $ord < 32:
            $cell .= '';
            break;
          case 34:
            $cell .= '\\"';
            break;
          case 92:
            // backslash
            $cell .= "\\".substr($value, ++$i, 1);
            break;
          default:
            $cell .= $char;
        }

      }

      // check for comma, so we can quote the string
			if ($stp = strpos($cell, ',')) {
				$line .= '"'.$cell.'"';
			} else {
				$line .= $cell;
			}

      $v++;

    }

    return $line;

  } // ./@method encodeLine

  /**
   * encode any array as comma-separated values
   * @param  *mixed* $array (arrays or values)
   * @return *str*
   */
  public static function encode($array)
  {

    // check to see if array contains arrays
    if (is_array($array[0])) {

      // array of arrays
      $file = '';

      foreach ($array as $values) {
        // concatenate line onto file
        $file .= self::encodeLine($values).PHP_EOL;
      }

      return $file;

    }
    
    // array of strings, presumably
    else {
      // just return the one line
      return self::encodeLine($array);

    }

  } // ./@method encode

  /**
   * decode string of comma-separated values into array
   * @param  *str* comma-separated values
   * @return *mixed* $array (arrays or values)
   */
  public static function decode($str)
  {
    // initialize file array to return
    $file = array();
    
    // initialize first line array
    $line = array();
    
    // initialize first value to add
    $value = '';
    
    // initialize outside flag
    $outside = true;

    // iterate through characters in string
    for ($i = 0 ; $i < strlen($str) ; $i++) {
    
      $char = substr($str, $i, 1);
      
      $ord = ord($char);

      // check for backslash
      if ($ord == 92) {
        // escaped character, do not process (i.e. add incremented char)
        $escaped_char = substr($str, ++$i, 1);
        
        if (ord($escaped_char) == 34 || ord($escaped_char) == 39) {
          // we can ditch the backslashes on quotes
          $value .= $escaped_char;
        } else {
          // otherwise, keep the backslash
          $value .= "\\".substr($str, ++$i, 1);
        }
      } // ./backslash
      
      else {
        // not an escaped character
        if ($outside == true) {
          // outside quoted string
          switch ($ord) {
            case 34:
              $outside = false;
              break;
            case 44;
              // comma is cell delimeter
              array_push($line, $value);
              $value = '';
              break;
            case 10:
            case 13:
              // return or newline is record delimeter
              if (strlen($value) > 0) {
                // avoid doubled up combinations (i.e. windows formatted csv)
								array_push($line, $value);
								$value = '';
								array_push($file, $line);
								$line = array();
              }
              // else ignore
              break;
            case $ord < 32:
              $value .= '';
              break;
            default:
              $value .= $char;
          }
        } // ./outside

        else {
          // inside quoted string
          switch ($ord) {
            case 34:
              $outside = true;
              break;
            default:
              $value .= $char;
          }
        } // ./inside

      } // ./not backslash
    
    } // ./for-loop
    
    // if no EOL was in CSV, need to complete the line and file
    if (strlen($value) > 0) {
      array_push($line, $value);
      $value = '';
      array_push($file, $line);
      $line = array();
    }
    
    // avoid returning array inside array
    if (count($file) == 1) {
      return $file[0];
    } else {
      return $file;
    }
    
  } // ./@method decode

}




