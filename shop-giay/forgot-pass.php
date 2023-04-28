<!-- end header -->
<style>
  .form-message{
    color: red;
  }
</style>

<div id="content" class="pt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-8 m-auto">
        <h1 class="text-center">Quên mật khẩu</h1>
        <form action="" class="form" id="form-3">
          <div class="form-group">
            <label for="email">Vui lòng nhập email để lấy lại mật khẩu của bạn</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" />
            <small class="form-message"></small>
          </div>
          <button class="btn btn-outline-info w-100 my-4">Gửi</button>
          <div>
            <span>Quay lại trang</span>
            <a href="index.php?page=login">Đăng nhập</a>
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
    form: "#form-3",
    formGroupSelector: ".form-group",
    errorSelector: ".form-message",
    rules: [
      // Validator.isRequired("#username"),
      Validator.isRequired("#email"),
      Validator.isEmail("#email"),
      // Validator.minLength("#password", 6),
      // Validator.isRequired("#password-comfirmation"),
      // Validator.isComfirmed(
      //   "#password-comfirmation",
      //   function() {
      //     return document.querySelector("#form-1 #password").value;
      //   },
      //   "Mật khẩu nhập lại không chính xác"
      // ),
    ]
    // onSubmit: function (data) {
    //   // call API
    //   console.log(data);
    // },
  });
</script>