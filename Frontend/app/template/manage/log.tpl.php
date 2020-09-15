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
                        <?=_L('Log_Index')?></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 xl-100 box-col-12">
                <div class="card card-with-border connection firm-activity">
                    <div class="card-header">
                        <h5 class="d-inline-block"><?=_L('Log_Title')?></h5><span class="pull-right mt-0">QwQ</span>
                    </div>
                    <div class="card-body p-0">
                        <ul>
                            <? foreach ($PRM['logDataset'] as $k => $v){?>
                                <li>
                                    <div class="media">
                                        <div class="media-body"><span> <?=$v['content']?></span>
                                            <p><?=date('Y-m-d H:i:s', $v['add_date'])?></p>
                                        </div>
                                    </div>
                                </li>
                                <hr>
                            <? }?>
                            <li>
                                <div class="media">
                                    <div class="media-body"><span><span class="f-w-600">(●′ω`●)</span></span>
                                        <p>┯━┯ノ('－'ノ)</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
</div>

<?php include App::$view_root . "/base/footer.tpl.php" ?>
