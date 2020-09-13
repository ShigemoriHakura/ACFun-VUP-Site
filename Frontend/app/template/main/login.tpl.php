<?php include App::$view_root . "/base/common.tpl.php" ?>
<?php include App::$view_root . "/base/header.tpl.php" ?>

<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="theme-loader"></div>
</div>
<!-- Loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper null compact-wrapper">
    <div class="container-fluid p-0">
        <!-- login page start-->
        <div class="authentication-main">
            <div class="row">
                <div class="col-md-12">
                    <div class="auth-innerright">
                        <div class="authentication-box">
                            <div class="mt-4">
                                <div class="card-body">
                                    <div class="cont text-center s--signup">
                                        <div>
                                            <form class="theme-form" action="<?=$webRoot?>/login" method="post" style="width: calc(100%)!important;">
                                                <input type="text" name="_csrf" hidden value="<?=$this->getCsrfToken()?>"/>
                                                <h4><?=_L('Login_Title')?></h4>
                                                <div class="form-group">
                                                    <label class="col-form-label pt-0"><?=_L('Login_Username')?></label>
                                                    <input name="username" class="form-control" type="text" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label"><?=_L('Login_Password')?></label>
                                                    <input name="password" class="form-control" type="password" required="">
                                                </div>
                                                <div class="form-group form-row mt-3 mb-0">
                                                    <button class="btn btn-primary btn-block" type="submit"><?=_L('Login_Submit')?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- login page end-->
    </div>
</div>

<?php include App::$view_root . "/base/footJS.tpl.php" ?>


