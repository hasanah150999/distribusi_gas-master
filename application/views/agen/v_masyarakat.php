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
				<button class=" btn-success pull-right waves-effect waves-light hidden-sm-down m-l-10" data-toggle="modal" data-target="#modalTambahPelanggan"><i class="fa fa-plus-circle"></i> Tambah Pelanggan</button>
			</div>
			<div class="modal fade bs-example-modal-lg" id="modalTambahPelanggan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myLargeModalLabel">Tambah Pelanggan</h4>
							<button type="button" id="btnCloseXTambah" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</div>
						<?php echo form_open_multipart('Agen/store_pelanggan', 'role="form" id="create_pelanggan" class="modal-body"') ?>
							<div class="modal-body">
								<input type="hidden" name="agen_id" value="<?php echo $this->session->userdata('id_agen'); ?> " required>
								<div class="form-group">
									<label for="message-text" class="control-label">NIK:</label>
									<input type="text" class="form-control" name="nik" placeholder="Masukan NIK" id="nik" required>
								</div>
								<div class="form-group">
									<label for="message-text" class="control-label">Nama:</label>
									<input type="text" class="form-control" name="nama" placeholder="Masukan Nama" id="nama" required>
								</div>
								<div class="form-group">
									<label for="message-text" class="control-label">Email:</label>
									<input type="email" class="form-control" name="email" placeholder="Masukan Email" id="email" required>
								</div>
								<div class="form-group">
									<label for="message-text" class="control-label">Alamat:</label>
									<textarea class="form-control" name="alamat" id="alamat"></textarea>
								</div>
								<div class="form-group row">
									<div class="col-sm-3">
										<label for="message-text" class="control-label">RT:</label>
										<input type="text" class="form-control" placeholder="Masukan RT" name="rt" id="rt" required>
									</div>
									<div class="col-sm-3">
										<label for="message-text" class="control-label">RW:</label>
										<input type="text" class="form-control" placeholder="Masukan RW" name="rw" id="rw" required>
									</div>
									<div class="col-sm-6">
										<label>Provinsi</label>
										<!-- <select class="select2" name="provinsi" id="provinsi" style="width: 100%;">
										</select> -->
										<?php
											$atribut_Prov = 'class="provinsi" style="width:100%"';
											echo form_dropdown('provinsi', $namaProvinsi, '', $atribut_Prov);
										?>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-4">
										<label for="message-text" class="control-label">Kota / Kab:</label>
										<!-- <select class="select2" name="kab_kot" id="kab_kot" style="width: 100%;">
										</select> -->
										<?php
											$atribut_kota = 'class="kab_kota" id="kotaid" style="width:100%"';
											echo form_dropdown('kab_kota', $namaKota, '', $atribut_kota);
										?>
									</div>
									<div class="col-sm-4">
										<label for="message-text" class="control-label">Kecamatan:</label>
										<!-- <select class="select2" name="kecamatan" id="kecamatan" style="width: 100%;">
										</select> -->
										<?php
											$atribut_kecamatan = 'class="kecamatan" id="kecid" style="width:100%"';
											echo form_dropdown('kecamatan', $namaKecamatan, '', $atribut_kecamatan);
										?>
									</div>
									<div class="col-sm-4">
										<label>Kelurahan / Desa</label>
										<!-- <select class="select2" name="kel_des" id="kel_des" style="width: 100%;">
										</select> -->
										<?php
											$atribut_kelurahan = 'class="kelurahan" id="kelid" style="width:100%"';
											echo form_dropdown('kelurahan', $namaKelurahan, '', $atribut_kelurahan);
										?>
									</div>
								</div>
								<div class="form-group">
									<label for="message-text" class="control-label">Data RFID:</label>
									<input type="text" class="form-control" name="data_ktp" placeholder="Tapping Kartu" readonly id="data_ktp" required>
								</div>							
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default waves-effect" id="btnCloseTambah" data-dismiss="modal">Batal</button>
								<button type="submit" id="btnSubmit" class="btn btn-success waves-effect waves-light">Tambah</button>
							</div>
						<?php echo form_close(); ?>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<div class="modal fade bs-example-modal-lg" id="modalEditPelanggan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myLargeModalLabel">Edit Pelanggan</h4>
							<button type="button" id="btnBatalEditX" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</div>
						<?php echo form_open_multipart('Agen/store_pelanggan', 'role="form" id="edit_pelanggan" class="modal-body"') ?>
							<input type="hidden" class="form-control" name="id" id="id_edit">
							<div class="form-group">
								<label for="message-text" class="control-label">NIK:</label>
								<input type="text" class="form-control" name="nik" id="nik_edit" placeholder="Masukan NIK" required>
							</div>
							<div class="form-group">
								<label for="message-text" class="control-label">Nama:</label>
								<input type="text" class="form-control" name="nama" placeholder="Masukan Nama" id="nama_edit" required>
							</div>
							<div class="form-group">
								<label for="message-text" class="control-label">Email:</label>
								<input type="email" class="form-control" name="email" placeholder="Masukan Email" id="email_edit" required>
							</div>
							<div class="form-group">
								<label for="message-text" class="control-label">Alamat:</label>
								<textarea class="form-control" name="alamat"  id="alamat_edit"></textarea>
							</div>
							<div class="form-group">
								<label for="message-text" class="control-label">Ubah Data Wilayah:</label>
								<input type="checkbox" class="" id="cek" name="cek" value="change">
							</div>
							<div class="form-group row">
								<div class="col-sm-3">
									<label for="message-text" class="control-label">RT:</label>
									<input type="text" class="form-control" name="rt" placeholder="Masukan RT" id="rt_edit">
								</div>
								<div class="col-sm-3">
									<label for="message-text" class="control-label">RW:</label>
									<input type="text" class="form-control" name="rw" placeholder="Masukan RW" id="rw_edit">
								</div>
								<div class="col-sm-6">
									<label>Provinsi</label>
									<!-- <select class="select2" name="provinsi" id="provinsi" style="width: 100%;">
									</select> -->
									<?php
										$atribut_Prov = 'class="provinsi" disabled id="provinsi_edit" style="width:100%"';
										echo form_dropdown('provinsi', $namaProvinsi, '', $atribut_Prov);
									?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-4">
									<label for="message-text" class="control-label">Kota / Kab:</label>
									<!-- <select class="select2" name="kab_kot" id="kab_kot" style="width: 100%;">
									</select> -->
									<?php
										$atribut_kota = 'class="kab_kota" disabled id="kotaid_edit" style="width:100%"';
										echo form_dropdown('kab_kota', $namaKota, '', $atribut_kota);
									?>
								</div>
								<div class="col-sm-4">
									<label for="message-text" class="control-label">Kecamatan:</label>
									<!-- <select class="select2" name="kecamatan" id="kecamatan" style="width: 100%;">
									</select> -->
									<?php
										$atribut_kecamatan = 'class="kecamatan" disabled id="kecid_edit" style="width:100%"';
										echo form_dropdown('kecamatan', $namaKecamatan, '', $atribut_kecamatan);
									?>
								</div>
								<div class="col-sm-4">
									<label>Kelurahan / Desa</label>
									<!-- <select class="select2" name="kel_des" id="kel_des" style="width: 100%;">
									</select> -->
									<?php
										$atribut_kelurahan = 'class="kelurahan" disabled id="kelid_edit" style="width:100%"';
										echo form_dropdown('kelurahan', $namaKelurahan, '', $atribut_kelurahan);
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="data_ktp" class="control-label">Data RFID:</label>
								<input type="text" class="form-control" placeholder="Tapping Kartu" readonly name="data_ktp_edit" id="data_ktp_edit">
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default waves-effect" id="btnBatalEdit" data-dismiss="modal">Batal</button>
								<button type="submit" id="btnEdit" class="btn btn-success waves-effect waves-light">Ubah</button>
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
						<h4 class="card-title">Data Pelanggan</h4>
						<div id="message"></div>
						<div class="table-responsive m-t-40">
							<table id="tblPelanggan" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>NIK</th>
										<th>Nama</th>
										<th>Alamat</th>
										<th>Tanggal Daftar</th>
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
		$('#tblPelanggan').DataTable().destroy();

		$('#tblPelanggan').DataTable({
			'paging': true,
			'searching': true,
			'ordering': true,
			'info': true,
			"lengthMenu": [10, 25],
			'autoWidth': false,
			"processing": true,
			'serverSide': true,
			"ajax": "<?php echo site_url() ?>Agen/list_pelanggan",
			"fnDrawCallback": function() {
				$('.delete_pelanggan').click(function(e) {
					e.preventDefault();
					var id = $(this).data('id');
					var conf_del = confirm('Anda yakin akan menghapus pelanggan?');

					if (conf_del == true) {
						$.ajax({
							url: '<?php echo site_url() ?>Agen/delete_pelanggan',
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

				$('.edit_pelanggan').click(function(e) {
					e.preventDefault();
					var id = $(this).data('id');
					$.ajax({
						url : '<?php echo site_url() ?>Agen/detail_pelanggan/' + id,
						type : "GET",
						dataType : 'JSON',
						success : function(data) {
							let pelangan = data.message[0];
							let list = '';
							$.ajax({
								url : '<?php echo site_url() ?>Agen/rfid?data_alat=' + pelangan.data_rfid,
								type : "GET",
								success : function(data) {
									console.log('Berhasil Send RFID detail');
								},
								error : function(data) {
									console.log('Kirim RFID Gagal');
								}
							});
							console.log(pelangan);
							if(data.status == "success") {
								console.log('success to fetch');
								$('#id_edit').val(pelangan.id_pelanggan);
								$('#nik_edit').val(pelangan.nik);
								$('#nama_edit').val(pelangan.nama);
								$('#email_edit').val(pelangan.email_pelanggan);
								$('#alamat_edit').val(pelangan.alamat);
								$('#rt_edit').val(pelangan.rt);
								$('#rw_edit').val(pelangan.rw);
							} else {
								console.log('failed to fetch detail pelanggan');
							}
						},
						error : function(data) {
							console.log('Gagal load data');
						}
					});
				})
			}
		});

		function removeOptions(selectbox){
			var i;
			for(i = selectbox.options.length - 1 ; i >= 0 ; i--) {
				selectbox.remove(i);
			}
		}

		function listenerRfid() {
			$.ajax({
				url : '<?php echo site_url() ?>Agen/get_rfid_daftar',
				success : function (res) {
					let json = JSON.parse(res);
					// alert(json);
					$('#data_ktp, #data_ktp_edit').val(json);
				}
			});
			setTimeout(listenerRfid, 1000);
		}

		setTimeout(listenerRfid, 1000);

		$('#btnCloseXTambah, #btnCloseTambah').on('click', function(e) {
			e.preventDefault();
			$.ajax({
				url : '<?php echo site_url() ?>Agen/refresh_rfid',
			});
		});

		$('#btnBatalEditX', '#btnBatalEdit').on('click', function(e) {
			e.preventDefault();
			$.ajax({
				url : '<?php echo site_url() ?>Agen/refresh_rfid',
			});
		});

		$('#cek').change(function(){
			if($(this).is(":checked"))
			{
				$('#provinsi_edit').attr("disabled",false);
				$('#kotaid_edit').attr("disabled",false);
				$('#kecid_edit').attr("disabled",false);
				$('#kelid_edit').attr("disabled",false);
			}
			else
			{
				$('#provinsi_edit').attr("disabled",true);
				$('#kotaid_edit').attr("disabled",true);
				$('#kecid_edit').attr("disabled",true);
				$('#kelid_edit').attr("disabled",true);
			}
		})

		$('.provinsi').select2({
			placeholder: "Pilih Provinsi",
			dropdownParent: $('#modalTambahPelanggan')
		});

		$('#provinsi_edit').select2({
			placeholder: "Pilih Provinsi",
			dropdownParent: $('#modalEditPelanggan')
		});

		$('.provinsi').on('change', function() {
			var idProv = $(this).val();
			var baseUrl = '<?php echo base_url(); ?>agen/list_kab_kota/'+idProv;
			var kota = [];
			removeOptions(document.getElementById("kotaid"));
			$.ajax({
					url: baseUrl,
					dataType: 'json',
					success: function(datas){
						var kota = $.map(datas, function (obj) {
							obj.id = obj.id || obj.id_kab_kot;
							obj.text = obj.text || obj.nama;
							return obj;
						});
						$(".kab_kota").select2({
							placeholder: "Pilih Kota",
							data: kota
						});
						console.log(kota);
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert("error");
					}
				});
		});

		$('.kab_kota').select2({
			placeholder: "Pilih Kabupaten / Kota",
			dropdownParent: $('#modalTambahPelanggan')
		});

		$('.kab_kota').on('change', function() {
			var idKota = $(this).val();
			var baseUrl = '<?php echo base_url(); ?>agen/list_kecamatan/'+idKota;
			var kec = [];
			removeOptions(document.getElementById("kecid"));
			console.log(idKota);
			$.ajax({
				url: baseUrl,
				dataType: 'json',
				success: function(datas){
					console.log(datas);
					var kec = $.map(datas, function (obj) {
						obj.id = obj.id || obj.id_kec; // replace pk with your identifier
						obj.text = obj.text || obj.nama
						return obj;
					});
					$(".kecamatan").select2({
						placeholder: "Pilih Kecamatan",
						data: kec
					});
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert("error");
				}
			});
		});

		$('.kecamatan').select2({
			placeholder: "Pilih Kecamatan",
			dropdownParent: $('#modalTambahPelanggan')
		});

		$('.kecamatan').on('change', function() {
			var idKecamatan = $(this).val();
			var baseUrl = '<?php echo base_url(); ?>agen/list_kel_des/'+idKecamatan;
			var kelurahan = [];
			removeOptions(document.getElementById("kelid"));
			console.log(idKecamatan);
			$.ajax({
				url: baseUrl,
				dataType: 'json',
				success: function(datas){
					console.log(datas);
					var kelurahan = $.map(datas, function (obj) {
						obj.id = obj.id || obj.id_kel; // replace pk with your identifier
						obj.text = obj.text || obj.nama
						return obj;
					});
					$(".kelurahan").select2({
						placeholder: "Pilih Kelurahan",
						data: kelurahan
					});
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert("error");
				}
			});
		});

		$('.kelurahan').select2({
			placeholder: "Pilih Kelurahan",
			dropdownParent: $('#modalTambahPelanggan')
		});

		$('#create_pelanggan').submit(function(e) {
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
					if (data.status == 'success') {
						document.getElementById('create_pelanggan').reset();
						$('#create_pelanggan').trigger("reset");
						$('#message').html('<div class="alert alert-info alert-dismissible" role="alert><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Berhasil</strong> ' + data.message + '</div>');
						$('#modalTambahPelanggan').modal('hide');
					} else if(data.status == 'failed') {
						$('#message').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Gagal</strong> ' + data.message + ' </div>');
						$('#modalTambahPelanggan').modal('hide');
					} else {
						$('#message').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Gagal</strong> Menambahkan Pelanggan </div>');
						$('#modalTambahPelanggan').modal('hide');
					}

				},
				error : function(data) {
					$('#message').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Gagal</strong> Menambahkan Pelanggan </div>');
					$('#modalTambahPelanggan').modal('hide');
				}
			});

			$.ajax({
				url : '<?php echo site_url() ?>Agen/refresh_rfid',
			});

			$('#create_pelanggan').trigger("reset");
			document.getElementById('create_pelanggan').reset();
		});

		$('#edit_pelanggan').submit(function(e) {
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
					if (data.status == 'success') {
						document.getElementById('edit_pelanggan').reset();
						$('#edit_pelanggan').trigger("reset");
						$('#message').html('<div class="alert alert-info alert-dismissible" role="alert><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Berhasil</strong> Mengubah Data Pelanggan </div>');
						$('#modalEditPelanggan').modal('hide');
					} else if(data.status == 'failed') {
						document.getElementById('edit_pelanggan').reset();
						$('#edit_pelanggan').trigger("reset");
						$('#message').html('<div class="alert alert-info alert-dismissible" role="alert><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Berhasil</strong> Mengubah Data Pelanggan </div>');
						$('#modalEditPelanggan').modal('hide');
					} else {
						document.getElementById('edit_pelanggan').reset();
						$('#edit_pelanggan').trigger("reset");
						$('#message').html('<div class="alert alert-info alert-dismissible" role="alert><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Berhasil</strong> Mengubah Data Pelanggan </div>');
						$('#modalEditPelanggan').modal('hide');
					}

				},
				error : function(data) {
					document.getElementById('edit_pelanggan').reset();
						$('#edit_pelanggan').trigger("reset");
						$('#message').html('<div class="alert alert-info alert-dismissible" role="alert><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Berhasil</strong> Mengubah Data Pelanggan </div>');
						$('#modalEditPelanggan').modal('hide');
				}
			});

			$.ajax({
				url : '<?php echo site_url() ?>Agen/refresh_rfid',
			});

			$('#modalEditAgen').modal('hide');
			document.getElementById('edit_pelanggan').reset();
			$('#edit_pelanggan').trigger("reset");
		});
	});
</script>

<?php $this->load->view('layout/v_footer') ?>
