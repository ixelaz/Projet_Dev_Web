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
  if (!isset($_GET['id'])) {
    header('Location: list_product.php');
  }
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
        <li><a href="orders.php"><em class="fa fa-calendar">&nbsp;</em> Commandes</a></li>
        <li><a href="mails.php"><em class="fa fa-envelope-o">&nbsp;</em> Messages</a></li>
        <li class="parent"><a data-toggle="collapse" href="#sub-item-1">
          <em class="fa fa-tags">&nbsp;</em> Produits <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
        </a>
        <ul class="children collapse" id="sub-item-1">
          <li><a class="" href="list_product.php">
            <span class="fa fa-arrow-right">&nbsp;</span> Consulter
          </a></li>
          <li ><a class="" href="add_product.php">
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
      <li class="active">Editer un produit</li>
    </ol>
  </div><!--/.row-->
<!-- Récuperation data -->
<?php
  $id= $_GET['id'];
  $productManager = new ProductManager($conn);
  $product =$productManager->get($id);

  //Récuperation d'imagear
  $imageManager = new ImageManager($conn);
  $id_image = $product->id_img();
  $image = $imageManager->get($id_image);
  $imageB = $image->image();
 ?>
  <div class="row">
    <div class="panel-body">
      <form class="form-horizontal row-border" enctype="multipart/form-data" action="script_edit_product.php?id=<?php echo $product->id(); ?>" method="post">
        <div class="form-group">
          <label class="col-md-2 control-label">Nom du produit</label>
          <div class="col-md-10">
            <input type="text" name="name" class="form-control" value="<?php echo $product->name(); ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">Description</label>
          <div class="col-md-10">
            <textarea name="description" class="form-control" cols="40" rows="5" required> <?php echo $product->description(); ?> </textarea>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">Stock</label>
          <div class="col-md-10">
            <input type="number" name="stock" class="form-control" min="0.00" max="10000.00" step="1" value="<?php echo $product->stock();?>" required>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">Prix</label>
          <div class="col-md-10">
            <input type="number" name="price" class="form-control" min="0.00" max="10000.00" step="0.01" value="<?php echo $product->price(); ?>" required />
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">Image</label>
          <div class="col-md-10">
            <img style="width:100px; height:100px" src="data:image/jpeg;base64,<?php echo(base64_encode($imageB)) ?>" /><br><br>
            <input type="file" name="product_img" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">Catégorie</label>
          <div class="col-md-10">
            <div class="row">
              <div class="col-xs-12">
                <?php
                  $categoryManager = new CategoryManager($conn);
                  $res = $categoryManager->getList();
                ?>
                <select class="col-md-5 form-control" name="category" >
                  <?php
                  $select = 'selected="selected"';
                  foreach($res as $category) {
                    if ($product->id_category() == $category->id()) {
                      $setSelect=$select;
                    }
                    echo '<option value="'.$category->id().'" '.$setSelect.'>'.$category->name().'</option>';
                    $setSelect="";
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" name="CSRFtoken" value="<?php echo $_SESSION['CSRFtoken'] ?>">
        <button class="col-xs-12 btn btn-lg btn-primary" type="submit"><span class="fa fa-plus"></span> &nbsp;Appliquer les changements</button>
      </form>
      <br>
      <br>
      <br>
      <?php if ($erreur == '1'): ?>
        <div class="alert bg-warning" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Erreur : Champ incorrect </div>
      <?php ; endif ?>
      <?php if ($erreur == '2'): ?>
        <div class="alert bg-warning" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Erreur : Taille de l'image </div>
      <?php ; endif ?>
      <?php if ($erreur == '3'): ?>
        <div class="alert bg-warning" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Erreur : Type de l'image </div>
      <?php ; endif ?>
      <?php if ($erreur == '4'): ?>
        <div class="alert bg-warning" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Erreur : Image non ajoutée </div>
      <?php ; endif ?>
      <?php if ($erreur == '5'): ?>
        <div class="alert bg-warning" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Erreur : Produit non ajouté </div>
      <?php ; endif ?>
      <?php if ($erreur == '6'): ?>
        <div class="alert bg-warning" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Erreur </div>
      <?php ; endif ?>
    </div>
  </div>
</div><!--/.row-->

</div>  <!--/.main-->

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
