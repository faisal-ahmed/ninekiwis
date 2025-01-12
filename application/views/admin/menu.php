<?php
require_once BASEPATH . "../application/libraries/utilities.php";
?>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top activeSquare" role="navigation" style="margin-bottom: 0">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Nine Kiwis Product Management System</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown" style="float: right;">
                <a style="color: #FFF;" class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user activeSquare">
                    <li><a style="color: #FFF;" href="<?php echo base_url() ?>index.php/user/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>

        <div class="navbar-brand navbar-right">Welcome <?php echo $username ?></div>

        <!-- /.navbar-top-links -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="<?php if ($menuHighlight == 0) echo "active"?>">
                        <a href="<?php echo base_url() ?>index.php/AdminDashboard/allProducts"><i class="fa fa-th-list fa-fw"></i> All Products</a>
                    </li>
                    <li class="<?php if ($menuHighlight == 1) echo "active"?>">
                        <a href="<?php echo base_url() ?>index.php/AdminDashboard/addProduct"><i class="fa fa-recycle fa-fw"></i> Add Product</a>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

<!--</div>-->
