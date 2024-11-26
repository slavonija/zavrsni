<!DOCTYPE html>
<html>
<body>

<?php
function divide($djeljenik, $djelilac) {
  if($djelilac == 0) {
    throw new Exception("Dijeljenje s nulom");
  }
  return $djeljenik / $djelilac;
}

echo divide(5, 0);
?>

</body>
</html>