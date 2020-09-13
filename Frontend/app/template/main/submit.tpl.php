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
                        提交用户</h3>
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
                        <h5>提交用户</h5><span>提交的数据 <code class="text-danger">不能删除和修改</code> </span>
                        <span>上次提交的情况
                            <? if (!$PRM['status']) {?>
                                <code class="text-danger">失败</code> </span>
                            <?}else{ ?>
                                <code class="text-success">成功</code> </span>
                            <?} ?>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" action="<?=$webRoot?>/submit" method="post">
                            <div class="form-row">
                                <input type="text" name="_csrf" hidden value="<?=$this->getCsrfToken()?>"/>
                                <div class="col-md-12 mb-12">
                                    <label for="validationCustom01">备注名</label>
                                    <input name="name" class="form-control" id="validationCustom01" type="text" placeholder="备注名" required="">
                                    <div class="valid-feedback">可以！</div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-12 mb-12">
                                    <label for="validationCustom05">UID</label>
                                    <input name="uperid" class="form-control" id="validationCustom05" type="text" placeholder="UID" required="">
                                    <div class="invalid-feedback">请输入UID</div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="form-check">
                                    <div class="checkbox p-0">
                                        <input class="form-check-input" id="invalidCheck" type="checkbox" required="">
                                        <label class="form-check-label" for="invalidCheck">确认无误！</label>
                                    </div>
                                    <div class="invalid-feedback">你必须确认先！</div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">提交用户</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>


<?php include App::$view_root . "/base/footer.tpl.php" ?>


