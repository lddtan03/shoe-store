<section class="content-header">
    <div class="content-header-left">
        <h1>Thống kê</h1>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<section class="content" onload="show(1)">
    <div class="row">
        <div class="col-md-12">

            <div class="box box-info">

                <div class="box-body table-responsive">
                    <div class="wrap col-md-12">
                        <form>
                            <div class="col-md-3">
                                <div>
                                    Nhãn hiệu
                                    <select name="danhmuc" id="">
                                        <option value="">Chọn nhãn hiệu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                Từ <input type="date" name="" id="">
                            </div>
                            <div class="col-md-2">
                                đến <input type="date" name="" id="">
                            </div>
                            <div class="col-md-1">
                                <input type="button" value="Tìm">
                            </div>
                            <div class="col-md-2">
                                <input type="button" value="Các sản phẩm bán chạy">
                            </div>
                        </form>
                        <table id="example1" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="col-md-1">ID Sản phẩm</th>
                                    <th class="col-md-3">Tên sản phẩm</th>
                                    <th class="col-md-3">Số lượng đã bán</th>
                                    <th class="col-md-3">Thu nhập</th>
                                    <th class="col-md-5">Còn lại</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $db = new Helper();
                                $stmt = "SELECT tbl_product.id_pro,ten_pro FROM tbl_phieuxuat join tbl_chitiet_px on tbl_phieuxuat.id_px = tbl_chitiet_px.id_px join tbl_product on tbl_chitiet_px.id_pro =tbl_product.id_pro";
                                $result = $db->fetchAll($stmt);
                                foreach ($result as $row) {
                                ?>
                                    <tr class="dong">
                                        <td><?php echo $row['id_pro'] ?></td>
                                        <td>
                                            <?php echo $row['ten_pro'] ?>
                                        </td>
                                        <td>

                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            15
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation ">
                            <ul class="pagination mt-3 ">
                                <li class="page-item "><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>

                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
</section>

<script defer>
    function show(p) {
        var search = document.getElementById("search").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var inra = this.responseText.split("???");
                document.getElementById("dulieu").innerHTML = inra[0];
                document.getElementById("trang").innerHTML = inra[1];
            }
        }
        xmlhttp.open("GET", "../Model/size-pt-tk.php?p=" + p + "&search=" + search, true);
        xmlhttp.send();
    }
    window.onload = show(1);
</script>