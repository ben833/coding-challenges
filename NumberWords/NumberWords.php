<?php


class NumberWords {

  // use an associative array of words to numbers
  private $translate = array (
      "zero" => 0,
      "one" => 1,
      "two" => 2,
      "three" => 3,
      "four" => 4,
      "five" => 5,
      "six" => 6,
      "seven" => 7,
      "eight" => 8,
      "nine" => 9,
      "ten" => 10,
      "eleven" => 11,
      "twelve" => 12,
      "thirteen" => 13,
      "fourteen" => 14,
      "fifteen" => 15,
      "sixteen" => 16,
      "seventeen" => 17,
      "eighteen" => 18,
      "nineteen" => 19,
      "twenty" => 20,
      "thirty" => 30,
      "forty" => 40,
      "fifty" => 50,
      "sixty" => 60,
      "seventy" => 70,
      "eighty" => 80,
      "ninety" => 90,
      "hundred" => 100,
      "thousand" => 1000,
      "million" => 1000000
    );


  public function translate_phrases ($numbers) {
  
    // First, break up the input into individual numbers, then translate each number with a function
    
    // Transform the string into an array. Loop through the elements in the array and call the translate function
    $phrases = explode(",", $numbers);
    $results = array();
    foreach ($phrases as $phrase) {
      $results[] = $this->translate_phrase($phrase);
      // echo $phrase . "=" . $this->translate_phrase($phrase) . "<br>";
    }
    
    // give the answer comma separated
    return implode(", ", $results);
  }

  public function translate_phrase($number) {
  
    // Just like when a human is listening to someone speak a number to us, we have the ability to change our
    // mind about what is the number we are hearing. When we hear "four" we think of 4, but when we hear 
    // "four million" we change our mind about the number as 4 and think of the number as a much bigger one
    // this function makes modifications to the number we think we have to produce the final answer
  
    // Go through numbers and return the right one
    $return_value = "";
    $isPositive = true;
    
    // Set up associative array of translations for each number word  
    $translate = $this->translate;
    
    $words = explode(" ", $number);
    //print_r($words);
    $last_word = "";
    
    // go through all the number words in the phrase and construct the answer in numerical form
    foreach ($words as $word) {
      if ($word == "negative") {
        $isPositive = false;
      } else {
        //echo "*" . $word;
        // if we're seeing a big number word, make modifications to the number we think we have
        if (in_array($word, array("hundred", "thousand", "million"))) {
          // debug // echo "<br>big number: " . $word . " and I'm at: " . $return_value . "<br>";
          
          // the previous word we saw is actually much bigger, so forget that we've even seen it
          $return_value -= $translate[$last_word];
          
          // multiply the big number by the number we saw last to get the full value of the clause we're seeing
          $return_value += $translate[$word] * $translate[$last_word]; // need to just multiply the last number, not the whole return_value
          
          // debug // echo "big number: " . $word . " and I'm now at: " . $return_value . " because last_word is: " . $translate[$last_word] . "<br>";
        } else {
          // add the number that we just saw to the answer
          $return_value += $translate[$word];
        }
      }
      $last_word = $word;
    }
    
    // make the whole thing negative if the first word was negative
    if (!$isPositive) {
      $return_value = -1 * $return_value;
    }  
    
    return $return_value;
  }

}

?>



