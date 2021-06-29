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
				<h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
					<li class="breadcrumb-item active">Dashboard</li>
				</ol>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- Start Page Content -->
		<!-- ============================================================== -->
		<!-- Row -->
		<div class="row">
			<div class="col-lg-8">
				<div class="card">
					<div class="card-block">
						<h3>Grafik Agen</h3>
						<h6 class="card-subtitle">May 2021</h6>
						<div id="morris-line-chart"></div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card">
					<div class="card-block">
						<div id="datepicker-inline"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- Row -->
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
<?php $this->load->view('layout/v_footer') ?>
<script>
	jQuery('#datepicker-inline').datepicker({
        todayHighlight: true
    });
	
	$.getJSON("<?php echo site_url('spbe/ajax_graph'); ?>", function (json) { 
		var line = new Morris.Line({
					// ID of the element in which to draw the chart.
					element: 'morris-line-chart',
					// Chart data records -- each entry in this array corresponds to a point on
					// the chart.
					data: json,
					// The name of the data record attribute that contains x-values.
					xkey: 'tanggal',
					// A list of names of data record attributes that contain y-values.
					ykeys: ['jumlah_tabung'],
					// Labels for the ykeys -- will be displayed when you hover over the
					// chart.
					labels: ['Jumlah Tabung'],
					gridLineColor: '#eef0f2',
					lineColors: ['#009efb'],
					lineWidth: 1,
					hideHover: 'auto'
				});
	});
</script>
