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
                        <h5 class="d-inline-block"><?=_L('Ddstream_Title')?></h5><span class="setting-round pull-right d-inline-block mt-0"><i class="fa fa-spin fa-cog"></i></span>
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
                                            <p class="f-w-600"><?=_L('Gift_Price')?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            总共礼物 <?=$PRM['totalNum']?> 件
                                        </td>
                                        <td>
                                            总共AC币
                                        </td>
                                        <td>
                                            <?=$PRM['totalPrice']/100?>
                                        </td>
                                    </tr>
                                <? $rankI = 0?>
                                <? foreach ($PRM['ddDetail'] as $k => $v){?>
                                        <tr>
                                            <td>
                                                <div class="d-inline-block align-middle"><img class="img-radius img-40 align-top m-r-15 rounded-circle" src="<?=$v['rawData']['headUrl']?>" alt="">
                                                    <div class="d-inline-block">
                                                        <a target="_blank" href="https://www.acfun.cn/u/<?=$v['senderId']?>">
                                                            <span class="f-12 f-w-600"><?=$v['senderName']?></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="f-w-600"><?
                                                    if($k > 0 && $PRM['ddDetail'][$k - 1]['price'] == $v['price']){
                                                        echo($rankI);
                                                    }else{
                                                        echo($k + 1);
                                                        $rankI = $k + 1;
                                                    }
                                                    ?>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="f-w-600"><?=$v['price']/100?></p>
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


