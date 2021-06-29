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
						<!-- <center class="m-t-30"> <img src="<?php // echo base_url("assets/"); ?>images/users/5.jpg" class="img-circle" width="150" /> -->
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
						<small class="text-muted">Nomor Registrasi </small>
						<h6>AG-<?php echo $this->session->userdata('no_reg'); ?></h6> 
						<small class="text-muted p-t-30 db">Nomor Telepon</small>						
						<h6>+62<?php echo $this->session->userdata('no_telepon'); ?></h6> 
						<small class="text-muted p-t-30 db">Alamat</small>
						<h6><?php echo $this->session->userdata('alamat'); ?></h6>
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
								<!-- <form class="form-horizontal form-material"> -->
								<?php echo form_open_multipart('Agen/update_profile','role="form" class="form-horizontal form-material" id="update_user" ') ?>
									<input type="hidden" value="<?php echo $this->session->userdata('id_agen'); ?>" name="id" id="id_agen">
									<input type="hidden" value="<?php echo $this->session->userdata('id'); ?>" name="id_pengguna" id="id_pengguna">
									<div class="form-group">
										<label class="col-md-12">Nama</label>
										<div class="col-md-12">
											<input type="text" name="nama" value="<?php echo $this->session->userdata('name'); ?>" placeholder="(Nama sekarang: <?php echo $this->session->userdata('name'); ?>)" class="form-control form-control-line">
										</div>
									</div>
									<div class="form-group">
										<label for="example-email" class="col-md-12">Username</label>
										<div class="col-md-12">
											<input type="text" name="username" value="<?php echo $this->session->userdata('username'); ?>" placeholder="(Username sekarang: <?php echo $this->session->userdata('username'); ?>)" class="form-control form-control-line" name="example-email" id="example-email">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-12">Password</label>
										<div class="col-md-12">
											<input type="password" name="password" placeholder="Masukan Password Baru" class="form-control form-control-line">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-12">No Telepon</label>
										<div class="col-md-12">
											<input type="text" name="no_telepon" value="<?php echo $this->session->userdata('no_telepon'); ?>" placeholder="Masukan Nomor Telepon" class="form-control form-control-line">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-12">Alamat</label>
										<div class="col-md-12">
											<textarea rows="5" name="alamat_agen"  id="alamat_agen" class="form-control form-control-line" placeholder="Alamat sekarang: <?php echo $this->session->userdata('alamat'); ?>"><?php echo $this->session->userdata('alamat'); ?></textarea>
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
											<button type="submit" class="btn btn-success">Update Profile</button>
										</div>
									</div>
								<!-- </form> -->
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
