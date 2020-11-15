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
                    <h3><?=_L('Live_Detail')?></h3>
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
                        <h5><?=_L('Live_Detail')?></h5>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive agent-performance-table">
                          <table class="table table-bordernone">
                              <tbody>
                                  <tr>
                                      <td>
                                        <div class="d-inline-block align-middle">
                                          <p class="f-w-600"><?=_L('Live_LiveId')?></p>
                                        </div>
                                      </td>
                                      <td>
                                          <p class="f-w-600"><?=_L('Live_Title')?></p>
                                      </td>
                                      <td>
                                          <p class="f-w-600"><?=_L('Live_Start')?></p>
                                      </td>
                                      <td>
                                          <p class="f-w-600"><?=_L('Live_End')?></p>
                                      </td>
                                      <td>
                                          <p class="f-w-600"><?=_L('Index_Action')?></p>
                                      </td>
                                  </tr>
                                  <? foreach ($PRM['chartLiveData'] as $k => $v){?>
                                    <tr>
                                        <td>
                                            <p class="f-w-600"><?=$k?></p>
                                        </td>
                                        <td>
                                          <p class="f-12 mb-0"><?=$v['title']?></p>
                                        </td>
                                        <td>
                                          <p class="f-12 mb-0"><?=date('Y-m-d H:i:s', $v['start'])?></p>
                                        </td>
                                        <td>
                                          <p class="f-12 mb-0"><?=date('Y-m-d H:i:s', $v['end'])?></p>
                                        </td>
                                        <td>
                                            <a target="_blank" href="/g/<?=$PRM['upId']?>?start=<?=$v['start']?>&end=<?=$v['end']?>"><button class="btn btn-primary btn-square digits">查看详情</button></a>
                                            <a target="_blank" href="/s/<?=$PRM['upId']?>?start=<?=$v['start']?>&end=<?=$v['end']?>"><button class="btn btn-primary btn-square digits">查看总览</button></a>
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
    </div>
    <!-- Container-fluid Ends-->
</div>

    
<?php include App::$view_root . "/base/footer.tpl.php" ?>