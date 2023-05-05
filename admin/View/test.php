<form>
    <div class="col-md-2">
        <div>
            Nhãn hiệu
            <select name="danhmuc" id="">
                <option value="">Chọn nhãn hiệu</option>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div>Từ</div>
        <input type="date" name="" id="">
        <div>đến </div>
        <input type="date" name="" id="">
    </div>
    
    <input class="col-md-1" style="margin-top:30px;" type="button" value="Tim">
</form>
<table id="example1" class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th class="col-md-1">#</th>
            <th class="col-md-1">Số lượng đã bán</th>
            <th class="col-md-1">Thu nhập</th>
            <th class="col-md-1">Chi tiết</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $statement = $pdo->prepare("SELECT * FROM tbl_donhang");
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
        ?>
            <tr class="<?php if ($row['tinhtrang'] == 'Xacnhan') {
                            echo 'bg-r';
                        } else {
                            echo 'bg-g';
                        } ?>">
                <td><?php echo $row['id_donhang']; ?></td>
                <td>
                    <b>Id:</b> <?php  ?><br>
                    <b>Name:</b><br> <?php  ?><br>
                    <b>Email:</b><br> <?php  ?><br>
                </td>
                <td>
                    <b>Id:</b> <?php  ?><br>
                    <b>Name:</b><br> <?php  ?><br>
                    <b>Email:</b><br> <?php  ?><br>
                </td>
                <td>5</td>
                <td>
                    <?php echo $row['tongia']; ?>
                </td>
                <td>
                    <?php
                    if ($row['tinhtrang'] == 'Chờ xác nhận') {
                    ?>
                        <a href="#" data-href="../View/order-change-status.php?id=<?php echo $row['id_donhang']; ?>" class="btn btn-success btn-xs" style="width:30%%;margin-bottom:4px;" data-toggle="modal" data-target="#xacnhan">Chờ xác nhận</a>
                    <?php
                    } else {
                        echo $row['tinhtrang'];
                    }
                    ?>
                </td>
                <td>
                    <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#chitiet">Chi tiết</a>
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