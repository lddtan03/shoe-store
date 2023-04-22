<?php

if(isset($_GET['btn-sign-up'])){

    header("Location: index.php?page=sign-up");

}

?>


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

  .convert-sign-in a:hover {
    color: crimson;
    text-decoration: none;
  }
</style>
<!-- end header -->
<div id="content" class="pt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-8 m-auto">
        <h1 class="text-center">Đăng ký</h1>
        <form action="" class="form" id="form-1">
          <div class="form-group">
            <label for="username">Tên đăng nhập</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Tên đăng nhập" />
            <small class="form-message"></small>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" />
            <small class="form-message"></small>
          </div>
          <div class="form-group">
            <label for="passwork">Mật khẩu</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu" />
            <small class="form-message"></small>
          </div>
          <div class="form-group">
            <label for="passwork">Nhập lại mật khẩu</label>
            <input type="password" name="password" id="password-comfirmation" class="form-control" placeholder="Nhập lại mật khẩu" />
            <small class="form-message"></small>
          </div>
          <button name="btn-sign-up" class="btn btn-info w-100 my-4">Đăng ký</button>
          <div class="convert-sign-in">
            <span>Bạn đã có tài khoản?</span>
            <a href="index.php?page=login">Đăng nhập</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="assets/js/validator.js"></script>
<script>
  Validator({
    form: "#form-1",
    formGroupSelector: ".form-group",
    errorSelector: ".form-message",
    rules: [
      Validator.isRequired("#username"),
      Validator.isRequired("#email"),
      Validator.isEmail("#email"),
      Validator.isRequired("#password"),
      Validator.minLength("#password", 6),
      Validator.isRequired("#password-comfirmation"),
      Validator.isComfirmed(
        "#password-comfirmation",
        function() {
          return document.querySelector("#form-1 #password").value;
        },
        "Mật khẩu nhập lại không chính xác"
      ),
    ],
    // onSubmit: function (data) {
    //   // call API
    //   console.log(data);
    // },
  });
</script>
