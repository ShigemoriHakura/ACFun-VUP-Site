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
                        <?=_L('Index_Index')?></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-with-border overall-rating">
                    <div class="card-header resolve-complain card-no-border">
                        <h5 class="d-inline-block"><?=_L('Livestream_Title')?></h5><span class="setting-round pull-right d-inline-block mt-0"><i class="fa fa-spin fa-cog"></i></span>
                        <p class="f-12 mb-0"><?=_L('Index_Desc')?></p>
                        <p class="f-12 mb-0"><?=_L('Index_Desc_Scroll')?></p>
                        <p class="f-12 mb-0"><?=date('Y-m-d', $PRM['dayTimestamp'])?></p>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive agent-performance-table">
                            <table class="table table-bordernone">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-inline-block align-middle">
                                                <div class="d-inline-block"><span class="f-12 f-w-600"><?=_L('Index_User')?></span></span></div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="f-w-600"><?=_L('Index_Rank')?></p>
                                        </td>
                                        <td>
                                            <p class="f-w-600"><?=_L('Livestream_Online_Count')?></p>
                                        </td>
                                        <td>
                                            <p class="f-w-600"><?=_L('Index_Action')?></p>
                                        </td>
                                    </tr>
                                <? $rankI = 0?>
                                <? foreach ($PRM['upListData'] as $k => $v){?>
                                    <tr>
                                        <td>
                                            <div class="d-inline-block align-middle">
                                                <div class="d-inline-block">
                                                    <a target="_blank" href="https://www.acfun.cn/u/<?=$v['uperid']?>">
                                                        <span class="f-12 f-w-600"><?=$v['nowName']?></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="f-w-600"><?
                                                if($k > 0 && $PRM['upListData'][$k - 1]['onlineCount'] == $v['onlineCount']){
                                                    echo($rankI);
                                                }else{
                                                    echo($k + 1);
                                                    $rankI = $k + 1;
                                                }
                                                ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="f-w-600"><?=$v['onlineCount']?></p>
                                        </td>
                                        <td>
                                            <a target="_blank" href="/u/<?=$v['uperid']?>"><button class="btn btn-primary btn-square digits"><?=_L('Index_Detail')?></button></a>
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


