<?php $this->load->view('layout/v_header') ?>
<!-- Page wrapper  -->
<div class="page-wrapper">
	<!-- Container fluid  -->
	<div class="container-fluid">
		<!-- Bread crumb and right sidebar toggle -->
		<div class="row page-titles">
			<div class="col-md-6 col-8 align-self-center">
				<h3 class="text-themecolor m-b-0 m-t-0">Info Agen</h3>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
					<li class="breadcrumb-item active">Info Agen</li>
				</ol>
			</div>
			<div class="col-md-6 col-4 align-self-center">
				<button class="btn pull-right hidden-sm-down btn-success" data-toggle="modal" data-target="#modalTambahAgen"><i class="mdi mdi-plus-circle"></i> Tambah Agen</button>			
			</div>
			<!-- Start modal tambah data agen -->
			<div class="modal fade bs-example-modal-lg" id="modalTambahAgen">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myLargeModalLabel">Tambah Data Agen</h4>
							<button type="button" id="btnCloseX" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</div>
						<?php echo form_open_multipart('Spbe/store_agen', 'role="form" id="create_agen" class="modal-body"') ?>
						<div class="form-group">
							<label for="nomor_regis_agen" class="control-label">No Reg:</label>
							<input type="number" class="form-control" name="no_regis_agen" placeholder="Masukan Nomor Registrasi" required>
						</div>
						<div class="form-group">
							<label for="nama_agen" class="control-label">Nama:</label>
							<input type="text" class="form-control" name="nama_agen" placeholder="Masukan Nama Agen" required>
						</div>
						<div class="form-group">
							<label for="alamat_agen" class="control-label">Alamat:</label>
							<textarea class="form-control" name="alamat_agen" placeholder="Masukan Alamat Agen" required></textarea>
						</div>
						<!-- <div class="form-group">
							<label for="data_ktp" class="control-label">Data KTP:</label>
							<input type="text" class="form-control" name="data_ktp" id="data_ktp" placeholder="Silahkan Tapping KTP" readonly>
						</div> -->
						<div class="form-group">
							<label for="username" class="control-label">Username Agen:</label>
							<input type="text" class="form-control" name="username" placeholder="Masukan Username Agen" required>
						</div>
						<div class="form-group">
							<label for="password" class="control-label">Password:</label>
							<input type="password" class="form-control" name="password_baru" placeholder="Masukan Password" required>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default waves-effect" id="btnClose" data-dismiss="modal">Batal</button>
							<button type="submit" id="btnSubmit" class="btn btn-success waves-effect waves-light">Simpan</button>
						</div>
						<?php  echo form_close(); ?>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->

			</div>
			<!-- End modal tambah data agen -->
			<!-- Start modal tambah data agen -->
			<div class="modal fade bs-example-modal-lg" id="modalEditAgen">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myLargeModalLabel">Edit Data Agen</h4>
							<button type="button" id="btnCloseXEdit" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</div>
						<?php echo form_open_multipart('Spbe/store_agen', 'role="form" id="update_agen" class="modal-body"') ?>
						<input type="hidden" name="id" id="id_agen" required>
						<input type="hidden" name="id_pengguna" id="id_pengguna" required>
						<div class="form-group">
							<label for="nomor_regis_agen" class="control-label">No Reg:</label>
							<input type="number" class="form-control" name="no_regis_agen" id="nomor_regis_agen" placeholder="Masukan Nomor Registrasi" required>
						</div>
						<div class="form-group">
							<label for="nama_agen" class="control-label">Nama:</label>
							<input type="text" class="form-control" name="nama_agen" id="nama_agen" placeholder="Masukan Nama Agen" required>
						</div>
						<div class="form-group">
							<label for="alamat_agen" class="control-label">Alamat:</label>
							<textarea class="form-control" name="alamat_agen" id="alamat_agen" placeholder="Masukan Alamat Agen" required></textarea>
						</div>
						<!-- <div class="form-group">
							<label for="data_ktp" class="control-label">Data KTP:</label>
							<div id="data_ktp_label"></div>
							<input type="text" class="form-control" name="data_ktp" id="data_ktp_edit" placeholder="Silahkan Tapping KTP" readonly>
						</div> -->
						<div class="form-group">
							<label for="username" class="control-label">Username Agen:</label>
							<input type="text" class="form-control" name="username" id="username" placeholder="Masukan Username Agen" required>
						</div>
						<div class="form-group">
							<label for="password" class="control-label">Password Baru:</label>
							<input type="password" class="form-control" name="password_baru" id="password_baru" placeholder="Masukan Password Baru" required> 
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default waves-effect" id="btnCloseEdit" data-dismiss="modal">Batal</button>
							<button type="submit" id="btnEdit" class="btn btn-success waves-effect waves-light">Simpan</button>
						</div>
						<?php  echo form_close(); ?>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->

			</div>
			<!-- End modal tambah data agen -->
		</div>
		<!-- End Bread crumb and right sidebar toggle -->
		<!-- Start Page Content -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-block">
						<div id="message"></div>
						<div class="table-responsive m-t-40">
							<table id="tblAgen" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>No Reg</th>
										<th>Nama</th>
										<th>Alamat</th>
										<th>Jumlah Pengguna Tabung Gas</th>
										<th>Total Pelanggan</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>null</td>
										<td>null</td>
										<td>null</td>
										<td>null</td>
										<td>null</td>
										<td>null</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End PAge Content -->
	</div>
	<!-- End Container fluid  -->
	<!-- footer -->
	<footer class="footer">
		Hak Cipta © 2021 - Si Istri GasUdi
	</footer>
	<!-- End footer -->
</div>
<!-- End Page wrapper  -->
<?php $this->load->view('layout/js_only') ?>
<script>
	$(function() {
		$('#tblAgen').DataTable().destroy();

		$('#tblAgen').DataTable({
			'paging': true,
			'searching': true,
			'ordering': true,
			'info': true,
			"lengthMenu": [10, 25, 50, 100],
			'autoWidth': false,
			"processing": true,
			'serverSide': true,
			"ajax": "<?php echo site_url() ?>Spbe/list_agen",
			"fnDrawCallback": function() {
				$('.edit_agen').click(function(e) {
					e.preventDefault();
					var id = $(this).data('id');
					$.ajax({
						url : '<?php echo site_url() ?>Spbe/detail_agen/' + id,
						type : "GET",
						dataType : 'JSON',
						success : function(data) {
							let agen = data.message[0];
							let list = '';
							console.log(agen);
							if(data.status == "success") {
								console.log('success to fetch');
								$('#id_agen').val(agen.id_agen);
								$('#nomor_regis_agen').val(agen.no_reg);
								$('#nama_agen').val(agen.nama);
								$('#alamat_agen').val(agen.alamat);
								$('#username').val(agen.username);
								// $('#data_ktp_label').val(agen.data_rfid);
								// $('#data_ktp_label').html('<p><strong>Data sebelumnya</strong> ' + agen.data_rfid + '</p>');
								$('#id_pengguna').val(agen.id_pengguna);
							} else {
								console.log('failed to fetch');
							}
						},
						error : function(data) {
							console.log(data);
							alert('Gagal, Silahkan Coba Kembali');
						}
					});
				})

				$('.delete_agen').click(function(e) {
					e.preventDefault();
					var id = $(this).data('id');
					var conf_del = confirm('Anda yakin akan menghapus agen?');

					if (conf_del == true) {
						$.ajax({
							url: '<?php echo site_url() ?>Spbe/delete_agen',
							type: 'POST',
							dataType: 'JSON',
							data: {
								id: id
							},
							success: function(data) {
								if (data.status == 'success') {
									$('#message').html('<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Berhasil</strong> ' + data.message + '</div>');
									$('#tblUser').DataTable().draw();
								} else {
									$('#message').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Gagal</strong> ' + data.message + '</div>');
								}
							},
							error: function(data) {
								alert("Gagal, Silahkan Coba Kembali");
							}
						})
					}
				})
			}
		});
		
		$('#create_agen').submit(function(e) {
			e.preventDefault();

			$.ajax({
				url: $(this).attr('action'),
				type: 'POST',
				data: new FormData(this),
				dataType: 'JSON',
				contentType: false,
				cache: false,
				processData: false,
				success : function(data) {
					if(data.status == 'success') {
						$(document).ready(function() {
							document.getElementById('create_agen').reset();
							$('#create_agen').trigger("reset");
							$('#message').html('<div class="alert alert-info alert-dismissible" role="alert><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Berhasil</strong> ' + data.message + '</div>');
							$('#tblAgen').DataTable().destroy();
							$('#tblAgen').DataTable().draw();
							$('#modalTambahAgen').modal('hide');
						});
					} 
					else {
						$(document).ready(function() {
							// Message failed here
							$('#message').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Gagal</strong> ' + data.message + '</div>');
							$('#modalTambahAgen').modal('hide');
						});
					}
				},
				error : function(data) {
					// Message failed here
					$(document).ready(function() {
						$('#message').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Gagal</strong> ' + data.message + '</div>');
						$('#modalTambahAgen').modal('hide');
					});
				}
			});
		});
		
		$('#update_agen').submit(function(e) {
			e.preventDefault();

			$.ajax({
				url: $(this).attr('action'),
				type: 'POST',
				data: new FormData(this),
				dataType: 'JSON',
				contentType: false,
				cache: false,
				processData: false,
				success : function(data) { 
					if(data.status == 'success') {
						$(document).ready(function() {
							document.getElementById('update_agen').reset();
							$('#update_agen').trigger("reset");
							$('#message').html('<div class="alert alert-info alert-dismissible" role="alert><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Berhasil</strong> ' + data.message + '</div>');
							$('#tblAgen').DataTable().destroy();
							$('#tblAgen').DataTable().draw();
							$('#modalEditAgen').modal('hide');
						});
					} else {
						$(document).ready(function() {
							// Message failed here
							$('#message').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Gagal</strong> ' + data.message + '</div>');
							$('#modalEditAgen').modal('hide');
						});
					}
				}, 
				error : function(data) {
					// Message failed here
					$(document).ready(function() {
						// $('#message').html('<div class="alert alert-danger alert-dismissible"><strong>Gagal</strong> ' + data.message + ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>');
						$('#message').html('<div class="alert alert-info alert-dismissible" role="alert><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Berhasil</strong> Update Data Agen</div>');
						$('#modalEditAgen').modal('hide');
					});
				}
			});
		});

		function listenerRfid() {
			$.ajax({
				url : '<?php echo site_url() ?>Spbe/get_rfid_daftar',
				success : function (res) {
					let json = JSON.parse(res);
					// alert(json);
					$('#data_ktp, #data_ktp_edit').val(json);
				}
			});
			setTimeout(listenerRfid, 1000);
		}

		function drawTable() {
			$('#tblAgen').DataTable().draw();
		}

		$('#btnCloseX, #btnClose, #btnCloseXEdit, #btnCloseEdit').on('click', function(e) {
			e.preventDefault();
			$.ajax({
				url : '<?php echo site_url() ?>Spbe/refresh_rfid',
			});
		});

		setTimeout(listenerRfid, 1000);
		setTimeout(drawTable, 1000);
	});

    $(document).ready(function() {
		
        // $('#tblAgen').DataTable();

    });

	// Second Way
	/** 
		$("#data_ktp").load('<?php // echo base_url('assets/') ?>RfidText.php');
			setInterval(function() {
			$("#data_ktp").load('<?php // echo base_url('assets/') ?>RfidText.php');	
		}, 500);
	*/
</script>

<?php $this->load->view('layout/v_footer') ?>
