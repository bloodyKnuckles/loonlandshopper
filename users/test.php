<?php

setcookie(
  'test'
  , 'one two three four five'
//  , time() + 3600
);

if ( isset($_COOKIE['test']) ) { $cookieSet = 'The cookie is ' . $_COOKIE['test']; } 
else { $cookieSet = 'No cookie has been set'; }

?>

<html>
<head><title>cookie</title></head>
<body>

<?php

echo $cookieSet;

echo '<pre>';
print_r($_COOKIE);
echo '</pre>';

?>

</body>
</html>

