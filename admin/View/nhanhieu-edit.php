<?php
include("../Database/Helper.php");
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['nhanhieu'])) {
        $valid = 0;
        $error_message .= "Nhãn hiệu không được để trống<br>";
    } else {
		$db = new Helper();
    	$statement = "SELECT * FROM tbl_nhanhieu WHERE id_nh=?";
		$para=[$_REQUEST['id']];
		$result = $db->fetchAll($statement,$para);
		foreach($result as $row) {
			$current_nhanhieu = $row['nhanhieu'];
		}
		$db = new Helper();
		$statement ="SELECT * FROM tbl_nhanhieu WHERE nhanhieu=? ";
		$para=[$_POST['nhanhieu']];
    	$total = $db->rowCount($statement,$para);					
    	if($total) {
    		$valid = 0;
        	$error_message .= 'Nhãn hiệu đã tồn tại<br>';
    	}
    }

    if($valid == 1) {    	
		// updating into the database
		$statement = $pdo->prepare("UPDATE tbl_nhanhieu SET nhanhieu=? WHERE id_nh=?");
		$statement->execute(array($_POST['nhanhieu'],$_REQUEST['id']));

    	$success_message = 'Thêm Nhãn hiệu thành công.';
    }
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = "SELECT * FROM tbl_nhanhieu WHERE id_nh=?";
	$db = new Helper();
	$para=[$_REQUEST['id']];
    $total = $db->rowCount($statement,$para);
	$result = $db->fetchAll($statement,$para)	;
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Chỉnh sửa Nhãn hiệu</h1>
	</div>
	<div class="content-header-right">
		<a href="index.php?page=nhanhieu" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

   
<?php							
foreach ($result as $row) {
	$nhanhieu = $row['nhanhieu'];
}
?>

<section class="content">

  <div class="row">
    <div class="col-md-12">

		<?php if($error_message): ?>
		<div class="callout callout-danger">
		
		<p>
		<?php echo $error_message; ?>
		</p>
		</div>
		<?php endif; ?>

		<?php if($success_message): ?>
		<div class="callout callout-success">
		
		<p><?php echo $success_message; ?></p>
		</div>
		<?php endif; ?>

        <form class="form-horizontal" action="" method="post">

        <div class="box box-info">

            <div class="box-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Nhãn hiệu<span>*</span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="nhanhieu" value="<?php echo $nhanhieu; ?>">
                    </div>
                </div>
                <div class="form-group">
                	<label for="" class="col-sm-2 control-label"></label>
                    <div class="col-sm-6">
                      <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
                    </div>
                </div>

            </div>

        </div>

        </form>



    </div>
  </div>

</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>
