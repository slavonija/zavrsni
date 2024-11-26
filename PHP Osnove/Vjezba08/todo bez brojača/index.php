<?php
include_once 'constants.php'; // uključuje datoteku samo prvi puta
include_once 'functions.php';
$todoall = loadToDo();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ToDo </title>
</head>
<body>
  <h1>ToDo list</h1>
<div>
<!-- ovo je forma za dodavanje novih taskova -->
  <form action="newtask.php" method="post">
    <input type="text" name="todo_name" placeholder="Enter your new task">
    <button>New task</button>
  </form>
  <br>
    <!-- izvrti petlju za prikazivanje svih taskova -->
    <?php foreach ($todoall as $todoName => $todo): ?>
      <div>
        <!-- neka budu u istom redu -->
        <form style="display: inline" action="change_status.php" method="post">
          <input type="hidden" name="todo_name" value="<?php echo $todoName ?>">
          <input type="checkbox" name="status" value="1" <?php echo($todo['finished'] ? 'checked' : '') ?>>
        </form>
          <?php echo $todoName ?>
        <!-- ovo je dugme za brisanje taska, također istom je redu -->
        <form style="display: inline" action="delete.php" method="post">
          <!-- hidden polje je za prikazivanje imena -->
          <input type="hidden" name="todo_name" value="<?php echo $todoName ?>">
          <button>Delete</button>
        </form>
      </div>
    <?php endforeach; ?> <!-- kraj petlje -->
</div>

<script>
  // ovo je za prikazivanje checkboxa, checkboxes je kolekcija
  const checkboxes = document.querySelectorAll('input[type=checkbox]');
  // ovo je za klik na checkbox
  checkboxes.forEach(ch => {
    // onclick je klik na checkbox
    ch.onclick = function () {
      // ovo je za prikazivanje
      this.parentNode.submit()
    };
  })
</script>
</body>
</html>