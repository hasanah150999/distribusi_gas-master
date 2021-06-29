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
				<h3 class="text-themecolor m-b-0 m-t-0">Monitoring Agen</h3>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
					<li class="breadcrumb-item active">Monitoring Agen</li>
				</ol>
			</div>
			<div class="col-md-6 col-4 align-self-center">
				<button class="btn pull-right hidden-sm-down btn-success" data-toggle="modal" data-target="#modalPengambilanAgen"><i class="mdi mdi-plus-circle"></i> Pengambilan Agen</button>			
			</div>
			<div class="modal fade bs-example-modal-lg" tabindex="-1" id="modalPengambilanAgen" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="myLargeModalLabel">Pengambilan Agen</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						</div>
						<?php echo form_open_multipart('Spbe/pickup_gas', 'role="form" id="pickup_gas" class="modal-body"') ?>
							<div class="modal-body">
								<div class="form-group">
									<label for="message-text" class="control-label">Agen:</label>
									<!-- <input type="text" class="form-control" name="nama_agen" id="nama"> -->
									<?php
										$atribut_agen = 'class="agen" style="width:100%" required="required"';
										echo form_dropdown('agen', $namaAgen, '', $atribut_agen);
									?>
								</div>
								<div class="form-group">
									<label for="message-text" class="control-label">Jumlah Pengambilan:</label>
									<input type="number" class="form-control" name="jumlah_ambil" id="jumlah_ambil" required>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
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
						<div id="message"></div>
						<div class="table-responsive m-t-40">
							<table id="tblMonitoring" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>No Reg</th>
										<th>Nama</th>
										<th>Pengambilan</th>
										<th>Total Tabung</th>
										<th>Tanggal Pengambilan</th>
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
		$('.agen').select2({
			placeholder : "Pilih Agen",
			dropdownParent: $('#modalPengambilanAgen')
		})

		$('#pickup_gas').submit(function(e) {
			e.preventDefault();

			$.ajax({
				url : $(this).attr('action'),
				type : 'POST',
				data : new FormData(this),
				contentType : false,
				cache : false,
				processData : false,
				success : function(data) {
					document.getElementById('pickup_gas').reset();
					$('#pickup_gas').trigger("reset");
					$('#message').html('<div class="alert alert-info alert-dismissible" role="alert><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Berhasil</strong> ' + data.message + '</div>');
					$('#modalPengambilanAgen').modal('hide');
					console.log(data);
				},
				error : function(data) {
					$('#message').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Gagal</strong>  ' + data.message + ' </div>');
					$('#modalPengambilanAgen').modal('hide');
				}
			});
		});

        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $('#tblMonitoring').DataTable({
        'paging': true,
		'searching': true,
		'ordering': true,
		'info': true,
		"lengthMenu": [10, 25, 50, 100],
		'autoWidth': false,
		"processing": true,
		'serverSide': true,
		"ajax": "<?php echo site_url() ?>Spbe/list_monitoing",
    });
</script>

<?php $this->load->view('layout/v_footer') ?>
