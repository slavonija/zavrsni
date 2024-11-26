<html>
<body>
<form method="GET">
   <input type="search" name="search" />
   <input type="hidden" name="foo" value="<?php echo !empty($_GET['foo']) ?htmlspecialchars($_GET['foo']) :''; ?>" />
   <input type="hidden" name="product" value="<?php echo !empty($_GET['product']) ?htmlspecialchars($_GET['product']) :''; ?>" />
</form>
<form method="GET">
   <input type="search" name="search" />
   <?php
      foreach($_GET kao $key => $val{
         if($key != 'search'){
            echo '<input type="hidden" name="'.htmlspecialchars($key).'" value="'.htmlspecialchars($val).'" />';
         }
      }
   ?>
</form>
</body>
</html>