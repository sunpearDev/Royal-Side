<?php

include('includes/header.php');
include('includes/navbar.php');

require_once "../backend/dbService.php";

if (isset(
    $_POST['booking_ID'],
    $_POST['category_ID'],
    $_POST['quantity'],
)) {


    // var_dump($_POST);
    // die();

    $kq = false;
    $DB = new DbServices();

    try {
        $sql = "SELECT * FROM room_category WHERE category_ID = '" . $_POST['category_ID'] . "'";
        if ($roomType =  $DB->execute1($sql)) {
            foreach ($roomType as $item) {
                $price_on_day = $item['price_on_day'];
            }
        }
        $result = $DB->create(
            'booking_detail',
            [
                'booking_ID' => $_POST['booking_ID'],
                'category_ID' => $_POST['category_ID'],
                'quantity' => $_POST['quantity'],
                'price_on_day' => $price_on_day,
            ]

        );
        if ($result)
            $kq = true;
    } catch (Exception $e) {
    }

    $resultAdd = json_encode($kq);
};

?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                        <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                            Settings
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                            Activity Log
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Chi tiết đặt phòng</h1>


            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thêm chi tiết đặt phòng</h6>
                </div>

                <?php if (isset($resultAdd)) {
                    if ($kq == true)
                        echo '<div class="alert alert-info" role="alert">' . $resultAdd . ' </div>';
                    else
                        echo '<div class="alert alert-danger" role="alert">' . $resultAdd . ' </div>';
                }
                ?>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <form action="./addbookingdetail.php" method="POST">


                                <div class="form-group">
                                    <select class="form-control" id="madatphong" name="booking_ID">
                                        <option value="" selected disabled>Mã đặt phòng</option>
                                        <?php
                                        $DB =  new DbServices();
                                        $sql = "SELECT * FROM booking";
                                        if ($roomType =  $DB->execute1($sql)) {
                                            foreach ($roomType as $item) {
                                                echo '<option  value="' . $item['booking_ID'] . '">' . $item['booking_ID'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select class="form-control" id="loaiphong" name="category_ID">
                                        <option value="" selected disabled>Loại phòng</option>
                                        <?php
                                        $DB =  new DbServices();
                                        $sql = "SELECT * FROM room_category";
                                        if ($roomType =  $DB->execute1($sql)) {
                                            foreach ($roomType as $item) {
                                                echo '<option  value="' . $item['category_ID'] . '">' . $item['category_name'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="quantity" class="form-control" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Số lượng'" placeholder="Số lượng" aria-label="Double Bed" required aria-describedby="basic-addon1">
                                </div>

                                <div class="mt-30 row justify-content-center">
                                    <input id="comfirm-add-btn" type="submit" name="submit" value="Thêm" class="w-25 genric-btn danger radius" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->



    <?php include('includes/scripts.php'); ?>
    <?php include('includes/footer.php'); ?>