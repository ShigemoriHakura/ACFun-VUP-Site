<?php include App::$view_root . "/base/common.tpl.php" ?>
<?php include App::$view_root . "/base/header.tpl.php" ?>
<?php include App::$view_root . "/base/sideBar.tpl.php" ?>

<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><i class="f-16 fa fa-home"></i></li>
                        <li class="breadcrumb-item">UP   </li>
                    </ol>
                    <h3><?=_L('Up_Details')?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="user-profile">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>...</h5>
                        </div>
                        <div class="card-body">
                            <!-- cd-timeline Start-->
                            <section class="cd-container" id="cd-timeline">
                                <? if ($PRM['jsonDataReturn']->count() > 0){?>
                                    <?
                                     function getMsecToMescdate($msectime)
                                        {
                                            $msectime = $msectime * 0.001;
                                            if (strstr($msectime, '.')) {
                                                sprintf("%01.3f", $msectime);
                                                list($usec, $sec) = explode(".", $msectime);
                                                $sec = str_pad($sec, 3, "0", STR_PAD_RIGHT);
                                            } else {
                                                $usec = $msectime;
                                                $sec = "000";
                                            }
                                            $date = date("Y-m-d H:i:s", $usec);
                                            return $mescdate = str_replace('x', $sec, $date);
                                        }
                                    ?>
                                    <? foreach ($PRM['jsonDataReturn'] as $k => $v){?>
                                        <div class="cd-timeline-block">
                                            <?if($v['repostSource']){?>
                                                <div class="cd-timeline-img cd-picture bg-success">
                                                    <i class="icon-pulse"></i>
                                                </div>
                                            <? }else{ ?>
                                                <div class="cd-timeline-img cd-picture bg-primary">
                                                    <i class="icon-pencil-alt"></i>
                                                </div>
                                            <? }?>
                                            <div class="cd-timeline-content">
                                                <h4><?=$v['moment']['text']?></h4>
                                                <hr>
                                                <?if($v['repostSource']){?>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <?switch($v['repostSource']['resourceType']){
                                                                        case 10:
                                                                            ?>
                                                                            <span><a href="https://acfun.cn/u/<?=$v['repostSource']['user']['userId']?>">@<?=$v['repostSource']['user']['userName']?></a>: <?=$v['repostSource']['moment']['text']?></span>
                                                                            <?
                                                                        break;
                                                                        case 2:
                                                                            ?>
                                                                            <span><a href="https://acfun.cn/u/<?=$v['repostSource']['user']['userId']?>">@<?=$v['repostSource']['user']['userName']?></a> <h4><?=$v['repostSource']['caption']?></h4></span>
                                                                            <?
                                                                            break;
                                                                    }?>
                                                                    <img class="img-fluid p-t-20" src="<?=$v['coverUrl']?>" alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <? }else{?>
                                                    <? if ($v['coverUrl'] && $v['coverUrl'] != "https://tx-free-imgs.acfun.cn/XBSHVlae6V-6vmAbe-e2YnMv-BNJbau-J3yEjy.png?imageslim"){?>
                                                        <img class="img-fluid p-t-20" src="<?=$v['coverUrl']?>" alt="">
                                                    <?}?>
                                                <?}?>
                                                <p class="m-0"><a href="<?=$v['shareUrl']?>" target="_blank"><button class="btn btn-square digits btn-secondary"><?=_L('Index_Detail')?></button></a></p>
                                                <span class="cd-date"><?=getMsecToMescdate($v['createTime'])?></span>
                                            </div>
                                        </div>
                                    <? }?>
                                <? }else{ ?>
                                <? }?>
                            </section>
                            <!-- cd-timeline Ends-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

<?php include App::$view_root . "/base/footer.tpl.php" ?>