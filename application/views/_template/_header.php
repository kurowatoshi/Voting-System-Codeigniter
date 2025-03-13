<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$title;?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?=base_url('assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/css/sweetalert2.min.css')?>">
  <link rel="stylesheet" href="<?=base_url('assets/adminlte/dist/css/AdminLTE.min.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/adminlte/dist/css/skins/_all-skins.min.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/css/admin.css');?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script src="<?=base_url('assets/adminlte/bower_components/jquery/dist/jquery.min.js');?>"></script>
  <script src="<?=base_url('assets/js/sweetalert2.all.min.js')?>"></script>
  </head>
<body class="hold-transition skin-green layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="" class="navbar-brand"><b>Vaoting-</b>System</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a><span class="hidden-xs"><?=($this->session->login) ? $this->session->nama : '' ?></span></a>
						</li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

	
  <div class="content-wrapper">
    <div class="container">
      <section class="content">
