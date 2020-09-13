<?php include App::$view_root . "/base/common.tpl.php" ?>
<?php include App::$view_root . "/base/header.tpl.php" ?>

    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="theme-loader"></div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- error-404 start-->
        <div class="error-wrapper">
            <div class="container"><img class="img-100" src="<?=$webRoot?>/assets/images/other-images/sad.png" alt="">
                <div class="error-heading">
                    <h2 class="headline font-danger">404</h2>
                </div>
                <div class="col-md-8 offset-md-2">
                    <p class="sub-content"><?=_L('Up_404') ?></p>
                </div>
                <div><a class="btn btn-danger-gradien btn-lg" href="/"><?=_L('Up_ToIndex') ?></a></div>
            </div>
        </div>
        <!-- error-404 end      -->
    </div>

<?php include App::$view_root . "/base/footJS.tpl.php" ?>