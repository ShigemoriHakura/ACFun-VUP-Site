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
                        <?=_L('Submit_Index')?></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?=_L('Submit_Title')?></h5>
                        <span><?=_L('Submit_Desc3')?>
                            <? if (!$PRM['status']) {?>
                                <code class="text-danger"><?=_L('Submit_Failed')?></code> </span>
                            <?}else{ ?>
                                <code class="text-success"><?=_L('Submit_Success')?></code> </span>
                            <?} ?>
                        <span><?=_L('Submit_Desc')?> <code class="text-danger"><?=_L('Submit_Desc2')?></code> </span>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" action="<?=$webRoot?>/submit" method="post">
                            <div class="form-row">
                                <input type="text" name="_csrf" hidden value="<?=$this->getCsrfToken()?>"/>
                                <div class="col-md-12 mb-12">
                                    <label for="validationCustom01"><?=_L('Submit_UP_Note')?></label>
                                    <input name="name" class="form-control" id="validationCustom01" type="text" placeholder="<?=_L('Submit_UP_Note')?>" required="" autocomplete="off">
                                    <div class="valid-feedback"><?=_L('Submit_CheckOK')?></div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-12 mb-12">
                                    <label for="validationCustom05"><?=_L('Submit_UP_ID')?></label>
                                    <input name="uperid" class="form-control" id="validationCustom05" type="text" placeholder="<?=_L('Submit_UP_ID')?>" required="" autocomplete="off">
                                    <div class="invalid-feedback"><?=_L('Submit_Uperid_NotInput')?></div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="form-check">
                                    <div class="checkbox p-0">
                                        <input class="form-check-input" id="invalidCheck" type="checkbox" required="">
                                        <label class="form-check-label" for="invalidCheck"><?=_L('Submit_CheckedOK')?></label>
                                    </div>
                                    <div class="invalid-feedback"><?=_L('Submit_NotCheckedOK')?></div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit"><?=_L('Submit_Submitbtn')?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>


<?php include App::$view_root . "/base/footer.tpl.php" ?>


