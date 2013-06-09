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
    $previous_words = array();
    $current_multiplier = "";
    
    // go through all the number words in the phrase and construct the answer in numerical form
    foreach ($words as $word) {
      if ($word == "negative") {
        $isPositive = false;
      } else {
        // if we're seeing a big number word, make modifications to the number we think we have
        // consider that there might be more than just one number prior to seeing the big number word: thirty three thousand
        // so go back till you hit a big number word or beginning of the phrase and subtract what you saw so far and multiply by
        // the big number word
        if (in_array($word, array("hundred", "thousand", "million"))) {
          $current_multiplier = 0;
          $saw_hundred = false;

          // Take care of numbers like four million eight hundred forty nine thousand
          // Having a "hundred" is a special case because you need to multiply that by the word that comes before it 
          // and then add what's after it. This loop will run at the worst case four times. 
          foreach ($previous_words as $previous_word) {
            // Remember words all the way back to the beginning of the word or the last time you saw a "million" or "thousand"
            // because at that point you don't need to worry about multiplying by 100
            if (in_array($previous_word, array("thousand", "million"))) {
              break;
            } else { // we are looking at a "hundreds" segment of a number
              if ($previous_word == "hundred") {
                // looking back, we realize we are dealing with a number in the hundreds
                // now we need to look back further to see how many hundreds we are dealing with
                $saw_hundred = true;
              } else {
                if ($saw_hundred) {
                  // we just found out how many hundreds we are dealing with, so modify the number segment
                  $return_value -= 100*$translate[$previous_word];
                  $current_multiplier += 100*$translate[$previous_word];
                } else {
                  // dealing with numbers in the ones and tens places of the segment of the number
                  // simply subtract what we saw from what we think the number is, and remember this number
                  // to use it when we figure out the final value of this segment of the number
                  $return_value -= $translate[$previous_word];
                  $current_multiplier += $translate[$previous_word];
                }
                // reset the fact that we saw a hundred in this segment of the number
                $saw_hundred = false;
              }
              // debug // echo "current_multiplier: " . $current_multiplier . "<br>";
            }
          }
          
          // multiply the big number by the number we saw last to get the full value of the clause we're seeing
          $return_value += $translate[$word] * $current_multiplier; // multiply the "hundreds" segment of the number
          
          // debug //echo "big number: " . $word . " and I'm now at: " . $return_value . " because current_multiplier is: " . $current_multiplier . "<br>";
        } else {
          // add the number that we just saw to the answer
          $return_value += $translate[$word];
        }
      }
      array_unshift($previous_words, $word);
    }
    
    // make the whole thing negative if the first word was negative
    if (!$isPositive) {
      $return_value = -1 * $return_value;
    }  
    
    return $return_value;
  }

}

?>



