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
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro"
            ],
        };

        var chartOptions = {
            responsive: true,
            legend: {
                position: "top"
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

        dataDoughnut = {
            labels: [
                'Masculino',
                'Feminino',
            ]
        };

        var optionsDoughnut = {
            responsive: true,
            legend: {
                position: "top",
                display: true

            },
            title: {
                text: "Sexo",
                display: true
            },
            tooltips: {
                callbacks: {
                    label: function(item, data) {
                        console.log(data.labels, item);
                        return data.datasets[item.datasetIndex].label + " - " + data.labels[item.index] + ": " + data.datasets[item.datasetIndex].data[item.index];
                    }
                }
            },
            rotation: 1 * Math.PI,
            circumference: 1 * Math.PI
        }

        var ctx = document.getElementById("myBarChart").getContext("2d");
        var myBarChart = new Chart(ctx, {
            type: "bar",
            data: barChartData,
            options: chartOptions
        });

        var ctx2 = document.getElementById("myDoughnutChart").getContext("2d");
        var myDoughnutChart = new Chart(ctx2, {
            type: 'doughnut',
            data: dataDoughnut,
            options: optionsDoughnut
        });

        $('#adicionarVacina').click(function() {
            // $("#LoadMe").show();
            var mes = document.getElementById("mes").value;
            var ano = document.getElementById("ano").value;
            var idVacina = document.getElementById("vacina").value;
            var idUnidade = document.getElementById("unidade").value;
            var periodo;

            if ($('#radioMensal').is(':checked')) {
                periodo = document.getElementById("radioMensal").value;
            }
            if ($('#radioAnual').is(':checked')) {
                periodo = document.getElementById("radioAnual").value;
            }

            if ((periodo == null) || (mes == 'Mês') || (ano == 'Ano') || (idVacina == 'Vacina') || (idUnidade == 'Unidade')) {
                alert("Prencha todos os dados antes de continuar.");
            } else {
                var url = ('graficos/idVacina/idUnidade/ano/mes/periodo').replace('idVacina', idVacina);
                url = url.replace('idUnidade', idUnidade);
                url = url.replace('ano', ano);
                url = url.replace('mes', mes);
                url = url.replace('periodo', periodo);

                $.ajax({
                    type: 'POST',
                    url: url,
                    success: function(response) {
                        resposta = JSON.parse(response)
                        console.log(resposta);
                        vacina = document.getElementById("vacina");
                        unidade = document.getElementById("unidade");
                        if (document.getElementById('radioMensal').checked) {
                            labelBarChart = vacina.options[vacina.selectedIndex].text + " (" + unidade.options[unidade.selectedIndex].text + ")";
                            myBarChart.options.title.text = "Vacinas (" + document.getElementById('mes').value + "/" + document.getElementById('ano').value + ")";
                            myDoughnutChart.options.title.text = "Sexo (" + document.getElementById('mes').value + "/" + document.getElementById('ano').value + ")";

                        } else {
                            labelBarChart = vacina.options[vacina.selectedIndex].text + " (" + unidade.options[unidade.selectedIndex].text + ")";
                            myBarChart.options.title.text = "Vacinas (" + document.getElementById('ano').value + ")";
                            myDoughnutChart.options.title.text = "Sexo (" + document.getElementById('ano').value + ")";
                        }


                        var novoDatasetBarChart = {
                            label: labelBarChart,
                            backgroundColor: getRandomColor(),
                            //borderColor: getRandomColor(),
                            //borderWidth: 2,
                            data: resposta[0],
                        }

                        var novoDatasetDoughnutChart = {
                            label: labelBarChart,
                            backgroundColor: [
                                'lightblue',
                                'pink'
                            ],
                            //borderColor: getRandomColor(),
                            //borderWidth: 2,
                            data: resposta[1]
                        }

                        barChartData.datasets.push(novoDatasetBarChart);
                        dataDoughnut.datasets.push(novoDatasetDoughnutChart);

                        myBarChart.update();
                        myDoughnutChart.update();

                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            }

        });

        $('#removerVacina').click(function() {
            barChartData.datasets.pop();
            dataDoughnut.datasets.pop();
            myBarChart.update();
            myDoughnutChart.update();
        });

        $('#radioMensal').click(function() {
            myBarChart.data.datasets = [];
            myDoughnutChart.data.datasets = [];
            myBarChart.data.labels = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10",
                "11", "12", "13", "14", "15", "16", "17", "18", "19", "20",
                "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"
            ];
            labelBarChart = vacina.options[vacina.selectedIndex].text + " (" + unidade.options[unidade.selectedIndex].text + ")";
            myBarChart.options.title.text = "Vacinas (" + document.getElementById('mes').value + "/" + document.getElementById('ano').value + ")";
            myDoughnutChart.options.title.text = "Sexo (" + document.getElementById('mes').value + "/" + document.getElementById('ano').value + ")";

            myBarChart.update();
            myDoughnutChart.update();

        });

        $('#radioAnual').click(function() {
            myBarChart.data.datasets = [];
            myDoughnutChart.data.datasets = [];
            myBarChart.data.labels = [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro"
            ];
            labelBarChart = vacina.options[vacina.selectedIndex].text + " (" + unidade.options[unidade.selectedIndex].text + ")";
            myBarChart.options.title.text = "Vacinas (" + document.getElementById('ano').value + ")";
            myDoughnutChart.options.title.text = "Sexo (" + document.getElementById('ano').value + ")";
            myBarChart.update();
            myDoughnutChart.update();
        });

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

        comboMeses = document.getElementById('mes');
        comboMeses.onchange = function(e) {
            myBarChart.data.datasets = [];
            myDoughnutChart.data.datasets = [];
            if (document.getElementById('radioMensal').checked) {
                labelBarChart = vacina.options[vacina.selectedIndex].text + " (" + unidade.options[unidade.selectedIndex].text + ")";
                myBarChart.options.title.text = "Vacinas (" + document.getElementById('mes').value + "/" + document.getElementById('ano').value + ")";
                myDoughnutChart.options.title.text = "Sexo (" + document.getElementById('mes').value + "/" + document.getElementById('ano').value + ")";

            } else if (document.getElementById('radioAnual').checked) {
                labelBarChart = vacina.options[vacina.selectedIndex].text + " (" + unidade.options[unidade.selectedIndex].text + ")";
                myBarChart.options.title.text = "Vacinas (" + document.getElementById('ano').value + ")";
                myDoughnutChart.options.title.text = "Sexo (" + document.getElementById('ano').value + ")";
            }
            myBarChart.update();
            myDoughnutChart.update();
        }
        comboAnos = document.getElementById('ano');
        comboAnos.onchange = function(e) {
            myBarChart.data.datasets = [];
            myDoughnutChart.data.datasets = [];
            if (document.getElementById('radioMensal').checked) {
                labelBarChart = vacina.options[vacina.selectedIndex].text + " (" + unidade.options[unidade.selectedIndex].text + ")";
                myBarChart.options.title.text = "Vacinas (" + document.getElementById('mes').value + "/" + document.getElementById('ano').value + ")";
                myDoughnutChart.options.title.text = "Sexo (" + document.getElementById('mes').value + "/" + document.getElementById('ano').value + ")";

            } else if (document.getElementById('radioAnual').checked) {
                labelBarChart = vacina.options[vacina.selectedIndex].text + " (" + unidade.options[unidade.selectedIndex].text + ")";
                myBarChart.options.title.text = "Vacinas (" + document.getElementById('ano').value + ")";
                myDoughnutChart.options.title.text = "Sexo (" + document.getElementById('ano').value + ")";
            }
            myBarChart.update();
            myDoughnutChart.update();
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