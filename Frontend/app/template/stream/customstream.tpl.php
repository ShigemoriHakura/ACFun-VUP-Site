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
                        <?=_L('Index_Rank')?></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <? if ($PRM['upData']->count() > 0){?>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="area-spaline-data"></div>
                        </div>
                    </div>
                </div>
            <?}?>

            <div class="col-xl-12">
                <div class="card card-with-border overall-rating">
                    <div class="card-header">
                        <h5 class="d-inline-block"><?=_L('Customstream_Title')?></h5><span class="setting-round pull-right d-inline-block mt-0"><i class="fa fa-spin fa-cog"></i></span>
                        <p class="f-12 mb-0"><?=_L('Customstream_Desc')?></p>
                    </div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" action="<?=$webRoot?>/custom" method="post">
                            <input type="text" name="_csrf" hidden value="<?=$this->getCsrfToken()?>"/>
                            <div class="row">
                                <? foreach ($PRM['upList'] as $up){?>
                                    <div class="col-xl-6 col-sm-12">
                                            <label class="d-block" for="chk-ani">
                                                <input name="ups[]" class="checkbox_animated" type="checkbox" value="<?=$up['uperid']?>" <?if($PRM['upSelected']->in_array($up['uperid']))echo("checked")?>><?=$up['nowName']?>
                                            </label>
                                    </div>
                                <?}?>
                            </div>

                            <hr>
                            <button class="btn btn-primary" type="submit"><?=_L('Customstream_Submitbtn')?></button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>


<?php include App::$view_root . "/base/footer.tpl.php" ?>

<? if ($PRM['upData']->count() > 0){?>
<script>
    var optionsUpAll = {
        series: <?=str_replace('"data"', "data", str_replace('"name"', "name", $PRM['upData']->json_encode()))?> ,
        chart: {
            type: 'area',
            height: 650,
            stacked: false,
            animations: {
                enabled: false,
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
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
        xaxis: {
            type: 'datetime'
        },
        tooltip: {
            shared: true,
            x: {
                format: 'yy/MM/dd HH:mm'
            },
            y: {
                formatter: function (val) {
                    return val.toFixed(0);
                }
            }
        }
    };

    var chartUpAll = new ApexCharts(
        document.querySelector("#area-spaline-data"),
        optionsUpAll
    );
    chartUpAll.render();
</script>

<?}?>