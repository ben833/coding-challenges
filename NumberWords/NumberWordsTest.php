<?php
include("NumberWords.php");

$tests = array (
  "three" => 3,
  "three million" => 3000000,
  "nineteen million three hundred four" => 19000304,
  "negative four" => -4,
  "eighty nine" => 89,
  "three hundred ninety two" => 392,
  "eight hundred five" => 805,
  "four thousand nine hundred fifty four" => 4954,
  "" => 0,
  "aaaaaa" => 0,
  "six" => 6,
  "negative seven hundred twenty nine" => -729, 
  "one million one hundred one" => 1000101,
  "thirty three million three hundred thirty three thousand three hundred thirty three" => 33333333,
  "thirty three thousand" => 33000,
  "three hundred thirty three thousand" => 333000,
  "three hundred thirty three thousand three" => 333003,
  "four hundred million eight hundred one thousand four" => 400801004,

);

$numberz = new NumberWords();
$result = "";
echo "<table border='1'>";
foreach ($tests as $test => $value) {
  if ($numberz->translate_phrase($test) == $value) {
    $result = "PASS";
  } else {
    $result = "FAIL " . $numberz->translate_phrase($test);
  }
  echo "<tr><td>" . $test . " = " . $value . "</td><td>" . $result . "</td></tr>";
}
echo "</table>";


?>