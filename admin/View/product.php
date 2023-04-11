<style>

</style>

<section class="content-header">
	<div class="content-header-left">
		<h1>Danh sách sản phẩm</h1>
	</div>
	<div class="content-header-right">
		<a href="index.php?page=product-add" class="btn btn-primary btn-sm">Add new</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<div class="wrap col-md-12">
						<div class="m-5 ">
							<form>
								<div class="">Search <input type="text" id="search" placeholder="ID or Name"><input type="button" id="tim" value="Tim" onclick="show(1)"></div>
							</form>
						</div>
						<table id="example1" class="table table-bordered table-hover table-striped">
							<thead class="thead-dark">
								<tr>
									<th class="col-md-1 text-center">id</th>
									<th class="col-md-1">Hình ảnh</th>
									<th class="col-md-3">Tên sản phẩm</th>
									<th class="col-md-1">Danh mục</th>
									<th class="col-md-1">Nhãn hiệu</th>
									<th class="col-md-1 text-center">Giá cũ</th>
									<th class="col-md-1 text-center">Giá</th>
									<th class="col-md-1 text-center">Lượt xem</th>
									<th class="col-md-1 text-center">Số lượng</th>
									<th class="col-md-1">Hành động</th>
								</tr>
							</thead>
							<tbody id="dulieu">

							</tbody>
						</table>
					</div>
					<style>
					</style>
					<nav aria-label="Page navigation " >

						<ul class="pagination mt-3 row " id="trang">
						</ul>

					</nav>
				</div>
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
				<p>Are you sure want to delete this item?</p>
				<p style="color:red;">Be careful! This product will be deleted from the order table, payment table, size table, color table and rating table also.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-ok">Delete</a>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="soluong" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Số lượng từng kích thước</h4>
			</div>
			<div class="modal-body">
				<table class="table text-center">
					<thead>
						<tr>
							<th>Kích thước</th>
							<th>Số lượng</th>
						</tr>
					</thead>
					<tbody id="soluongsize">

					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

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
		xmlhttp.open("GET", "../Model/product-pt-tk.php?p=" + p + "&search=" + search, true);
		xmlhttp.send();
	}
	window.onload = show(1);

	function soluongne(p) {
		var search = document.getElementById("search").value;
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("soluongsize").innerHTML = this.responseText;

			}
		}
		xmlhttp.open("GET", "../Model/product-soluong.php?id_pro=" + p, true);
		xmlhttp.send();


	}
</script>