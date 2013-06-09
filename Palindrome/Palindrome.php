<?php


class Palindrome {



  public function find_longest_palindrome ($input) {
    
    // Basic strategy is to assume that the input is natural language, in which case most likely the largest palindrome will be
    // 20 characters or less. This means that the average case Big-O is linear, while worst case Big-O is cubic.
    
    // start at string length of 20 and work way down(?), then if not found, start at the max substring then work the way down.
    // this lowers the average case big-O
    // actually that won't work because if we find a palindrome at 19 then we'll accept it, but there might also be one at 22.
    // so what you do is check for a palindrome at 19 or 20 (even/odd) and if you find one, try to grow it. Because all palindromes at
    // lengths greater than 19 or 20 include those smaller palindromes as part of them. 
    // check if palindrome at 20. if yes, grow it. if no, check for palindrome at 19. 
    // if palindrome at 19, grow it. if no, count backwards to 2 checking for palindromes and return one as soon as you find it.
    // "grow it" means check for palindromes at higher lengths until you can't find one anymore
    
    $max_length = 0;
    $input_length = strlen($input);
    $substring_length = 3;
    $longest_palindrome = "";
    $possible_palindrome = "";
    $COMMON_LENGTH_EVEN = 20; // Most likely the largest palindrome will be 20 characters or less
    $COMMON_LENGTH_ODD = 19; // Need to check even and odd, because an odd-length palindrome won't contain an even-length palindrome
    $starting_point = $COMMON_LENGTH_ODD;
    $ending_point = 1;
    $direction = -1;
    $bigger_palindrome = "";  

    $longest_palindrome = $this->check_palindrome($COMMON_LENGTH_EVEN, $input, $input_length);

    if (strlen($longest_palindrome)) {
      $direction = 1; // search up (grow the palindrome)
      $starting_point = $COMMON_LENGTH_EVEN + 1; // start one higher to check for bigger palindromes
      $ending_point = $input_length;
    } else {
      $longest_palindrome = $this->check_palindrome($COMMON_LENGTH_ODD, $input, $input_length);
      if (strlen($longest_palindrome)) {
        $direction = 1; // search up (grow the palindrome)
        $starting_point = $COMMON_LENGTH_ODD + 2; // start two higher to check for bigger palindromes (one higher has been checked)
        $ending_point = $input_length;
      }
    }
    
    // we already found a palindrome, so keep searching up two while we have one. if you can go up two 
    // without finding another palindrome, then there are no bigger palindromes, so return what we have
    if (strlen($longest_palindrome)) {

      for ($substring_length = $starting_point; $starting_point <= $ending_point; $substring_length += $direction) {
        $bigger_palindrome = $this->check_palindrome($substring_length, $input, $input_length);
        if (strlen($bigger_palindrome)) {
          $longest_palindrome = $bigger_palindrome;
        } else {
          if ($substring_length < $input_length) {
            $bigger_palindrome = $this->check_palindrome($substring_length + 1, $input, $input_length);
            if (!strlen($bigger_palindrome)) {
              break;
            }
          } else {
            break;
          }
        }
      }  
    } else { // we did not find a palindrome at the "common" number, so count down and look for short palindromes
      for ($substring_length = $starting_point; $starting_point > $ending_point; $substring_length += $direction) {
        $longest_palindrome = $this->check_palindrome($substring_length, $input, $input_length);
        if (strlen($longest_palindrome)) {
          // as soon as you find one, stop searching, since any lower number of characters is not as long as the one we found
          break;
        }
      }
    }
    return $longest_palindrome;
  }

  function check_palindrome($substring_length, $input, $input_length) {
    $return_value = "";
    // go through the text and find palindromes at different center positions, looking left and right
    // in this function we only care about whether or not there is a palindrome of the given length: $substring_length
    for ($center = floor($substring_length/2); $center < $input_length - floor($substring_length/2); $center++) {
      $left = $center - floor($substring_length/2); // works for even or odd because of the floor; will look 3 to the left and 2 to the right if even
      $left = $left < 0 ? 0 : $left; // avoid having a negative index for the possible palindrome 
      $right = $center + floor($substring_length/2); // works for even or odd because of the floor
      $right = $right > $input_length - 1 ? $input_length - 1 : $right; // avoid having a too high right index for the possible palindrome
      
      $possible_palindrome = substr($input, $left, $substring_length);
      // debug //echo "right: " . $right . " left: " . $left . " possible_palindrome: " . $possible_palindrome . "<br>";
      
      // flip the string to see if it is a palindrome. If the reverse is the same as the original, it is one
      if ($possible_palindrome == strrev($possible_palindrome)) {
        $return_value = $possible_palindrome;
        break;
      } 
    }
    return $return_value;
  }

}

?>



