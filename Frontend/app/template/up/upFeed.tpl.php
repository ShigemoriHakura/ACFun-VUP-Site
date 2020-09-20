<?php include App::$view_root . "/base/common.tpl.php" ?>
<?php include App::$view_root . "/base/header.tpl.php" ?>
<?php include App::$view_root . "/base/sideBar.tpl.php" ?>

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

<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><i class="f-16 fa fa-home"></i></li>
                        <li class="breadcrumb-item">UP   </li>
                    </ol>
                    <h3><?=_L('UP_Details')?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="user-profile">
            <div class="row">
                <div class="col-xl-12 xl-50 box-col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><?=_L('UP_Feed')?></h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline-small">
								<br>
                                <? if ($PRM['jsonDataReturn']->count() > 0){?>
                                    <? foreach ($PRM['jsonDataReturn'] as $k => $v){?>
                                        <div class="media">
                                            <div class="timeline-round m-r-30 timeline-line-1 bg-primary">
                                                <?if($v['repostSource']){?>
                                                    <i data-feather="tag"></i>
                                                <? }else{ ?>
                                                    <i data-feather="message-circle"></i>
                                                <? }?>
                                            </div>
                                            <div class="media-body">
                                                <? switch($v['resourceType']){
                                                    case 2: //投稿视频
                                                        ?>
                                                        <h6><a href="https://acfun.cn/u/<?=$v['user']['userId']?>">@<?=$v['user']['userName']?></a>: <span class="pull-right f-14"><?=getMsecToMescdate($v['createTime'])?></span></h6>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <h6><a href="<?=$v['shareUrl']?>"><?=html_entity_decode($v['caption'])?></a></h6>
                                                                        <div class="attachment">
                                                                            <ul class="list-inline">
                                                                                <li class="list-inline-item"><img class="img-fluid" style="height:200px" src="<?=$v['coverUrl']?>" alt=""></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?
                                                        break;
                                                    case 3: //投稿文章
                                                        ?>
                                                        <h6><a href="https://acfun.cn/u/<?=$v['user']['userId']?>">@<?=$v['user']['userName']?></a>: <span class="pull-right f-14"><?=getMsecToMescdate($v['createTime'])?></span></h6>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <h6><a href="<?=$v['shareUrl']?>"><?=html_entity_decode($v['articleTitle'])?></a></h6>
                                                                        <p><?=html_entity_decode($v['articleBody'])?></p>
                                                                        <div class="attachment">
                                                                            <ul class="list-inline">
                                                                                <li class="list-inline-item"><img class="img-fluid" style="height:200px" src="<?=$v['coverUrl']?>" alt=""></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?
                                                        break;
                                                    case 10: //普通动态
                                                        ?>
                                                        <h6><a href="https://acfun.cn/u/<?=$v['user']['userId']?>">@<?=$v['user']['userName']?></a>: <span class="pull-right f-14"><?=getMsecToMescdate($v['createTime'])?></span></h6>
                                                        <p><?=html_entity_decode($v['moment']['text'])?></p>
                                                        <?if($v['repostSource']){ //转载内容?>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <?switch($v['repostSource']['resourceType']){
                                                                            case 2:
                                                                            case 3:
                                                                                ?>
                                                                                <h6><a href="https://acfun.cn/u/<?=$v['repostSource']['user']['userId']?>">@<?=$v['repostSource']['user']['userName']?></a>:</h6>
                                                                                <div class="attachment">
                                                                                    <ul class="list-inline">
                                                                                        <h6><a href="<?=$v['repostSource']['shareUrl']?>"><?=html_entity_decode($v['repostSource']['caption'])?></a></h6>
                                                                                        <li class="list-inline-item"><img class="img-fluid" style="height:200px" src="<?=$v['repostSource']['coverUrl']?>" alt=""></li>
                                                                                    </ul>
                                                                                </div>
                                                                                <?
                                                                                break;
                                                                            case 10: //普通动态
                                                                                ?>
                                                                                <h6><a href="https://acfun.cn/u/<?=$v['repostSource']['user']['userId']?>">@<?=$v['repostSource']['user']['userName']?></a>:</h6>
                                                                                <p><?=html_entity_decode($v['repostSource']['moment']['text'])?></p>
                                                                                <? if ($v['repostSource']['moment']['imgs']){?>
                                                                                    <div class="attachment">
                                                                                        <ul class="list-inline">
                                                                                            <?foreach ($v['repostSource']['moment']['imgs'] as $img){?>
                                                                                                <li class="list-inline-item"><img class="img-fluid" style="height:200px" src="<?=$img['url']?>" alt=""></li>
                                                                                            <?}?>
                                                                                        </ul>
                                                                                    </div>
                                                                                <?}?>
                                                                            <?
                                                                            break;
                                                                        }?>
                                                                        <br>
                                                                        <p class="m-0"><a href="<?=$v['repostSource']['shareUrl']?>" target="_blank"><button class="btn btn-square digits btn-secondary"><?=_L('Index_Detail')?></button></a></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <? }else{?>
                                                            <div class="attachment">
                                                                <ul class="list-inline">
                                                                <? if ($v['moment']['imgs']){
                                                                    foreach ($v['moment']['imgs'] as $img){?>
                                                                        <li class="list-inline-item"><img class="img-fluid" style="height:200px" src="<?=$img['url']?>" alt=""></li>
                                                                    <?}
                                                                }?>
                                                                </ul>
                                                            </div>
                                                        <?}?>
                                                        <?
                                                        break;

                                                }?>
                                                <br>
                                                <p class="m-0"><a href="<?=$v['shareUrl']?>" target="_blank"><button class="btn btn-square digits btn-secondary"><?=_L('Index_Detail')?></button></a></p>
                                                <hr>
                                            </div>
                                        </div>
                                    <? }?>
                                <? }else{ ?>
                                <? }?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

<?php include App::$view_root . "/base/footer.tpl.php" ?>