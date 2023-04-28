
<?php
// session_start();

// if (isset($_POST['form-2'])) {

  if (empty($_POST['username']) || empty($_POST['password'])) {
  } else {

    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);

    $pdo = new PDO('mysql:host=localhost;dbname=sneakershop', 'root', '');
    $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE taikhoan=?");
    $statement->execute(array($username));
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($total == 0) {
      header("location:index.php?page=login");

      echo "<script type='text/javascript'>alert('Sai tai khoan');</script>";
    } else {
      foreach ($result as $row) {
        $row_password = $row['matkhau'];
      }
      if ($row_password != ($password)) {
        header("location:index.php?page=login");

        echo "<script type='text/javascript'>alert('sai mat khau');</script>";

      } else {

        // $_SESSION['user'] = $row;
        echo "<script type='text/javascript'>alert('Dang nhap thanh cong');</script>";        
        header("location:index.php?page=home");
      }
    }
  }
// }
// header("location:index.php?page=home");

?>