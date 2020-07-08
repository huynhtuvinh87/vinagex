<?php
/* @var $this yii\web\View */

$this->title = 'ADMINSTRATOR';
?>

<!-- top tiles -->
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-default">

                          <div class="panel-heading">
                            <h3 class="panel-title">Số lượng người mua</h3>
                          </div>

                          <div class="panel-body">
                               <h3><p class="text-center"><?= $totalMember; ?></p></h3>
                          </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="panel panel-default">

                          <div class="panel-heading">
                            <h3 class="panel-title">Số lượng người bán</h3>
                          </div>

                          <div class="panel-body">
                             <h3><p class="text-center"><?= $totalSeller; ?></p></h3>
                          </div>
                    </div>
                </div>

                 <div class="col-md-3">
                    <div class="panel panel-default">

                          <div class="panel-heading">
                            <h3 class="panel-title">Số lượng sản phẩm đăng bán</h3>
                          </div>

                          <div class="panel-body">
                            <h3><p class="text-center"><?= $totalProduct; ?></p></h3>
                          </div>
                    </div>
                </div>

                 <div class="col-md-3">
                    <div class="panel panel-default">

                          <div class="panel-heading">
                            <h3 class="panel-title">Số lượng cuộc trò chuyện</h3>
                          </div>

                          <div class="panel-body">
                           <h3><p class="text-center"><?= $totalMessage; ?></p></h3>
                          </div>
                    </div>
                </div>

                <?php foreach ($category as $value) { ?>
                    <div class="col-md-2">
                    <div class="panel panel-default">

                          <div class="panel-heading">
                            <h3 class="panel-title"><?php echo $value->title; ?></h3>
                          </div>

                          <div class="panel-body">
                           <h3><p class="text-center"><?php echo $value->count; ?></p></h3>
                          </div>
                    </div>
                </div>
                <?php } ?>

            </div>     

            <div class="clearfix"></div>

<?= $this->registerJs('
    var lineChartData = {
                labels: ["1/08", "2/08", "3/08", "4/08", "5/08", "6/08", "7/08", "8/08", "9/08", "10/08", "11/08"],
                datasets: [
                    {
                        label: "My First dataset",
                        fillColor: "rgba(38, 185, 154, 0.21)", //rgba(220,220,220,0.2)
                        strokeColor: "rgba(38, 185, 154, 0.7)", //rgba(220,220,220,1)
                        pointColor: "rgba(38, 185, 154, 0.7)", //rgba(220,220,220,1)
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: [652, 674, 556, 739, 720, 785, 627, 785, 852, 900, 891]
                    },
                    {
                        label: "My Second dataset",
                        fillColor: "rgba(3, 88, 106, 0.2)", //rgba(151,187,205,0.2)
                        strokeColor: "rgba(3, 88, 106, 0.70)", //rgba(151,187,205,1)
                        pointColor: "rgba(3, 88, 106, 0.70)", //rgba(151,187,205,1)
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: [820, 713, 676, 916, 992, 849, 721, 821, 792, 700, 682]
                    }
                ]

            }

            $(document).ready(function () {
                new Chart(document.getElementById("canvas000").getContext("2d")).Line(lineChartData, {
                    responsive: true,
                    tooltipFillColor: "rgba(51, 51, 51, 0.55)"
                });
            });    
')?>