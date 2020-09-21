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
                        <?=_L('Search_UPMedal')?></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid search-page">
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-with-border overall-rating">
                    <div class="card-header resolve-complain card-no-border">
                        <form class="search-form" action="<?=$webRoot?>/medal/search" method="get">
                            <div class="form-group m-0">
                                <label class="sr-only"><?=_L('Search_Keyword')?></label>
                                <input class="form-control-plaintext" name="keyword" value="<?=urldecode($PRM['keyword'])?>" type="search" placeholder="balabala" >
                            </div>
                        </form>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive agent-performance-table">
                            <table class="table table-bordernone">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-inline-block align-middle">
                                                <div class="d-inline-block"><span class="f-12 f-w-600"><?=_L('Search_UPerid')?></span></span></div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="f-w-600"><?=_L('Search_UPMedal')?></p>
                                        </td>
                                        <td>
                                            <p class="f-w-600"><?=_L('Search_UPName')?></p>
                                        </td>
                                        <td>
                                            <p class="f-w-600"><?=_L('Index_Action')?></p>
                                        </td>
                                    </tr>
                                    <? if ($PRM['medalResult']->count() > 0){?>
                                        <? foreach ($PRM['medalResult'] as $v){?>
                                                <tr>
                                                    <td>
                                                        <a target="_blank" href="https://www.acfun.cn/u/<?=$v['uperid']?>">
                                                            <p class="f-w-600"><?=$v['uperid']?></p>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <p class="f-w-600"><?=$v['clubName']?></p>
                                                    </td>
                                                    <td>
                                                        <p class="f-w-600"><?=$v['up']['nowName']?></p>
                                                    </td>
                                                    <td>
                                                        <a target="_blank" href="/u/<?=$v['uperid']?>"><button class="btn btn-primary btn-square digits"><?=_L('Index_Detail')?></button></a>
                                                    </td>
                                                </tr>
                                        <? }?>
                                    <? }else{ ?>
                                        <tr>
                                            <td>
                                                /
                                            </td>
                                            <td>
                                                <p class="f-w-600"><?=_L('Search_NoResult')?></p>
                                            </td>
                                            <td>
                                                /
                                            </td>
                                            <td>
                                                /
                                            </td>
                                        </tr>
                                    <? }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>


<?php include App::$view_root . "/base/footer.tpl.php" ?>


