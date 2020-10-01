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
            <div class="col-xl-12 xl-100 box-col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="project-overview">
                            <div class="row">
                                <div class="col-xl-3 col-sm-6 col-6" style="border-left:0px">
                                    <h2 class="f-w-600 font-primary"><?=$PRM['upListCount']?></h2>
                                    <p class="mb-0"><?=_L('Index_UPs')?></p>
                                </div>
                                <div class="col-xl-3 col-sm-6 col-6" style="border-left:0px">
                                    <h2 class="f-w-600 font-secondary"><?=$PRM['upListTodayCount']?></h2>
                                    <p class="mb-0"><?=_L('Index_UPs_Today')?></p>
                                </div>
                                <div class="col-xl-3 col-sm-6 col-6" style="border-left:0px">
                                    <h2 class="f-w-600 font-success"><?=$PRM['upMedalCount']?></h2>
                                    <p class="mb-0"><?=_L('Index_UPs_Medals')?></p>
                                </div>
                                <div class="col-xl-3 col-sm-6 col-6" style="border-left:0px">
                                    <h2 class="f-w-600 font-info"><?=$PRM['upLiveListTodayCount']?></h2>
                                    <p class="mb-0"><?=_L('Index_UPs_Live_Today')?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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

            <div class="col-xl-12 xl-100 box-col-12">
                <div class="card card-with-border overall-rating">
                    <div class="card-header resolve-complain card-no-border">
                        <h5 class="d-inline-block">使用须知</h5><span class="setting-round pull-right d-inline-block mt-0"><i class="fa fa-spin fa-cog"></i></span>
                        <p class="f-12 mb-0">项目开源，地址：<a href="https://github.com/ShigemoriHakura/ACFun-VUP-Site">Github</a></p>
                    </div>
                    <div class="card-body pt-0">
                        <div class="timeline-recent">
                            <div class="media">
                                <div class="timeline-line"></div>
                                <div class="timeline-dot-danger"></div>
                                <div class="media-body"><span class="d-block f-w-600">新收录的VUP不参与当日的榜单排序，因为数据不足。<span class="pull-right light-font f-w-400">2020/9/16</span></span>
                                    <p> <span class="font-danger">白咲 </span>管理员</p>
                                </div>
                            </div>
                            <div class="media">
                                <div class="timeline-dot-success"></div>
                                <div class="media-body"><span class="d-block f-w-600">未收录的请参照下方入库规则联系入库。<span class="pull-right light-font f-w-400">2020/9/16</span></span>
                                    <p> <span class="font-success">白咲 </span>管理员</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 xl-100 box-col-12">
                <div class="card card-with-border overall-rating">
                    <div class="card-header resolve-complain card-no-border">
                        <h5 class="d-inline-block">入库规则</h5><span class="setting-round pull-right d-inline-block mt-0"><i class="fa fa-spin fa-cog"></i></span>
                    </div>
                    <div class="card-body pt-0">
                        <div class="timeline-recent">
                            <div class="media">
                                <div class="timeline-line"></div>
                                <div class="timeline-dot-danger"></div>
                                <div class="media-body"><span class="d-block f-w-600">1.xxx大使，xxx企业偶像，xx吧歌姬等类似的不予收录，我不认可。<span class="pull-right light-font f-w-400">2020/9/16</span></span>
                                    <p> <span class="font-danger">白咲 </span>管理员</p>
                                </div>
                            </div>
                            <div class="media">
                                <div class="timeline-line"></div>
                                <div class="timeline-dot-danger"></div>
                                <div class="media-body"><span class="d-block f-w-600">2.利用动捕技术只做了一个形象然后天天上传舞蹈视频等的，不予收录，我不认可。<span class="pull-right light-font f-w-400">2020/9/16</span></span>
                                    <p> <span class="font-danger">白咲 </span>管理员</p>
                                </div>
                            </div>
                            <div class="media">
                                <div class="timeline-dot-secondary"></div>
                                <div class="media-body"><span class="d-block f-w-600">3.允许转生使用原账号等情况，但是只是说有虚拟形象却根本不用的，不予收录，我不认可。<span class="pull-right light-font f-w-400">2020/9/16</span></span>
                                    <p> <span class="font-secondary">白咲 </span>管理员</p>
                                    <p class="f-12 mb-0">转生可以，但是你至少要做v吧？</p>
                                </div>
                            </div>
                            <div class="media">
                                <div class="timeline-dot-success"></div>
                                <div class="media-body"><span class="d-block f-w-600">如未收录，请私信<a href="https://www.acfun.cn/u/35119946">茂森白咲</a>告知UID<span class="pull-right light-font f-w-400">2020/9/16</span></span>
                                    <p> <span class="font-success">白咲 </span>管理员</p>
                                </div>
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


