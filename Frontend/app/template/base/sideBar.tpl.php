<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="theme-loader"></div>
</div>
<!-- Loader ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <div class="page-main-header">
        <div class="main-header-right">
            <div class="main-header-left">
                <div class="logo-wrapper"><a href="/"><img src="<?=$webRoot?>/assets/images/logo/logo.png" alt=""></a></div>
            </div>
            <div class="mobile-sidebar">
                <div class="media-body text-right switch-sm">
                    <label class="switch">
                        <input id="sidebar-toggle" type="checkbox" data-toggle=".container" checked="checked"><span class="switch-state"></span>
                    </label>
                </div>
            </div>
            <div class="nav-right col pull-right right-menu">
                <ul class="nav-menus">
                    <li class="px-0">
                        <form class="form-inline search-form" action="<?=$webRoot?>/search">
                            <input name="keyword" class="form-control-plaintext" placeholder="<?=_L('Sidebar_Search') ?>....."><i class="close-search" data-feather="x"></i>
                            <input type="submit" style="display:none">
                        </form><span class="mobile-search"><i data-feather="search"></i></span>
                    </li>
                    <li class="onhover-dropdown"><i data-feather="globe"></i>
                        <ul class="chat-dropdown onhover-show-div p-t-20 p-b-20">
                            <li>
                                <div class="media">
                                    <div class="media-body"><a href="?lang=cn"><span class="f-w-600">简体中文</span></a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="media">
                                    <div class="media-body"><a href="?lang=en"><span class="f-w-600">English</span></a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
                    <li class="onhover-dropdown px-0">
                        <span class="media user-header">
                        <? if ($PRM('adminData')) {?>
                        <span class="media-body"><span class="f-12 f-w-600"><?=$PRM['adminData']['username']?></span></span></span>
                        <ul class="profile-dropdown onhover-show-div">
                            <li class="f-w-600">Home</li>
                            <a href="<?=$webRoot?>/submit"><li class="f-12"><i data-feather="chevron-right"> </i><?=_L('Sidebar_Submit') ?></li></a>
                            <a href="<?=$webRoot?>/logout"><li><i data-feather="log-in"></i><?=_L('Sidebar_Logout') ?></li></a>
                        </ul>
                        <? }else{ ?>
                            <span class="media-body"><span class="f-12 f-w-600"><?=_L('Sidebar_User') ?></span></span></span>
                            <ul class="profile-dropdown onhover-show-div">
                                <li class="f-w-600">Home</li>
                                <a href="<?=$webRoot?>/login"><li class="f-12"><i data-feather="chevron-right"> </i><?=_L('Sidebar_Login') ?></li></a>
                            </ul>
                        <? }?>
                    </li>
                </ul>
            </div>
            <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
        </div>
    </div>
    <!-- Page Header Ends                              -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper sidebar-icon">
        <nav-menus></nav-menus>
        <header class="main-nav close_icon">
            <nav>
                <div class="main-navbar">
                    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                    <div id="mainnav">
                        <ul class="nav-menu custom-scrollbar">
                            <li class="back-btn">
                                <div class="mobile-back text-right"><span>Back</span><i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
                            </li>
                            <li class="dropdown"><a class="nav-link menu-title" href="#"><i data-feather="home"></i><span><?=_L('Sidebar_Index') ?></span></a>
                                <ul class="nav-submenu menu-content">
                                    <li><a href="<?=$webRoot?>/"><?=_L('Sidebar_Index') ?></a></li>
                                    <li><a href="<?=$webRoot?>/search"><?=_L('Sidebar_Search') ?></a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a class="nav-link menu-title" href="#"><i data-feather="bar-chart-2"></i><span><?=_L('Sidebar_List') ?></span></a>
                                <ul class="nav-submenu menu-content">
                                    <li><a href="<?=$webRoot?>/new"><?=_L('Sidebar_Newstream') ?></a></li>
                                    <li><a href="<?=$webRoot?>/ups"><?=_L('Sidebar_Upstream') ?></a></li>
                                    <li><a href="<?=$webRoot?>/daily"><?=_L('Sidebar_Dailystream') ?></a></li>
                                    <li><a href="<?=$webRoot?>/custom"><?=_L('Sidebar_Customstream') ?></a></li>
                                </ul>
                            </li>

                            <li class="dropdown"><a class="nav-link menu-title" href="#"><i data-feather="archive"></i><span><?=_L('Sidebar_Prev_List') ?></span></a>
                                <ul class="nav-submenu menu-content">
                                    <li><a href="<?=$webRoot?>/ups/prev/1"><?=_L('Sidebar_Prev_Upstream') ?></a></li>
                                    <li><a href="<?=$webRoot?>/daily/prev/1"><?=_L('Sidebar_Prev_Dailystream') ?></a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a class="nav-link menu-title" href="#"><i data-feather="tag"></i><span><?=_L('Sidebar_Medal') ?></span></a>
                                <ul class="nav-submenu menu-content">
                                    <li><a href="<?=$webRoot?>/medal/list"><?=_L('Sidebar_MedalList') ?></a></li>
                                    <li><a href="<?=$webRoot?>/medal/search"><?=_L('Sidebar_MedalSearch') ?></a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a class="nav-link menu-title" href="#"><i data-feather="settings"></i><span><?=_L('Sidebar_Admin') ?></span></a>
                                <ul class="nav-submenu menu-content">
                                    <li><a href="<?=$webRoot?>/update_log"><?=_L('Sidebar_Update_Log') ?></a></li>
                                    <? if ($PRM('adminData')) {?>
                                        <li><a href="<?=$webRoot?>/submit"><?=_L('Sidebar_Submit') ?></a></li>
                                        <li><a href="<?=$webRoot?>/log_submit"><?=_L('Sidebar_Log_Submit') ?></a></li>
                                        <li><a href="<?=$webRoot?>/logout"><?=_L('Sidebar_Logout') ?></a></li>
                                    <? }else{ ?>
                                        <li><a href="<?=$webRoot?>/login"><?=_L('Sidebar_Login') ?></a></li>
                                    <? } ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                </div>
            </nav>
        </header>