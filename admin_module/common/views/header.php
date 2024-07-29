<!DOCTYPE html>
<html>
   <head>
   	  <title><?php echo $site_name; ?></title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
		
		<link rel="shortcut icon" href="<?=base_url('storage/uploads/images/favicon.png')?>">
		<base href="<?=base_url()?>"/>
		<?php //echo $this->template->metadata() ?>
      <!-- Base Css Files -->
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">



    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
	  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
	  <link rel="stylesheet" type="text/css" href="<?php echo theme_url('assets/css/style.css?v=4');  ?>" />


    <link rel="stylesheet" type="text/css" href="<?php echo theme_url('assets/css/menu.css');  ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('storage/plugins/superfish/css/superfish.css');  ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo theme_url('assets/css/ui.nestedSortable.css');  ?>" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css" />
	  <!--
	  <link rel="stylesheet" type="text/css" href="<?php echo theme_url('assets/css/bootstrap.min.css');  ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo theme_url('assets/css/font-awesome.min.css');?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo theme_url('assets/css/style.css');  ?>" />
      <link rel="stylesheet" type="text/css" href="<?php echo theme_url('assets/css/pages.css');  ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo theme_url('assets/css/menu.css');  ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('storage/plugins/superfish/css/superfish.css');  ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo theme_url('assets/css/ui.nestedSortable.css');  ?>" />
		-->
		<!-- Controller Defined Stylesheets -->
      <?php echo $this->template->stylesheets() ?>


	<!--	
		<script src="<?php echo theme_url('assets/js/modernizr.min.js');  ?>"></script>  

		-->     
		<script type="text/javascript">
			var BASE_URL = '<?php echo base_url(); ?>';
         var ADMIN_URL = '<?php echo admin_url(); ?>';
         var THEME_URL = '<?php echo theme_url(); ?>';
      </script>
      <!-- Controller Defined JS Files -->
      <?php echo $this->template->javascripts() ?>
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
	</head>
   <body>
          
         <?php /* if ($this->user->isLogged()){ ?>
			<section>
			<header>			
                            <h1><a href="<?=admin_url()?>"><img src="<?php echo $logo;?>" class="img-fluid d-block" height="30px"/></a></h1>
				<h2>Admin Panel</h2>
				<div id="link">
					<a class="btn btn-primary" target="_blank" href="<?=base_url()?>">Visit Site</a>
					<a class="btn btn-danger" href="<?=admin_url('common/logout')?>">Logout</a>
				</div>
			</header>
			<?php echo $menu;?>
			<?php }*/ ?>

<?php if ($this->user->isLogged()){ ?>

<header class="bg-white sticky-top border" style="position:fixed;width:100%;background-color:inherit">
	<div class="container-fluid px-0 h-100 border-bottom-transparent">
				<div class="row g-0 h-100">
			<div class="col-auto col-md-2 d-flex align-items-center justify-content-between border-end-transparent text-uppercase ps-md-3">
        <h4 class="mb-0 fw-bold d-none d-md-block"><a href="<?=admin_url()?>"><img src="<?php echo $logo;?>" height="50px"/></a></h4>
        <a onclick="myFunction()" class="header-btn slidemenu"><i class="las la-bars"></i></a>
      </div>
		<div class="col d-flex px-4"><h6 class="mb-0 align-self-center text-uppercase text-muted">Management Panel</h6></div>
						<!--<div class="col-auto d-flex">
			<a class="btn btn-warning btn-sm align-self-center me-4 text-white" target="_blank" href="<?=base_url()?>"><i class="las la-globe"></i> Visit Site</a>
			</div>-->
      
		  <div class="col-auto d-flex border-start-transparent <?php echo ($_SESSION['user_group_id'] == 1 ? '' : 'd-none'); ?>">
       <div class="dropdown">
      <button title="Setting"class="btn header-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
       <i class="las la-cog"></i>
      </button>
      <ul class="dropdown-menu settings-dropdown">
        <li><a data-bs-toggle="tooltip" class="dropdown-item " data-bs-placement="bottom" title="Setting" href="<?=admin_url('setting')?>"><i class="las la-cog"></i>  <span class="ms-xl-3">Admin Settings</span></a></li> 
        <li><a data-bs-toggle="tooltip" class="dropdown-item " data-bs-placement="bottom" title="Setting" href="<?=admin_url('setting/bonus')?>"><i class="las la-money-bill-wave"></i>  <span class="ms-xl-3">Bonus Settings</span></a></li>
         <li><a data-bs-toggle="tooltip" class="dropdown-item " data-bs-placement="bottom" title="Setting" href="<?=admin_url('setting/fleets')?>"><i class="las la-truck "></i>  <span class="ms-xl-3">Fleet Settings</span></a></li>
      </ul>
    </div>
			
			</div>
			<div class="col-auto border-start-transparent">
			<a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Logout" class="header-btn" href="<?=admin_url('common/logout')?>"><i class="las la-power-off"></i></a>
			</div>
		</div>
	</div>
</header>

<div class="container-fluid h-100" style="padding-top:80px">
	<div class="row h-100">
		<div class="col-2 bg-white p-4 position-realtive" id="left-col">
    <?php echo $menu;?>
<!--		
<aside class="sidebar">
  <div id="leftside-navigation" class="nano">
    <ul class="nano-content">
      <li>
        <a href="index.html"><i class="la la-dashboard"></i><span>Dashboard</span></a>
      </li>
      <li class="sub-menu">
        <a href="javascript:void(0);"><i class="la la-cogs"></i><span>UI Elements</span><i class="arrow la la-angle-right ms-auto"></i></a>
        <ul>

          <li><a href="ui-alerts-notifications.html">Alerts &amp; Notifications</a>
          </li>
          <li><a href="ui-panels.html">Panels</a>
          </li>
          <li><a href="ui-buttons.html">Buttons</a>
          </li>
          <li><a href="ui-slider-progress.html">Sliders &amp; Progress</a>
          </li>
          <li><a href="ui-modals-popups.html">Modals &amp; Popups</a>
          </li>
          <li><a href="ui-icons.html">Icons</a>
          </li>
          <li><a href="ui-grid.html">Grid</a>
          </li>
          <li><a href="ui-tabs-accordions.html">Tabs &amp; Accordions</a>
          </li>
          <li><a href="ui-nestable-list.html">Nestable Lists</a>
          </li>
        </ul>
      </li>
      <li class="sub-menu">
        <a href="javascript:void(0);"><i class="la la-table"></i><span>Tables</span><i class="arrow la la-angle-right ms-auto"></i></a>
        <ul>
          <li><a href="tables-basic.html">Basic Tables</a>
          </li>

          <li><a href="tables-data.html">Data Tables</a>
          </li>
        </ul>
      </li>
      <li class="sub-menu">
        <a href="javascript:void(0);"><i class="fa la la-tasks"></i><span>Forms</span><i class="arrow la la-angle-right ms-auto"></i></a>
        <ul>
          <li><a href="forms-components.html">Components</a>
          </li>
          <li><a href="forms-validation.html">Validation</a>
          </li>
          <li><a href="forms-mask.html">Mask</a>
          </li>
          <li><a href="forms-wizard.html">Wizard</a>
          </li>
          <li><a href="forms-multiple-file.html">Multiple File Upload</a>
          </li>
          <li><a href="forms-wysiwyg.html">WYSIWYG Editor</a>
          </li>
        </ul>
      </li>
      <li class="sub-menu">
        <a href="javascript:void(0);"><i class="la la-envelope"></i><span>Mail</span><i class="arrow la la-angle-right ms-auto"></i></a>
        <ul>
          <li class="active"><a href="mail-inbox.html">Inbox</a>
          </li>
          <li><a href="mail-compose.html">Compose Mail</a>
          </li>
        </ul>
      </li>
      <li class="sub-menu">
        <a href="javascript:void(0);"><i class="la la-bar-chart-o"></i><span>Charts</span><i class="arrow la la-angle-right ms-auto"></i></a>
        <ul>
          <li><a href="charts-chartjs.html">Chartjs</a>
          </li>
          <li><a href="charts-morris.html">Morris</a>
          </li>
          <li><a href="charts-c3.html">C3 Charts</a></li>
        </ul>
      </li>
      <li class="sub-menu">
        <a href="javascript:void(0);"><i class="la la-map-marker"></i><span>Maps</span><i class="arrow la la-angle-right ms-auto"></i></a>
        <ul>
          <li><a href="map-google.html">Google Map</a>
          </li>
          <li><a href="map-vector.html">Vector Map</a>
          </li>
        </ul>
      </li>
      <li class="sub-menu">
        <a href="typography.html"><i class="la la-text-height"></i><span>Typography</span></a>
      </li>
      <li class="sub-menu">
        <a href="javascript:void(0);"><i class="la la-file"></i><span>Pages</span><i class="arrow la la-angle-right ms-auto"></i></a>
        <ul>
          <li><a href="pages-blank.html">Blank Page</a>
          </li>
          <li><a href="pages-login.html">Login</a>
          </li>
          <li><a href="pages-sign-up.html">Sign Up</a>
          </li>
          <li><a href="pages-calendar.html">Calendar</a>
          </li>
          <li><a href="pages-timeline.html">Timeline</a>
          </li>
          <li><a href="pages-404.html">404</a>
          </li>
          <li><a href="pages-500.html">500</a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</aside>
-->
		</div>
    

    


		<div class="col p-4 bg1">


      
      <?php } ?>
