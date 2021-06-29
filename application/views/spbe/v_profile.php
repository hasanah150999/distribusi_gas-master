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
				<h3 class="text-themecolor m-b-0 m-t-0">Kelola Profile</h3>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
					<li class="breadcrumb-item active">Kelola Profile</li>
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
			<!-- Column -->
			<div class="col-lg-4 col-xlg-3 col-md-5">
				<div class="card">
					<div class="card-block">
						<center class="m-t-30"> <img src="<?php echo base_url()?>uploads/profile/<?php echo $this->session->userdata('photo');?>" onerror="this.onerror=null;this.src='<?php echo base_url()?>assets/images/users/default_picture.png';" class="img-circle" width="150" />
							<h4 class="card-title m-t-10"><?php echo $this->session->userdata('name'); ?></h4>
							<h6 class="card-subtitle"><?php echo $this->session->userdata('role'); ?></h6>
						</center>
					</div>
					<div>
						<hr> </div>
					<div class="card-block"> 
						<small class="text-muted">Username </small>
						<h6><?php echo $this->session->userdata('username'); ?></h6> 
					</div>
				</div>
			</div>
			<!-- Column -->
			<!-- Column -->
			<div class="col-lg-8 col-xlg-9 col-md-7">
				<div class="card">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs profile-tab" role="tablist">
						<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#settings" role="tab">Edit Profile</a> </li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane active" id="settings" role="tabpanel">
							<div class="card-block">
								<?php echo form_open_multipart('Spbe/update_profile','role="form" class="form-horizontal form-material" id="update_user" ') ?>
									<input type="hidden" value="<?php echo $this->session->userdata('id'); ?>" name="id" id="id">
									<div class="form-group">
										<label for="example-email" class="col-md-12">Username</label>
										<div class="col-md-12">
											<input type="text" name="username" value="<?php echo $this->session->userdata('username'); ?>" placeholder="(Username sebelumnya: username)" class="form-control form-control-line" name="example-email" id="example-email">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-12">Password</label>
										<div class="col-md-12">
											<input type="password" name="password" placeholder="Masukan Password Baru" class="form-control form-control-line">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-12">Upload Foto Profile</label>
										<div class="col-md-12">
											<input type="file" accept="image/*" name="image" id="image" placeholder="Pilih File" class="form-control form-control-line">
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-12">
											<button class="btn btn-success">Update Profile</button>
										</div>
									</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Column -->
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
