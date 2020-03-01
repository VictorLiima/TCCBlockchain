@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

@endpush

@extends('layouts.app')

@section('content')
<div class="container">
    <div id="top" class="row">
        <div class="col-md-3">
            <h2><i class="fas fa-chart-bar"></i> Resultado</a></h2>
        </div>
    </div>


    <canvas id="myBarChart" width="50vh" height="20vh"></canvas>
    <canvas id="myDoughnutChart" width="50vh" height="20vh"></canvas>
    <script>
        var barChartData = {
            labels: [
                <?php
                foreach ($listaCandidatos as $candidato) {
                    echo '"' . $candidato->nome . '",';
                }
                ?>
            ],
        };

        var chartOptions = {
            responsive: true,
            legend: {
                display: false
            },
            title: {
                display: true,
                text: "Votos por candidato"
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }



        var ctx = document.getElementById("myBarChart").getContext("2d");
        var myBarChart = new Chart(ctx, {
            type: "bar",
            data: barChartData,
            options: chartOptions,

        });

        var novoDatasetBarChart = {
            backgroundColor: [
                <?php
                foreach ($listaCandidatos as $candidato) {
                    echo 'getRandomColor()' . ',';
                }
                ?>

            ],
            data: [
                <?php
                // $result = mysql_query("SELECT * FROM candidatos");

                // while ($row = mysql_fetch_array($result)) {
                //     $blockchain = fopen("blockchain/blocks.txt", "r");
                //     $candidate = $row['candidate_name'];

                //     $votes = 0;
                //     while (!feof($blockchain)) {
                //         $data = fgets($blockchain);
                //         if (substr_count($data, $candidate)) {
                //             $votes += substr_count($data, $candidate);
                //         }
                //     }

                //     fclose($blockchain);
                // }

                

                foreach ($listaCandidatos as $candidato) {
                    $blockchain = fopen("../blockchain/blocks.txt", "r");
                    $candidate = $candidato->nome;
                    $votes = 0;
                    while (!feof($blockchain)) {
                        $data = fgets($blockchain);
                        if (substr_count($data, $candidate)) {
                            $votes += substr_count($data, $candidate);
                        }
                    }
                    echo $votes . ',';
                    fclose($blockchain);
                }
               

                ?>
            ],
        }

        barChartData.datasets.push(novoDatasetBarChart);

        myBarChart.update();

        function getRandomRgba() {
            var o = Math.round,
                r = Math.random,
                s = 255;
            return 'rgba(' + o(r() * s) + ',' + o(r() * s) + ',' + o(r() * s) + ')';
        }

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>

    <div class="carregando" id="loading">
    </div>

    <script>
        $(function() {
            var loading = $("#loading");
            $(document).ajaxStart(function() {
                loading.show();
            });

            $(document).ajaxStop(function() {
                loading.hide();
            });
        });
    </script>

</div>

@endsection