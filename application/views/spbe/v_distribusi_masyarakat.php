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
				<h3 class="text-themecolor m-b-0 m-t-0">Cek Distribusi Agen</h3>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
					<li class="breadcrumb-item active">Cek Distribusi Agen</li>
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
						<div class="table-responsive m-t-40">
							<table id="tblDistribusi" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>No Reg</th>
										<th>Nama</th>
										<th>Jumlah Tabung</th>
										<th>Jumlah Pelanggan</th>
										<th>Lihat Detail</th>
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
        $('#tblDistribusi').DataTable().destroy();

		$('#tblDistribusi').DataTable({
			'paging': true,
			'searching': true,
			'ordering': true,
			'info': true,
			"lengthMenu": [10, 25, 50, 100],
			'autoWidth': false,
			"processing": true,
			'serverSide': true,
			"ajax": "<?php echo site_url() ?>Spbe/list_distribusi"
		});
    });
</script>

<?php $this->load->view('layout/v_footer') ?>
