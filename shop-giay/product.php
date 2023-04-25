<link rel="stylesheet" href="./style.css">

<style>
    .range-slider {
        height: 5px;
        position: relative;
        background-color: #e1e9f6;
        border-radius: 2px;
    }

    .range-selected {
        height: 100%;
        left: 30%;
        right: 30%;
        position: absolute;
        border-radius: 5px;
    }

    .range-input {
        position: relative;
    }

    .range-input input {
        position: absolute;
        width: 100%;
        height: 5px;
        top: -7px;
        background: none;
        pointer-events: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    .range-input input::-webkit-slider-thumb {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        border: 3px solid #1b53c0;
        background-color: #fff;
        pointer-events: auto;
        -webkit-appearance: none;
    }

    .range-input input::-moz-range-thumb {
        height: 15px;
        width: 15px;
        border-radius: 50%;
        border: 3px solid #1b53c0;
        background-color: #fff;
        pointer-events: auto;
        -moz-appearance: none;
    }

    #minne,
    #maxne {
        width: 100%;
        text-align: center;
        border: none;

    }
</style>
<script>
    function laygia() {
        var min = document.getElementById("min").value;
        var max = document.getElementById("max").value;
        if (max * 1 <= min * 1) {
            document.getElementById("minne").value = intToVND(max);
            document.getElementById("maxne").value = intToVND(min);
        } else {
            document.getElementById("minne").value = intToVND(min);
            document.getElementById("maxne").value = intToVND(max);
        }
    }

    function intToVND(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " đ";
    }

    function VNDtoInt(str) {
        var vnd = parseInt(str.replace(/[^\d]/g, ""), 10);
        return parseInt(vnd, 10);
    }
</script>

<div id="contain">
    <div class="left-menu">
        <div class="gia mt-3 mb-3" class="unselectable">
            <h1>GIÁ
                <span id="size-toggle" class="toggle" class="unselectable"><img src="" alt="">+</span>
            </h1>
            <div class="range mt-4">
                <div class="range-slider">
                    <span class="range-selected"></span>
                </div>
                <div class="range-input">
                    <input type="range" class="min" id="min" min="0" max="10000000" value="0" onclick="laygia()" step="100000">
                    <input type="range" class="max" id="max" min="0" max="10000000" value="100000000" onchange="laygia()" step="100000">
                </div>
                <div class="row  mt-3 text-center">
                    <div class="col-md-6"><label for="min">Min</label></div>
                    <div class="col-md-6"><label for="max">Max</label></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><input type="text" name="min" id="minne" value="0 đ" disabled></div>
                    <div class="col-md-6"><input type="text" name="max" id="maxne" value="10,000,000 đ" disabled></div>
                </div>
            </div>
        </div>


        <div class="brand mt-2">
            <h1>THƯƠNG HIỆU
                <span id="size-toggle" class="toggle">+</span>
            </h1>

            <form>
                <?php

                $conn = new PDO('mysql:host=localhost;dbname=sneakershop', 'root', '');
                $statement = $conn->prepare('select * from tbl_nhanhieu');
                $statement->execute();
                $result_brand = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result_brand as $row) {
                ?>
                    <ul id="size-filter" class="filter-options" class="form_brand">

                        <label>
                            <input type="checkbox" name="brand[]" id="<?php echo $row['id_nh'] ?>" value="<?php echo $row['id_nh'] ?>">
                            <?php echo $row['nhanhieu'] ?>
                        </label>

                    </ul>

                <?php } ?>
            </form>
        </div>
        <div class="size">
            <h1> SIZE
                <span id="size-toggle" class="toggle">+</span>
            </h1>

            <form>
                <?php

                $conn = new Helper();
                $stmt = 'select * from tbl_size';
                $result_brand = $conn->fetchAll($stmt);
                foreach ($result_brand as $row) {
                ?>
                    <ul id="size-filter" class="filter-options" class="form_brand">

                        <label>
                            <input type="checkbox" name="size[]" id="<?php echo $row['id_size'] ?>" value="<?php echo $row['id_size'] ?>">
                            <?php echo $row['size'] ?>
                        </label>

                    </ul>

                <?php } ?>
            </form>
        </div>
    </div>
    <div class="contact">
        <div class="banner">
            <img src="../uploads/banner.webp" alt="Banner">
        </div>
        <div class="under_banner">

            <div class="text_Sr">
                TẤT CẢ SẢN PHẨM
            </div>
            
            <div class="sort">
                
                <label>Sắp xếp theo : </label>

                <div class="select-product">

                    <select name="select">
                        <option value="">Sản phẩm nổi bật</option>
                        <option value="xs">Giá: Tăng dần</option>
                        <option value="s">Giá: Giảm dần</option>
                        <option value="m">Tên: A-Z</option>
                        <option value="l">Tên: Z-A</option>
                        <option value="xl">Cũ nhất</option>
                        <option value="xl">Mới nhất</option>
                        <option value="xl">Bán chạy nhất</option>

                    </select>
                </div>
                

                <div class="locsanpham">

                    <div id="icon-selector" class="select_lsp" onclick="showPopup()"><span>Lọc sản phẩm</span></div>
                    <div class="popup-overlay" onclick="hidePopup()"></div>

                    <div class="popup" id="myPopup">

                        <div class="gia" class="unselectable">
                            <h1>GIÁ
                                <span id="size-toggle" class="toggle" class="unselectable">+</span>
                            </h1>

                            <form>
                                <ul id="size-filter" class="filter-options" class="form_gia">
                                    <li>

                                        <input type="radio" name="price" value="all">
                                        Tất cả
                                        </label>
                                    </li>

                                </ul>


                            </form>
                        </div>

                        <div class="brand">
                            <h1>THƯƠNG HIỆU
                                <span id="size-toggle" class="toggle">+</span>
                            </h1>

                            <form>
                                <?php

                                $conn = new PDO('mysql:host=localhost;dbname=sneakershop', 'root', '');
                                $statement = $conn->prepare('select * from tbl_nhanhieu');
                                $statement->execute();
                                $result_brand = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result_brand as $row) {
                                ?>
                                    <ul id="size-filter" class="filter-options" class="form_brand">

                                        <label>
                                            <input type="checkbox" name="brand[]" id="<?php echo $row['id_nh'] ?>" value="<?php echo $row['id_nh'] ?>">
                                            <?php echo $row['nhanhieu'] ?>
                                        </label>

                                    </ul>

                                <?php } ?>
                            </form>
                        </div>
                        <div class="size">
                            <h1> SIZE
                                <span id="size-toggle" class="toggle">+</span>
                            </h1>

                            <form>
                                <?php

                                $conn = new PDO('mysql:host=localhost;dbname=sneakershop', 'root', '');
                                $statement = $conn->prepare('select * from tbl_size');
                                $statement->execute();
                                $result_brand = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result_brand as $row) {
                                ?>
                                    <ul id="size-filter" class="filter-options" class="form_brand">

                                        <label>
                                            <input type="checkbox" name="size[]" id="<?php echo $row['id_size'] ?>" value="<?php echo $row['id_size'] ?>">
                                            <?php echo $row['size'] ?>
                                        </label>

                                    </ul>

                                <?php } ?>

                            </form>
                        </div>
                    </div>


                </div>

            </div>
        </div>
        <section style="background-color: #eee;">
            <div class="container py-5 ">
                <div class="row" id="product-list">
                    <?php
                    $para=[];
                    if (isset($_GET['nhanhieu']) && isset($_GET['loai'])) {
                        $stmt='select * from tbl_product';
                    } else if (isset($_GET['nhanhieu'])) {
                        $stmt="select * from tbl_product join tbl_nhanhieu on tbl_nhanhieu.id_nh=tbl_product.id_nh where nhanhieu regexp ? limit 6";
                        $para=[$_GET['nhanhieu']];
                    } else if (isset($_GET['loai'])) {
                        $stmt='select * from tbl_product';
                    } else {
                        $stmt='select * from tbl_product';
                    }
                    $conn = new Helper();
                    $result = $conn->fetchAll($stmt, $para);
                    $products = $result;
                    foreach ($result as $row) {
                    ?>

                        <div class="col-md-6 col-lg-4 mb-2 mb-lg-0  ">
                            <div class="card mb-4 position-relative" style="height:600px">
                                <!-- <div class="position-absolute p-2  " style="top:0;left:0; background-color:bisque; color:tomato;">-30%</div>
                                <div class="position-absolute p-2  " style="top:0;right:0; background-color:red; color:white;"> New</div> -->

                                <a href="chitietsp.php?id=<?php echo $row['id_pro']; ?>">
                                    <div style="width:100%; height:auto;"> <img  src="../uploads/<?php echo $row['hinhanh']; ?>" class="card-img-top" alt=""></div>
                                </a>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <p class="small"><a href="#!" class="text-muted">Loại sản phẩm</a></p>
                                        <p class=""></p>
                                        <p class="small text-danger"><s><?php echo money($row['giacu']) ?></s></p>
                                    </div>

                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0"><?php echo $row['ten_pro'] ?></h5>
                                        <h5 class="text-dark mb-0"><?php echo money($row['giamoi']) ?></h5>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <p class="text-muted mb-0">Lượt xem: <span class="fw-bold"><?php echo $row['total_view']; ?></span></p>
                                        <div class="ms-auto text-warning">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }

                    ?>
                </div>



            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination" id="trang" >
                </ul>
            </nav>
        </section>

    </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    //// sự kiện left menu +   -
    var toggleButtons = document.querySelectorAll(".toggle");
    toggleButtons.forEach(function(button) {
        button.addEventListener("click", function() {

            var filterOptions = button.parentElement.nextElementSibling;

            if (filterOptions.style.display === "none") {
                filterOptions.style.display = "block";
                button.textContent = "-";
            } else {
                filterOptions.style.display = "none";
                button.textContent = "+";
            }
        });
    });



    // Thêm sự kiện "click" cho toàn bộ trang web để đóng cửa sổ khi người dùng bấm ra ngoài

    function showPopup() {
        document.getElementById("myPopup").style.display = "block";
        document.querySelector('.popup-overlay').style.display = "block";
    }

    function hidePopup() {
        document.getElementById("myPopup").style.display = "none";
        document.querySelector('.popup-overlay').style.display = "none";
    }
    // suu kien loc


    $(document).ready(function() {
        $('input[name="brand[]"], input[name="size[]"]').click(function() {
            var brands = $('input[name="brand[]"]:checked').map(function() {
                return this.id;
            }).get();

            var sizes = $('input[name="size[]"]:checked').map(function() {
                return this.id;
            }).get();

            if (brands.length == 0 && sizes.length == 0) {
                $.ajax({
                    url: 'filter.php',
                    method: 'POST',
                    data: {
                        brands: [],
                        sizes: [],
                        page:1
                    },
                    success: function(response) {
                        var inra = response.split("???");
                        $('#product-list').html(inra[0]);
                        // document.getElementById("tongsosp").innerText = inra[1];
                        document.getElementById("trang").innerHTML = inra[2];
                    }
                });
            } else {
                $.ajax({
                    url: 'filter.php',
                    method: 'POST',
                    data: {
                        brands: brands,
                        sizes: sizes
                    },
                    success: function(response) {
                        var inra = response.split("???");
                        $('#product-list').html(inra[0]);
                        document.getElementById("trang").innerHTML = inra[2];
                    }
                });
            }
        });
    });
</script>