<?php $this->load->view('layout/v_header') ?>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
	<!-- ============================================================== -->
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<!-- ============================================================== -->
		<!-- Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<div class="row page-titles">
			<div class="col-md-6 col-8 align-self-center">
				<h3 class="text-themecolor m-b-0 m-t-0">Distribusi Masyarakat</h3>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
					<li class="breadcrumb-item active">Distribusi Masyarakat</li>
				</ol>
			</div>
			<div class="col-md-6 col-4 align-self-center">
				<!-- <button class="right-side-toggle waves-effect waves-light btn pull-right hidden-sm-down btn-success" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus-circle"></i> Tambah Pelanggan</button> -->
				<button class=" btn-success pull-right waves-effect waves-light hidden-sm-down m-l-10" data-toggle="modal" data-target="#modalTambahBeli"><i class="mdi mdi-plus-circle"></i> Pembellian Tabung</button>			
			</div>
			<div class="modal fade bs-example-modal-lg" tabindex="-1" id="modalTambahBeli" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myLargeModalLabel">Pengambilan Tabung Pelanggan</h4>
							<button type="button" id="btnBatalX" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</div>
						<?php echo form_open_multipart('Agen/store_distribusi', 'role="form" id="store_pickup" class="modal-body"') ?>
							<div class="modal-body">
								<input type="hidden" name="id_agen" value="<?php echo $this->session->userdata('id_agen'); ?>">
								<input type="hidden" name="id_pelanggan" id="id_pelanggan">								
								<div class="form-group">
									<label for="nik_beli" class="control-label">Data KTP:</label>
									<input type="text" class="form-control" id="nik_beli" name="nik_beli" required readonly>
								</div>
								<div class="form-group">
									<label for="nama_beli" class="control-label">Nama:</label>
									<input type="text" class="form-control" name="nama_beli" id="nama_beli" required readonly>
								</div>
								<div class="form-group">
									<label for="email_beli" class="control-label">Email:</label>
									<input type="email" class="form-control" name="email_beli" id="email_beli" required readonly>
								</div>
								<div class="form-group">
									<label for="jumlah_beli" class="control-label">Jumlah Pengambilan:</label>
									<input type="number" class="form-control" name="jumlah_beli" id="jumlah_beli" required>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" id="btnBatal" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
								<button type="submit" class="btn btn-success waves-effect waves-light">Ambil</button>
							</div>
						<?php echo form_close(); ?>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- Start Page Content -->
		<!-- ============================================================== -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-block">
						<h4 class="card-title">Data Distribusi Pelanggan</h4>
						<div id="message"></div>
						<div class="table-responsive m-t-40">
							<table id="tblGas" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>NIK</th>
										<th>Nama</th>
										<th>Status</th>
										<th>Tanggal Pengambilan</th>
										<th>Jumlah Tabung Gas</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>XXXXX-121</td>
										<td>System Architect</td>
										<td>Selesai</td>
										<td>01-05-2021</td>
										<td>3</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End PAge Content -->
		<!-- ============================================================== -->
	</div>
	<!-- ============================================================== -->
	<!-- End Container fluid  -->
	<!-- ============================================================== -->
	<!-- ============================================================== -->
	<!-- footer -->
	<!-- ============================================================== -->
	<footer class="footer">
		Hak Cipta © 2021 - Si Istri GasUdi
	</footer>
	<!-- ============================================================== -->
	<!-- End footer -->
	<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
<?php $this->load->view('layout/js_only') ?>
<script>
	$(document).ready(function() {
		$('#tblGas').DataTable().destroy();

		$('#tblGas').DataTable({
			'paging': true,
			'searching': true,
			'ordering': true,
			'info': true,
			"lengthMenu": [10, 25],
			'autoWidth': false,
			"processing": true,
			'serverSide': true,
			"ajax": "<?php echo site_url() ?>Agen/list_distribusi",
			// dom: 'Bfrtip',
			// buttons: [

			// ]
		});

		function listenerRfid() {
			$.ajax({
				url : '<?php echo site_url() ?>Agen/get_rfid_distribusi',
				success : function (res) {
					// alert(res);
					let json = JSON.parse(res);

					$('#nik_beli').val(json[0]["nik"]);
					$('#nama_beli').val(json[0]["nama"]);
					$('#id_pelanggan').val(json[0]["id_pelanggan"]);
					$('#email_beli').val(json[0]["email_pelanggan"]);
				}
			});
			setTimeout(listenerRfid, 1000);
		}

		setTimeout(listenerRfid, 1000);

		$('#btnBatalX, #btnBatal').on('click', function(e) {
			e.preventDefault();
			$.ajax({
				url : '<?php echo site_url() ?>Agen/refresh_rfid',
				success : function (res) {
					$('#nik_beli').val();
					$('#nama_beli').val();
				}
			});
		});

		$('#store_pickup').submit(function(e) {
			e.preventDefault();
			
			$.ajax({
				url : $(this).attr('action'),
				type : 'POST',
				data : new FormData(this),
				dataType : 'JSON',
				contentType : false,
				cache : false,
				processData : false,
				success : function(data) {
					if(data.status === 'success') {
						document.getElementById('store_pickup').reset();
						$('#store_pickup').trigger("reset");
						$('#message').html('<div class="alert alert-info alert-dismissible" role="alert><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Berhasil</strong> ' + data.message + '</div>');
						$('#modalTambahBeli').modal('hide');
					} else {
						$('#message').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Gagal</strong> ' + data.message + ' </div>');
						$('#modalTambahBeli').modal('hide');
					}
				}
			});
		});
	});
</script>

<?php $this->load->view('layout/v_footer') ?>
