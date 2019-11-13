<?php

// DELETE COOKIES
while ( list($key, $value) = each($_COOKIE) ) {
  setcookie(
    $key
    , FALSE
    , 1
    , '/'
  );
}

// REDIRECT
header("Location: ../index.php");

?>
