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
				<h3 class="text-themecolor m-b-0 m-t-0">Cetak Laporan</h3>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
					<li class="breadcrumb-item active">Cetak Laporan</li>
				</ol>
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
						<div class="form-group row">
							<div class="col-5">
								<div class="input-daterange input-group" id="date-range">
									<input type="text" class="form-control pull-right input-lg" id="range_tanggal" value="">
								</div>
							</div>
							<div class="col-3">
								<button id="search" class="btn btn-success waves-effect" data-dismiss="modal"><i class="fa fa-eye"></i></button>
							</div>
						</div>							
						<div class="table-responsive m-t-40">
							<table id="tblLaporan" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>No Reg</th>
										<th>Nama</th>
										<th>Tanggal</th>
										<th>Jumlah Tabung</th>
										<th>Pengambilan</th>
									</tr>
								</thead>
								<tbody id="data_gas"></tbody>
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
$(function() {
	// Daterange picker
	var start_date = '<?php echo date('Y-m-d') ?>';
	var end_date = '<?php echo date('Y-m-d') ?>';

	$('#range_tanggal').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            start_date = start.format('YYYY-MM-DD');
            end_date = end.format('YYYY-MM-DD');
        });

	$('#search').click(function() {
		$('#data_gas').empty();
		$('#tblLaporan').DataTable().destroy();
		if (start_date && end_date) {
			$.ajax({
				url: '<?php echo site_url() ?>Spbe/search_list_laporan',
				data: {
					start_date: start_date,
					end_date: end_date
				},
				type: 'GET',
				dataType: 'JSON',
				success: function(res) {
					let data_gas = res.table;
					console.log(res.table);
					$('#data_gas').empty();
					$('#tblLaporan').DataTable().destroy();
					
					for (let x = 0; x < data_gas.length; x++) {
						$('#data_gas').append('<tr>\
								<td>' + data_gas[x].no_reg + '</td>\
								<td>' + data_gas[x].nama + '</td>\
								<td>' + data_gas[x].tanggal_pengambilan + '</td>\
								<td>' + data_gas[x].jumlah_tabung + '</td>\
								<td>' + data_gas[x].status_pengambilan + '</td>\
								</tr>');
					}
					$('#tblLaporan').DataTable({
						'paging': true,
						'searching': true,
						'ordering': true,
						"lengthMenu": [10, 25, 50, 100],
						'info': true,
						'autoWidth': false,
						'dom': 'Blfrtip',
						'buttons': [
							'excelHtml5',
							'pdfHtml5'
						]
					})
				},
				error: function(res) {
					console.log(res)
				}
			});
		}
	});

    $.ajax({
			url: '<?php echo site_url() ?>Spbe/list_laporan',
			type: 'GET',
			dataType: 'JSON',
			success: function(res) {
				let data_gas = res.table;
				console.log(res.table);
				
				for (let x = 0; x < data_gas.length; x++) {
					$('#data_gas').append('<tr>\
							<td>' + data_gas[x].no_reg + '</td>\
							<td>' + data_gas[x].nama + '</td>\
							<td>' + data_gas[x].tanggal_pengambilan + '</td>\
							<td>' + data_gas[x].jumlah_tabung + '</td>\
							<td>' + data_gas[x].status_pengambilan + '</td>\
							</tr>');

				}
				$('#tblLaporan').DataTable({
					'paging': true,
					'searching': true,
					'ordering': true,
					"lengthMenu": [10, 25, 50, 100],
					'info': true,
					'autoWidth': false,
					'dom': 'Blfrtip',
					'buttons': [
						'excelHtml5',
						'pdfHtml5'
					]
				})
			},
			error: function(res) {
				console.log(res)
			}
		});

	
});
</script>

<?php $this->load->view('layout/v_footer') ?>
