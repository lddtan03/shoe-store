<section class="content-header">
	<div class="content-header-left">
		<h1>Quản lý tài khoản</h1>
	</div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<section class="content">

	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<div class="wrap col-md-12">
						<div class="m-5 ">
							<form>			
								<div class="">Search <input type="text" id="search" placeholder="ID or Name"><input type="button" value="Tim" id="tim" onclick="show(1)"></div>
							</form>
						</div>
						<table class="table align-middle mb-0 bg-white text-center  table-bordered table-hover table-striped" id="example1">
							<thead class="bg-light">
								<tr>
                                    <th class="col-md-1">ID</th>
                                    <th class="col-md-3">Thông tin</th>
                                    <th class="col-md-3">Tài khoản</th>
                                    <th class="col-md-2">Chức vụ</th>
									<th class="col-md-2">Trạng thái</th>
									<th class="col-md-1">Actions</th>
								</tr>
							</thead>
							<tbody id="dulieu">

							</tbody>
						</table>
						<nav aria-label="Page navigation">
							<ul class="pagination" id="trang">
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
				Are you sure want to delete this item?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-ok">Delete</a>
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
		xmlhttp.open("GET", "../Model/taikhoan-tk-pt.php?p=" + p + "&search=" + search, true);
		xmlhttp.send();
	}
	window.onload = show(1);
	function doitt(id_user) {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
			}
		}

		xmlhttp.open("GET", "../Model/doitt.php?id_user="+id_user, true);
		xmlhttp.send();
		location.reload();
	}
</script>