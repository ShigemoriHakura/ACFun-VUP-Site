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
                    <h3><?=_L('Gift_Detail')?></h3>
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
                        <h5><?=_L('Gift_Detail')?></h5>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive agent-performance-table">
                          <table class="table table-bordernone">
                              <tbody>
                                  <tr>
                                      <td>
                                        <div class="d-inline-block align-middle">
                                          <p class="f-w-600"><?=_L('Gift_Sender')?></p>
                                        </div>
                                      </td>
                                      <td>
                                          <p class="f-w-600"><?=_L('Gift_Num')?></p>
                                      </td>
                                      <td>
                                          <p class="f-w-600"><?=_L('Gift_Price')?></p>
                                      </td>
                                      <td>
                                          <p class="f-w-600"><?=_L('Gift_Time')?></p>
                                      </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            总共礼物
                                        </td>
                                        <td>
                                            <?=$PRM['totalNum']?>
                                        </td>
                                        <td>
                                            总共AC币
                                        </td>
                                        <td>
                                            <?=$PRM['totalPrice']/100?>
                                        </td>
                                    </tr>
                                    <? foreach ($PRM['giftDetail'] as $k => $v){?>
                                        <tr>
                                            <td>
                                                <a target="_blank" href="https://www.acfun.cn/u/<?=$v['senderId']?>"><button class="btn btn-primary btn-square digits"><?=$v['senderName']?></button></a>
                                            </td>
                                            <td>
                                                <p class="f-w-600"><?=$v['num']?></p>
                                            </td>
                                            <td>
                                                <p class="f-w-600"><?=$v['price']/100?></p>
                                            </td>
                                            <td>
                                            <p class="f-12 mb-0"><?=date('Y-m-d H:i:s', $v['add_date'])?></p>
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