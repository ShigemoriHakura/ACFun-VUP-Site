<?php include App::$view_root . "/base/common.tpl.php" ?>
<?php include App::$view_root . "/base/header.tpl.php" ?>
<?php include App::$view_root . "/base/sideBar.tpl.php" ?>

<!-- Page Sidebar Ends-->
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="f-16 fa fa-home"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                    </ol>
                    <h3>
                        <?=_L('Search_Index')?></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-with-border overall-rating">
                    <div class="card-header">
                        <h5 class="d-inline-block"><?=_L('Search_Title')?></h5><span class="setting-round pull-right d-inline-block mt-0"><i class="fa fa-spin fa-cog"></i></span>
                        <p class="f-12 mb-0"><?=_L('Search_Desc')?></p>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" action="<?=$webRoot?>/search" method="get">
                            <div class="form-row">
                                <div class="col-md-12 mb-12">
                                    <label for="validationCustom01"><?=_L('Search_Keyword')?></label>
                                    <input name="keyword" class="form-control" id="validationCustom01" type="text" placeholder="balabala" required="">
                                    <div class="valid-feedback"><?=_L('Search_CheckOK')?></div>
                                </div>
                            </div>
                            <hr>
                            <button class="btn btn-primary" type="submit"><?=_L('Search_Searchbtn')?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>


<?php include App::$view_root . "/base/footer.tpl.php" ?>


