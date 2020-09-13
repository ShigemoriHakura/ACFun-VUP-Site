<?php include App::$view_root . "/base/common.tpl.php" ?>
<?php include App::$view_root . "/base/header.tpl.php" ?>

<div class="loader-wrapper">
    <div class="theme-loader"></div>
</div>
<!-- Loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- error-500 start-->
    <div class="error-wrapper">
        <div class="container"><img class="img-100" src="<?=$webRoot?>/assets/images/other-images/sad.png" alt="">
            <div class="error-heading">
                <h2 class="headline font-primary">500</h2>
            </div>
            <div class="col-md-8 offset-md-2">
                <p class="sub-content"><?=$PRM['msg']?></p>
            </div>
            <div><a class="btn btn-primary-gradien btn-lg" href="javascript:window.history.go(-1);">[后退]</a> <a class="btn btn-primary-gradien btn-lg" href="/">[返回首页]</a></div>
        </div>
    </div>
    <!-- error-500 end-->
</div>


<?php include App::$view_root . "/base/footJS.tpl.php" ?>