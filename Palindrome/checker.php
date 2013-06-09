<?php

include("Palindrome.php");
$cleanInput = strip_tags($_REQUEST['story']); // Prevent cross site scripting
$result = "";
$myPalindrome = new Palindrome();
if (strlen(cleanInput)) {
  $result = $myPalindrome->find_longest_palindrome($cleanInput);
} else {
  $result = "Please go back and enter in some text to analyze.";
}

?>
<html>
<head>
  <title>Palindrome</title>
</head>
<body>
  <h1>Palindrome Checker</h1>
  <p>Got:
  <br>
  <textarea cols="64" rows="9"><?php echo $cleanInput ?></textarea>
  <br>
  <br>
  The longest palindrome is: 
  <br>
  <textarea cols="64" rows="9"><?php echo $result ?></textarea>
  <br>
  <a href="index.php">Go back and try another one</a>

</body>
</html>
