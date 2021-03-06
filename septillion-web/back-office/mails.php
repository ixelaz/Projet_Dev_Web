<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Septillion Bakery - Dashboard</title>
	<?php
	require('connexion.php');
	$conn = Connect::connexion();
	$erreur = 100;
	if (isset($_GET['erreur']))
		$erreur = $_GET['erreur'];
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
					<a class="navbar-brand" href="index.php"><span>Septillion Bakery</span>Admin</a>
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
				<li class="active"><a href="mails.php"><em class="fa fa-envelope-o">&nbsp;</em> Messages</a></li>
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
		</li>
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
			<li><a href="index.php">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active">Messages</li>
		</ol>
	</div><!--/.row-->

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">Messages</div>
					<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<div class="panel panel-default">
								<div class="panel-body btn-margins">
									<div class="col-md-12">
										<?php
										$messageManager = new MessageManager($conn);
										$employeeManager = new EmployeeManager($conn);
										$messageList = $messageManager->getByReceiver(intval($_SESSION['id_admin']));
										echo '<div class="table-responsive-xl">';
										if (!empty($messageList)) {
											echo '<table class="table" id="messageTable">';
											?>
											<tr>
												<th scope="col">De :</th>
												<th scope="col">Objet :</th>
												<th scope="col">Date :</th>
												<th scope="col"></th>
												<th scope="col"></th>
											</tr>
											<?php
											foreach ($messageList as $value) {
												echo "<tr>";
												echo "<td>".$employeeManager->get($value->id_sender())->first_name()." ".$employeeManager->get($value->id_sender())->last_name()."</td>";
												echo "<td>".$value->message_object()."</td>";
												echo "<td>".$value->sent_date()."</td>";
											?>
											<td>
												<a class="btn btn-default margin" data-toggle="collapse" href="<?php echo "#afficher".$value->id() ?>" role="button" aria-expanded="false" aria-controls="<?php echo "afficher".$value->id() ?>"><span class="fa fa-envelope"></span></a>
											</td>
											<td>
												<form action="script_del_mail.php" method="post">
													<button class="btn btn-default margin" type="submit" name="id" value="<?php echo $value->id() ?>"><span class="fa fa-trash"></span></button>
												</form>
											</td>
											<?php
											echo "</tr>";
											?>
											<tr><td colspan="5">
												<div class="collapse" id="<?php echo "afficher".$value->id() ?>">
													<div class="card card-body" >
														<?php echo(nl2br($value->body())); ?>
													</div>
												</div>
											</td></tr>
											<?php
											}
											echo "</table>";
											} else {
												echo '<h3>Aucun message</h3>';
											}
											?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">Ecrire un message</div>
					<div class="panel-body">
						<form class="form-horizontal row-border" action="script_send_mail.php" method="post">
							<div class="form-group">
								<div class="col-md-12">
									<div class="form-group">
					          <label class="col-md-1 control-label">Récepteur</label>
					          <div class="col-md-11">
					            <div class="row">
					              <div class="col-xs-12">
					                <?php
					                  $employeeManager = new EmployeeManager($conn);
					                  $res = $employeeManager->getList();
					                ?>
					                <select class="col-md-5 form-control" name="receiver">
					                  <?php
					                  foreach($res as $employee) {
					                    echo '<option value="'.$employee->id().'">'.$employee->first_name().' '.$employee->last_name().'</option>';
					                  }
					                  ?>
					                </select>
					              </div>
					            </div>
					          </div>
					        </div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<input type="text" name="object" class="form-control" placeholder="Objet">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<textarea name="body" class="form-control" cols="40" rows="8"></textarea>
								</div>
							</div>
							<input type="hidden" name="CSRFtoken" value="<?php echo $_SESSION['CSRFtoken'] ?>">
							<button class="btn btn-default margin" type="submit"><span class="fa fa-envelope-o"></span> &nbsp;Envoyer</button>
						</form>
						<br>
							<?php if ($erreur == '2'): ?>
								<div class="alert bg-warning" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Erreur BDD </div>
								<?php ; endif ?>
								<?php if ($erreur == '3'): ?>
									<div class="alert bg-success" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Mail envoyé !</div>
									<?php ; endif ?>
								</div>
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
			</body>
			</html>
