<?php

// if(isset($_GET['btn-sign-up'])){

//     header("Location: index.php?page=sign-up");

// }

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
    font-size: 17px;
  }

  .convert-sign-in a:hover {
    color: crimson;
    text-decoration: none;
  }

  #form-message-error {
    color: red;
    text-align: center;
    font-size: 23px;
    font-weight: 600;
    display: block;
  }

  #form-message-success {
    color: #3ae374;
    text-align: center;
    font-size: 23px;
    font-weight: 600;
    display: block;
  }

  .sub-form {
    position: relative;
  }

  .icon-eye {
    position: absolute;
    right: 20px;
    bottom: 6px;
    padding: 3px;
    z-index: 1;
  }

  .icon-eye:hover {
    cursor: pointer;
  }
</style>
<!-- end header -->
<div id="content" class="pt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-8 m-auto">
        <h1 class="text-center">Đăng ký</h1>
        <form action="" class="form" id="form-1">
          <div class="form-group form-group-username">
            <label for="username">Họ tên</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Họ tên" />
            <small class="form-message form-message-username"></small>
          </div>
          <div class="form-group form-group-email">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control" placeholder="Email" />
            <small class="form-message form-message-email"></small>
          </div>
          <div class="form-group form-group-sdt">
            <label for="sdt">Số điện thoại</label>
            <input type="text" name="sdt" id="sdt" class="form-control" placeholder="Số điện thoại" />
            <small class="form-message form-message-sdt"></small>
          </div>
          <div class="form-group form-group-diaChi">
            <label for="diaChi">Địa chỉ</label>
            <input type="text" name="diaChi" id="diaChi" class="form-control" placeholder="Địa chỉ" />
            <small class="form-message form-message-diaChi"></small>
          </div>
          <div class="form-group form-group-password">
            <label for="password">Mật khẩu</label>
            <div class="sub-form">
              <input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu" />
              <i class="fa-solid fa-eye icon-eye"></i>
            </div>
            <small class="form-message form-message-password"></small>
          </div>
          <div class="form-group form-group-password-confirm">
            <label for="password-confirm">Nhập lại mật khẩu</label>
            <div class="sub-form">
              <input type="password" name="password" id="password-confirm" class="form-control" placeholder="Nhập lại mật khẩu" />
              <i class="fa-solid fa-eye icon-eye"></i>
            </div>
            <small class="form-message form-message-password-confirm"></small>
          </div>
          <input type="submit" name="btn-sign-up" id="btn-sign-up" class="btn btn-info w-100 mt-4 mb-2" value="Đăng ký"></input>
          <small id="form-message-error"></small>
          <small id="form-message-success"></small>
          <div class="convert-sign-in mt-1">
            <span>Bạn đã có tài khoản?</span>
            <a href="index.php?page=login">Đăng nhập</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- <script src="assets/js/validator.js"></script>
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
</script> -->

<script>
  $(document).ready(function() {
    $(".icon-eye").click(function() {
      $(this).toggleClass("fa-eye-slash");
      $(this).toggleClass("fa-eye");
      if ($(this).hasClass("fa-eye-slash")) {
        $(this).prev("#password").attr('type', 'text');
        $(this).prev("#password-confirm").attr('type', 'text');
      } else {
        $(this).prev("#password").attr('type', 'password');
        $(this).prev("#password-confirm").attr('type', 'password');
      }
    })

    $("#username").blur(function() {
      var username = $("#username").val();
      var email = $("#email").val();
      var sdt = $("#sdt").val();
      var diaChi = $("#diaChi").val();
      var password = $("#password").val();
      var password_confirm = $("#password-confirm").val();
      var data = {
        username: username,
        email: email,
        sdt: sdt,
        diaChi: diaChi,
        password: password,
        password_confirm: password_confirm,
      };
      // console.log(data);
      $.ajax({
        url: "check-sign-up-ajax.php", // Trang xử lý, mặc định trang hiện tại
        method: "POST", // POST hoặc GET, mặc định GET
        data: data, // Dữ liệu truyền lên server
        dataType: "json", // html, text, script hoặc json
        success: function(data) {
          if (data.error.username != null) {
            $(".form-group-username").addClass("invalid");
            $(".form-message-username").text(data.error.username);
          } else {
            $(".form-group-username").removeClass("invalid");
            $(".form-message-username").text("");
          }

          $("#username").focus(function() {
            $(this).parents(".form-group-username").removeClass("invalid");
            $(this).next(".form-message-username").text("");
            $("#form-message-error").text("");
            $("#form-message-success").text("");
          })
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status);
          alert(thrownError);
        },
      });
    })

    $("#email").blur(function() {
      var username = $("#username").val();
      var email = $("#email").val();
      var sdt = $("#sdt").val();
      var diaChi = $("#diaChi").val();
      var password = $("#password").val();
      var password_confirm = $("#password-confirm").val();
      var data = {
        username: username,
        email: email,
        sdt: sdt,
        diaChi: diaChi,
        password: password,
        password_confirm: password_confirm,
      };
      // console.log(data);
      $.ajax({
        url: "check-sign-up-ajax.php", // Trang xử lý, mặc định trang hiện tại
        method: "POST", // POST hoặc GET, mặc định GET
        data: data, // Dữ liệu truyền lên server
        dataType: "json", // html, text, script hoặc json
        success: function(data) {
          if (data.error.email != null) {
            $(".form-group-email").addClass("invalid");
            $(".form-message-email").text(data.error.email);
          } else {
            $(".form-group-email").removeClass("invalid");
            $(".form-message-email").text("");
          }

          $("#email").focus(function() {
            $(this).parents(".form-group-email").removeClass("invalid");
            $(this).next(".form-message-email").text("");
            $("#form-message-error").text("");
            $("#form-message-success").text("");
          })
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status);
          alert(thrownError);
        },
      });
    })

    $("#sdt").blur(function() {
      var username = $("#username").val();
      var email = $("#email").val();
      var sdt = $("#sdt").val();
      var diaChi = $("#diaChi").val();
      var password = $("#password").val();
      var password_confirm = $("#password-confirm").val();
      var data = {
        username: username,
        email: email,
        sdt: sdt,
        diaChi: diaChi,
        password: password,
        password_confirm: password_confirm,
      };
      // console.log(data);
      $.ajax({
        url: "check-sign-up-ajax.php", // Trang xử lý, mặc định trang hiện tại
        method: "POST", // POST hoặc GET, mặc định GET
        data: data, // Dữ liệu truyền lên server
        dataType: "json", // html, text, script hoặc json
        success: function(data) {
          if (data.error.sdt != null) {
            $(".form-group-sdt").addClass("invalid");
            $(".form-message-sdt").text(data.error.sdt);
          } else {
            $(".form-group-sdt").removeClass("invalid");
            $(".form-message-sdt").text("");
          }

          $("#sdt").focus(function() {
            $(this).parents(".form-group-sdt").removeClass("invalid");
            $(this).next(".form-message-sdt").text("");
            $("#form-message-error").text("");
            $("#form-message-success").text("");
          })
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status);
          alert(thrownError);
        },
      });
    })

    $("#diaChi").blur(function() {
      var username = $("#username").val();
      var email = $("#email").val();
      var sdt = $("#sdt").val();
      var diaChi = $("#diaChi").val();
      var password = $("#password").val();
      var password_confirm = $("#password-confirm").val();
      var data = {
        username: username,
        email: email,
        sdt: sdt,
        diaChi: diaChi,
        password: password,
        password_confirm: password_confirm,
      };
      // console.log(data);
      $.ajax({
        url: "check-sign-up-ajax.php", // Trang xử lý, mặc định trang hiện tại
        method: "POST", // POST hoặc GET, mặc định GET
        data: data, // Dữ liệu truyền lên server
        dataType: "json", // html, text, script hoặc json
        success: function(data) {
          if (data.error.diaChi != null) {
            $(".form-group-diaChi").addClass("invalid");
            $(".form-message-diaChi").text(data.error.diaChi);
          } else {
            $(".form-group-diaChi").removeClass("invalid");
            $(".form-message-diaChi").text("");
          }

          $("#diaChi").focus(function() {
            $(this).parents(".form-group-diaChi").removeClass("invalid");
            $(this).next(".form-message-diaChi").text("");
            $("#form-message-error").text("");
            $("#form-message-success").text("");
          })
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status);
          alert(thrownError);
        },
      });
    })

    $("#password").blur(function() {
      var username = $("#username").val();
      var email = $("#email").val();
      var sdt = $("#sdt").val();
      var diaChi = $("#diaChi").val();
      var password = $("#password").val();
      var password_confirm = $("#password-confirm").val();
      var data = {
        username: username,
        email: email,
        sdt: sdt,
        diaChi: diaChi,
        password: password,
        password_confirm: password_confirm,
      };
      // console.log(data);
      $.ajax({
        url: "check-sign-up-ajax.php", // Trang xử lý, mặc định trang hiện tại
        method: "POST", // POST hoặc GET, mặc định GET
        data: data, // Dữ liệu truyền lên server
        dataType: "json", // html, text, script hoặc json
        success: function(data) {
          if (data.error.password != null) {
            $(".form-group-password").addClass("invalid");
            $(".form-message-password").text(data.error.password);
          } else {
            $(".form-group-password").removeClass("invalid");
            $(".form-message-password").text("");
          }

          $("#password").focus(function() {
            $(this).parents(".sub-form").parents(".form-group-password").removeClass("invalid");
            $(this).parents(".sub-form").nextAll(".form-message-password").text("");
            $("#form-message-error").text("");
            $("#form-message-success").text("");
          })
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status);
          alert(thrownError);
        },
      });
    })

    $("#password-confirm").blur(function() {
      var username = $("#username").val();
      var email = $("#email").val();
      var sdt = $("#sdt").val();
      var diaChi = $("#diaChi").val();
      var password = $("#password").val();
      var password_confirm = $("#password-confirm").val();
      var data = {
        username: username,
        email: email,
        sdt: sdt,
        diaChi: diaChi,
        password: password,
        password_confirm: password_confirm,
      };
      // console.log(data);
      $.ajax({
        url: "check-sign-up-ajax.php", // Trang xử lý, mặc định trang hiện tại
        method: "POST", // POST hoặc GET, mặc định GET
        data: data, // Dữ liệu truyền lên server
        dataType: "json", // html, text, script hoặc json
        success: function(data) {
          if (data.error.password_confirm != null) {
            $(".form-group-password-confirm").addClass("invalid");
            $(".form-message-password-confirm").text(data.error.password_confirm);
          } else {
            $(".form-group-password-confirm").removeClass("invalid");
            $(".form-message-password-confirm").text("");
          }

          $("#password-confirm").focus(function() {
            $(this).parents(".sub-form").parents(".form-group-password-confirm").removeClass("invalid");
            $(this).parents(".sub-form").nextAll(".form-message-password-confirm").text("");
            $("#form-message-error").text("");
            $("#form-message-success").text("");
          })
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status);
          alert(thrownError);
        },
      });
    })

    $("#form-1").submit(function(e) {
      var username = $("#username").val();
      var email = $("#email").val();
      var sdt = $("#sdt").val();
      var diaChi = $("#diaChi").val();
      var password = $("#password").val();
      var password_confirm = $("#password-confirm").val();
      var btnSignUp = $("#btn-sign-up").val();
      var data = {
        username: username,
        email: email,
        sdt: sdt,
        diaChi: diaChi,
        password: password,
        password_confirm: password_confirm,
        btnSignUp: btnSignUp
      };
      // console.log(data);
      $.ajax({
        url: "check-sign-up-ajax.php", // Trang xử lý, mặc định trang hiện tại
        method: "POST", // POST hoặc GET, mặc định GET
        data: data, // Dữ liệu truyền lên server
        dataType: "json", // html, text, script hoặc json
        success: function(data) {
          if (data.error.username != null) {
            $(".form-group-username").addClass("invalid");
            $(".form-message-username").text(data.error.username);
          } else {
            $(".form-group-username").removeClass("invalid");
            $(".form-message-username").text("");
          }

          if (data.error.email != null) {
            $(".form-group-email").addClass("invalid");
            $(".form-message-email").text(data.error.email);
          } else {
            $(".form-group-email").removeClass("invalid");
            $(".form-message-email").text("");
          }

          if (data.error.sdt != null) {
            $(".form-group-sdt").addClass("invalid");
            $(".form-message-sdt").text(data.error.sdt);
          } else {
            $(".form-group-sdt").removeClass("invalid");
            $(".form-message-sdt").text("");
          }

          if (data.error.diaChi != null) {
            $(".form-group-diaChi").addClass("invalid");
            $(".form-message-diaChi").text(data.error.diaChi);
          } else {
            $(".form-group-diaChi").removeClass("invalid");
            $(".form-message-diaChi").text("");
          }

          if (data.error.password != null) {
            $(".form-group-password").addClass("invalid");
            $(".form-message-password").text(data.error.password);
          } else {
            $(".form-group-password").removeClass("invalid");
            $(".form-message-password").text("");
          }

          if (data.error.password_confirm != null) {
            $(".form-group-password-confirm").addClass("invalid");
            $(".form-message-password-confirm").text(data.error.password_confirm);
          } else {
            $(".form-group-password-confirm").removeClass("invalid");
            $(".form-message-password-confirm").text("");
          }

          $("#username").focus(function() {
            $(this).parents(".form-group-username").removeClass("invalid");
            $(this).next(".form-message-username").text("");
            $("#form-message-error").text("");
            $("#form-message-success").text("");
          })

          $("#email").focus(function() {
            $(this).parents(".form-group-email").removeClass("invalid");
            $(this).next(".form-message-email").text("");
            $("#form-message-error").text("");
            $("#form-message-success").text("");
          })

          $("#sdt").focus(function() {
            $(this).parents(".form-group-sdt").removeClass("invalid");
            $(this).next(".form-message-sdt").text("");
            $("#form-message-error").text("");
            $("#form-message-success").text("");
          })

          $("#diaChi").focus(function() {
            $(this).parents(".form-group-diaChi").removeClass("invalid");
            $(this).next(".form-message-diaChi").text("");
            $("#form-message-error").text("");
            $("#form-message-success").text("");
          })

          $("#password").focus(function() {
            $(this).parents(".sub-form").parents(".form-group-password").removeClass("invalid");
            $(this).parents(".sub-form").nextAll(".form-message-password").text("");
            $("#form-message-error").text("");
            $("#form-message-success").text("");
          })

          $("#password-confirm").focus(function() {
            $(this).parents(".sub-form").parents(".form-group-password-confirm").removeClass("invalid");
            $(this).parents(".sub-form").nextAll(".form-message-password-confirm").text("");
            $("#form-message-error").text("");
            $("#form-message-success").text("");
          })



          if (data.error == "") {
            if (data.is_login == 1) {
              $("#form-message-success").text(data.message);
            } else {
              $("#form-message-error").text(data.message);
            }
          }

          // $("#form-message-2").text(data);
          // if (data.is_login == 1) {
          //   window.location.href = "index.php?page=home";
          // }
          // console.log(data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status);
          alert(thrownError);
        },
      });
      e.preventDefault();
    });
  })
</script>