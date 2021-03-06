<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Septillion Bakery - Dashboard</title>
	<?php
	require('connexion.php');
	$conn = Connect::connexion();
  $productManager = new ProductManager($conn);
  $imageManager = new ImageManager($conn);
  $categoryManager = new CategoryManager($conn);
  $employeeManager = new EmployeeManager($conn);
  $product = $productManager->get($_GET['id']);
  $image = $imageManager->get($product->id_img())->image();
  $created_by = $employeeManager->get($product->created_by());
  $last_updated_by = $employeeManager->get($product->last_updated_by());
	?>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">

	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></button>
					<a class="navbar-brand" href="#"><span>Septillion Bakery</span>Admin</a>
				</div>
			</div><!-- /.container-fluid -->
		</nav>
		<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
			<div class="profile-sidebar">
				<div class="profile-usertitle">
					<div class="profile-usertitle-name"><?php echo $_SESSION['name']?></div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="divider"></div>
			<ul class="nav menu">
				<li><a href="index.php"><em class="fa fa-dashboard">&nbsp;</em> Tableau de bord</a></li>
				<li><a href="list_order.php"><em class="fa fa-calendar">&nbsp;</em> Commandes</a></li>
				<li><a href="mails.php"><em class="fa fa-envelope-o">&nbsp;</em> Messages</a></li>
				<li class="parent "><a data-toggle="collapse" href="#sub-item-1">
					<em class="fa fa-tags">&nbsp;</em> Produits <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li><a class="" href="list_product.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Consulter
					</a></li>
					<li><a class="" href="add_product.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Ajouter
					</a></li>
				</ul>
			</li>
			<li class="parent "><a data-toggle="collapse" href="#sub-item-2">
				<em class="fa fa-bookmark">&nbsp;</em> Catégories <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
			</a>
			<ul class="children collapse" id="sub-item-2">
				<li><a class="" href="list_category.php">
					<span class="fa fa-arrow-right">&nbsp;</span> Consulter
				</a></li>
				<li><a class="" href="add_category.php">
					<span class="fa fa-arrow-right">&nbsp;</span> Ajouter
				</a></li>
			</ul>
			<?php 	//gestion du compte Admin
			$employeeManager = new EmployeeManager($conn);
			$employee = $employeeManager->get($_SESSION['id_admin']);
			if ($employee->role() == "admin") {?>
				<li class="parent "><a data-toggle="collapse" href="#sub-item-3">
					<em class="fa fa-user">&nbsp;</em> Employé <span data-toggle="collapse" href="#sub-item-3" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
						<ul class="children collapse" id="sub-item-3">
							<li><a class="" href="list_employee.php">
								<span class="fa fa-arrow-right">&nbsp;</span> Consulter
							</a></li>
							<li><a class="" href="add_employee.php">
								<span class="fa fa-arrow-right">&nbsp;</span> Ajouter
							</a></li>
						</ul>
					</li>
			<?php } ?>
	<li><a href="script_logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
</ul>
</div>
<!--/.sidebar-->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="index.php"><em class="fa fa-home"></em></a></li>
      <li><a href="list_product.php">Liste produits</a></li>
      <li class="active"><?php echo $product->name() ?></li>
		</ol>
	</div>
  <div class="row">
		<div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading"><?php echo $product->name() ?>
					<button class="btn btn-default margin pull-right panel-button-tab-right" onclick="location.href='script_delete_product.php?id=<?php echo($product->id())  ?>'"><span class="fa fa-trash"></span> &nbsp;Delete</button>
          <button class="btn btn-default margin pull-right panel-button-tab-right" onclick="location.href='edit_product.php?id=<?php echo($product->id())  ?>'"><span class="fa fa-edit"></span> &nbsp;Edit</button>
        </div>
				<div class="panel-body">
          <div class="search-result-item col-md-12">
            <div class="col-sm-2">
              <img class="search-result-image img-responsive" src="data:image/jpeg;base64,<?php echo(base64_encode($image)) ?>"/>
            </div>
            <div class="search-result-item-body col-sm-10">
              <div class="row">
                <div class="col-sm-9">
                  <h3 class="search-result-title"><?php echo $categoryManager->get($product->id_category())->name() ?></a></h3>
                  <p><?php echo $product->description() ?></p>
                  <p><?php echo 'Stock : '.$product->stock() ?></p>
                  <p><?php echo 'Créé par : '.$created_by->first_name()." ".$created_by->last_name() ?></p>
                  <p><?php echo 'Dernière mise à jour par : '.$last_updated_by->first_name().' '.$last_updated_by->last_name() ?></p>
                </div>
                <div class="col-sm-3 text-center">
                  <h3><?php echo $product->price().'€' ?></h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">Ventes sur l'année</div>
    <div class="panel-body">
      <div class="canvas-wrapper">
        <canvas class="chart" id="bar-chart" height="509" width="1528" style="width: 1528px; height: 509px;"></canvas>
      </div>
    </div>
  </div>
</div>	<!--/.main-->

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/chart.min.js"></script>
<script src="js/chart-data.js"></script>
<script src="js/easypiechart.js"></script>
<script src="js/easypiechart-data.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/custom.js"></script>
<script>
  var chart2 = document.getElementById("bar-chart").getContext("2d");
  window.myBar = new Chart(chart2).Bar(barChartData, {
  responsive: true,
  scaleLineColor: "rgba(0,0,0,.2)",
  scaleGridLineColor: "rgba(0,0,0,.05)",
  scaleFontColor: "#c5c7cc"
  });
</script>
</body>
</html>
