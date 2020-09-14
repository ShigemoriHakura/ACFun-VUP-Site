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
    <br>
    <br>
    <br>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="user-profile">
            <div class="row">
                <!-- user profile first-style start-->
                <div class="col-sm-12">
                    <div class="card hovercard text-center">
                        <div class="user-image">
                            <div class="avatar"><img alt="" src="<?=$PRM['upRawData']['headUrl']?>"></div>
                        </div>
                        <div class="info">
                            <div class="row">
                                <div class="col-sm-6 col-lg-4 order-sm-1 order-xl-0">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="ttl-info text-left">
                                                <h6><i class="fa fa-bookmark-o"></i>   <?=_L('Up_Note')?></h6><span><?=$PRM['upDetail']['name']?></span>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="ttl-info text-left">
                                                <h6><i class="fa fa-cloud"></i>   <?=_L('Up_RegisterDate')?></h6><span><?=$PRM['registerDate']?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4 order-sm-0 order-xl-1">
                                    <div class="user-designation">
                                        <div class="title"><a target="_blank" href="https://www.acfun.cn/u/<?=$PRM['upDetail']['uperid']?>"><?=$PRM['upRawData']['name']?></a></div>
                                        <div class="desc mt-2"><?=$PRM['upRawData']['signature']?></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4 order-sm-2 order-xl-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="ttl-info text-left">
                                                <h6><i class="fa fa-calendar"></i>   <?=_L('Up_ACRegisterDate')?></h6><span><?=$PRM['acRegisterDate']?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="ttl-info text-left">
                                                <h6><i class="fa fa-location-arrow"></i>   <?=_L('Up_LastUpdatedDate')?></h6><span><?=$PRM['updatedDate']?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="follow">
                                <div class="row">
                                    <div class="col-6 text-md-right border-right">
                                        <div class="follow-num counter"><?=$PRM['upRawData']['followers']?></div><span><?=_L('Up_Followers')?></span>
                                    </div>
                                    <div class="col-6 text-md-left">
                                        <div class="follow-num counter"><?=$PRM['upRawData']['following']?></div><span><?=_L('Up_Following')?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- user profile first-style end-->
                <div class="col-sm-12 col-xl-12 box-col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><?=_L('UP_Followers_Title')?></h5>
                        </div>
                        <div class="card-body">
                            <div id="area-spaline-followers"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

<?php include App::$view_root . "/base/footer.tpl.php" ?>

<script>
    var options = {
        series: [{
            name: '<?=_L('Up_Followers')?>',
            data: <?=$PRM['chartData']->json_encode()?>
        }],
        chart: {
            type: 'area',
            stacked: false,
            height: 350,
            zoom: {
                type: 'x',
                enabled: true,
                autoScaleYaxis: true
            },
            toolbar: {
                autoSelected: 'zoom'
            }
        },
        dataLabels: {
            enabled: false
        },
        markers: {
            size: 0,
        },
        title: {
            text: '',
            align: 'left'
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                inverseColors: false,
                opacityFrom: 0.5,
                opacityTo: 0,
                stops: [0, 90, 100]
            },
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return val.toFixed(0);
                },
            },
            title: {
                text: '<?=$PRM['upRawData']['name']?>'
            },
        },
        xaxis: {
            type: 'datetime',
            labels: {
                datetimeUTC: false,
                datetimeFormatter: {
                    year: 'yyyy',
                    month: "MMM 'yy",
                    day: 'dd MMM',
                    hour: 'HH:mm',
                },
            }
        },
        tooltip: {
            shared: false,
            y: {
                formatter: function (val) {
                    return val.toFixed(0);
                }
            }
        }
    };

    var chart1 = new ApexCharts(
        document.querySelector("#area-spaline-followers"),
        options
    );

    chart1.render();
</script>