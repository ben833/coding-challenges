<?php

include("NumberWords.php");
$cleanInput = strip_tags($_REQUEST['numbers']); // Prevent cross site scripting
$result = "";
$myNumberWords = new NumberWords();
if (strlen(cleanInput)) {
  $result = $myNumberWords->translate_phrases($cleanInput);
} else {
  $result = "Please go back and enter in some text.";
}

?>
<html>
<head>
  <title>Number Words</title>
</head>
<body>
  <h1>Number Words</h1>
  <p>Got:
  <br>
  <textarea cols="64" rows="9"><?php echo $cleanInput ?></textarea>
  <br>
  <br>
  In numeric form those words are: 
  <br>
  <textarea cols="64" rows="9"><?php echo $result ?></textarea>
  <br>
  <a href="index.php">Go back and try another one</a>

</body>
</html>
