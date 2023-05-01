<style>
    * {
        font-size: 15px;
    }

    table {
        margin-top: 30px;
    }

    th {
        background-color: aqua;
    }

    thead :first-child {
        border-top-left-radius: 20px;
    }

    thead :last-child {
        border-top-right-radius: 20px;
    }

    .dong {
        border-bottom: 2px groove;
    }

    a:hover {
        cursor: pointer;
    }
</style>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<?php
require_once("../View/header.php");
ob_start();
if (isset($_GET["page"])) {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    }
    $page = $_GET["page"];
    require_once('../View/' . $page . '.php');
} else {
    require_once("../View/dashboard.php");
}
ob_end_flush();
// require_once("../View/mau.php");
require_once("../View/footer.php");
?>