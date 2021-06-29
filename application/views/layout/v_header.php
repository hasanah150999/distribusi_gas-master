<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/') ?>images/favicon.png">
    <title>Si Istri GasUdi</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('assets/') ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Calendar CSS -->
	<link href="<?php echo base_url('assets/') ?>plugins/calendar/dist/fullcalendar.css" rel="stylesheet" />
	<!-- Custom CSS -->
    <link href="<?php echo base_url('assets/') ?>css/style.css" rel="stylesheet">
	<!-- Switch -->
	<link href="<?php echo base_url('assets/') ?>plugins/switchery/dist/switchery.min.css" rel="stylesheet" />
	<!-- Graph CSS -->
	<link href="<?php echo base_url('assets/') ?>plugins/morrisjs/morris.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?php echo base_url('assets/') ?>css/colors/blue.css" id="theme" rel="stylesheet">
	<!-- Date picker plugins css -->
	<link href="<?php echo base_url('assets/') ?>plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <link href="<?php echo base_url('assets/') ?>plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/') ?>plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<!-- Select2 -->
	<link href="<?php echo base_url('assets/') ?>plugins/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
	<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0 ">
						<li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-menu"></i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="<?php echo base_url()?>uploads/profile/<?php echo $this->session->userdata('photo');?>" onerror="this.onerror=null;this.src='<?php echo base_url()?>assets/images/users/default_picture.png';" alt="user"></div>
                                            <div class="u-text">
                                                <h4><?php echo $this->session->userdata('name');?></h4>
                                                <p class="text-muted"><?php echo $this->session->userdata('username');?></p></div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
									<?php if($this->session->userdata('role') == 'agen'){ ?>
										<li><a href="<?php echo site_url('agen/profile') ?>"><i class="ti-settings"></i> Kelola Profile</a></li>
									<?php } ?>
									<?php if($this->session->userdata('role') == 'spbe'){ ?>
										<li><a href="<?php echo site_url('spbe/profile') ?>"><i class="ti-settings"></i> Kelola Profile</a></li>
									<?php } ?>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?php echo site_url('logout') ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" style="padding-top: 30px;">
                <!-- User profile -->
                <div class="user-profile">
                    <!-- User profile image -->
                    <div class="profile-img"> <img src="<?php echo base_url()?>uploads/profile/<?php echo $this->session->userdata('photo');?>" onerror="this.onerror=null;this.src='<?php echo base_url()?>assets/images/users/default_picture.png';" alt="user" /> </div>
                    <!-- User profile text-->
                    <div class="profile-text"> 
						<?php if($this->session->userdata('role') == 'agen'){
									echo $this->session->userdata('name');
								} else {
									echo 'SPBE';
								} ?>
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
						<?php if($this->session->userdata('role') == 'agen'){ ?>
							<li class="nav-small-cap">Dashboard</li>
							<?php if(($this->uri->segment(1) == "dashboard")) { echo '<li class="active">'; } else { echo '<li>'; } ?>
								<a href="<?php echo site_url('dashboard') ?>" aria-expanded="false"><i class="mdi mdi-apps"></i><span class="hide-menu">Dashboard</span></a>
							</li>
							<?php if(($this->uri->segment(1) == "agen" && $this->uri->segment(2) == NULL)) { echo '<li class="active">'; } else { echo '<li>'; } ?>
								<a href="<?php echo site_url('agen') ?>" aria-expanded="false"><i class="mdi mdi-gas-cylinder"></i><span class="hide-menu">Distribusi Gas</span></a>
							</li>
							<?php if(($this->uri->segment(1) == "agen" && $this->uri->segment(2) == "pelanggan")) { echo '<li class="active">'; } else { echo '<li>'; } ?>
								<a href="<?php echo site_url('agen/pelanggan') ?>" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Kelola Pelanggan</span></a>
							</li>
							<li class="nav-devider"></li>
							<li class="nav-small-cap">Setting</li>
							<?php if(($this->uri->segment(1) == "agen" && $this->uri->segment(2) == "profile")) { echo '<li class="active">'; } else { echo '<li>'; } ?>
								<a href="<?php echo site_url('agen/profile') ?>" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Kelola Profile</span></a>
							</li>
						<?php } ?>
						<?php if($this->session->userdata('role') == 'spbe'){ ?>
							<li class="nav-small-cap">Dashboard</li>
							<?php if(($this->uri->segment(1) == "dashboard")) { echo '<li class="active">'; } else { echo '<li>'; } ?>
								<a href="<?php echo site_url('dashboard') ?>" aria-expanded="false"><i class="mdi mdi-apps"></i><span class="hide-menu">Dashboard</span></a>
							</li>
							<?php if(($this->uri->segment(1) == "spbe") && $this->uri->segment(2) == NULL) { echo '<li class="active">'; } else { echo '<li>'; } ?>
								<a href="<?php echo site_url('spbe') ?>" aria-expanded="false"><i class="mdi mdi-information-outline"></i><span class="hide-menu">Info Data Pangkalan</span></a>
							</li>
							<?php if(($this->uri->segment(2) == "distribusi")) { echo '<li class="active">'; } else { echo '<li>'; } ?>
								<a href="<?php echo site_url('spbe/distribusi') ?>" aria-expanded="false"><i class="mdi mdi-content-paste"></i><span class="hide-menu">Cek Distribusi Pangkalan</span></a>
							</li>
							<?php if(($this->uri->segment(2) == "monitoring")) { echo '<li class="active">'; } else { echo '<li>'; } ?>
								<a href="<?php echo site_url('spbe/monitoring') ?>" aria-expanded="false"><i class="mdi mdi-monitor"></i><span class="hide-menu">Monitoring Pangkalan</span></a>
							</li>
							<?php if(($this->uri->segment(1) == "spbe") && $this->uri->segment(2) == "laporan") { echo '<li class="active">'; } else { echo '<li>'; } ?>
								<a href="<?php echo site_url('spbe/laporan') ?>" aria-expanded="false"><i class="mdi mdi-printer"></i><span class="hide-menu">Cetak Laporan</span></a>
							</li>
							<li class="nav-devider"></li>
							<li class="nav-small-cap">Setting</li>
							<?php if(($this->uri->segment(1) == "spbe" && $this->uri->segment(2) == "profile")) { echo '<li class="active">'; } else { echo '<li>'; } ?>
								<a href="<?php echo site_url('spbe/profile') ?>" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Kelola Profile</span></a>
							</li>
						<?php } ?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
