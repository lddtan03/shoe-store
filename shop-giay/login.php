<?php
// include('./Helper.php');
unset($_SESSION['user1']);
if (isset($_POST["btn-login"])) {
    $db = new Helper();
    $statement="SELECT * FROM tbl_users WHERE email=? and matkhau=?";
    $para=[$_POST['username'],$_POST['password']];
    $count = $db->rowCount($statement,$para);
    echo $_POST['username'];
    echo $_POST['password'];
    if($count==0){
        echo "<script type='text/javascript'>alert('Tên đăng nhập hoặc mật khẩu sai');</script>";
    }else{
        // echo "<script type='text/javascript'>alert('Đăng nhập thành công');</script>";
        $db = new Helper();
        $result= $db->fetchOne($statement,$para);
                
        $_SESSION["user1"]=$result;
        header("Location: index.php?page=home");
        
    }
    
}

?>
       <script defer>
          function resetdn(){
                document.getElementById('ttdn').innerHTML='  <img src="../uploads/" alt="" style="width:50px">'
            }
            window.onload = resetdn();
        </script>
<style>
    .form-group label {
        font-weight: 500;
    }

    .form-group.invalid .form-control {
        border-color: #f33a58;
    }

    .form-group.invalid .form-message {
        color: #f33a58;
    }

    .convert-sign-up a:hover,
    .forgot-password:hover {
        color: crimson;
        text-decoration: none;
    }
</style>

<div id="content" class="pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 m-auto">
                <h1 class="text-center">Đăng nhập</h1>
                <form method="POST" class="form" id="form-2">
                    <div class="form-group">
                        <label for="username">Tên đăng nhập</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Tên đăng nhập" autocomplete="off" autofocus />
                        <small class="form-message"></small>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu" autocomplete="off" />
                        <small class="form-message"></small>
                    </div>
                    <input type="submit" name="btn-login" class="btn btn-info w-100 my-4" value="Đăng nhập">
                    <a class="forgot-password" href="index.php?page=forgot-pass">Quên mật khẩu?</a>
                    <div class="convert-sign-up">
                        <span>Bạn chưa có tài khoản?</span>
                        <a href="index.php?page=sign-up">Đăng ký</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/validator.js"></script>
<script>
    Validator({
        form: "#form-2",
        formGroupSelector: ".form-group",
        errorSelector: ".form-message",
        rules: [
            Validator.isRequired("#username"),
            Validator.isRequired("#password"),
            Validator.minLength("#password", 5),
        ],

        // onSubmit: function (data) {
        //   // call API
        //   console.log(data);
        // },
    });
</script>