$(document).ready(function () {
  $("#icon-menu-responsive").click(function () {
    $("#main-menu-responsive").stop().slideToggle(300);
  });
  $(".icon-sub-menu").click(function () {
    $(this).toggleClass("open");
    $(this).next(".sub-menu").stop().slideToggle(300);
    return false;
  });
  $(".icon-sub-sub-menu").click(function () {
    $(this).toggleClass("open");
    $(this).next(".sub-sub-menu").stop().slideToggle(300);
    return false;
  });
  function hide_menu() {
    $("#main-menu-responsive").slideUp(300);
    $(".sub-login").slideUp(200);
  }

  $(window).resize(function (e) {
    hide_menu();
    e.preventDefault();
  });

  $(".icon-login-2").click(function (e) {
    $(".sub-login").stop().slideToggle(200);
  });
});
