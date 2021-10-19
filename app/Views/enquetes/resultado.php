<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<?php if (!$sem) :
    $array_Chart = []; ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white bg-secondary mb-3 mt-4">
                <div class="card-header">
                    <?= $enquete['pergunta']; ?>
                    <?php
                    $url = base_url() . '/imagens/' . $enquete['id_enquete'] . '.png';
                    $file_headers = @get_headers($url);
                    if ($file_headers[0] !== 'HTTP/1.1 404 Not Found') : ?>
                        <img class="float-right" src='<?= $url ?>' alt="Imagem da Enquete" width="150">
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if ($total == 0) :
                    ?>
                        Essa Enquete ainda não recebeu Votos.<br>
                        <?php
                    else :
                        foreach ($opRespostas as $opcoes) :

                            $array_Chart[] = [
                                'name' => $opcoes['resposta'],
                                'y' => floatval($opcoes['votos'])
                            ];

                            $tper = number_format(($opcoes['votos'] / $total) * 100, 0);
                            echo $opcoes['votos'] . ' - ' . $opcoes['resposta'];
                            if ($idMaiorVoto == $opcoes['id_respostas_enquetes']) :
                        ?>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?= $tper ?>%" aria-valuenow="<?= $tper ?>" aria-valuemin="0" aria-valuemax="100"><?= $tper ?>%</div>
                                </div>
                            <?php
                            else :
                            ?>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: <?= $tper ?>%" aria-valuenow="<?= $tper ?>" aria-valuemin="0" aria-valuemax="100"><?= $tper ?>%</div>
                                </div>
                    <?php endif;
                        endforeach;
                    endif;
                    ?>
                    Total de Votos: <?= $total ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="actionbutton mt-2">
                <a class="btn btn-primary mb20" href="<?= base_url('enquetes/vote') . '/' . $enquete['id_enquete'] ?>">Votar Novamente</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <figure class="highcharts-figure">
                <div id="container"></div>

            </figure>
        </div>
    </div>

    <script>
        Highcharts.setOptions({
            colors: Highcharts.map(Highcharts.getOptions().colors, function(color) {
                return {
                    radialGradient: {
                        cx: 0.5,
                        cy: 0.3,
                        r: 0.7
                    },
                    stops: [
                        [0, color],
                        [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                    ]
                };
            })
        });

        // Build the chart
        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '<?= $enquete['pergunta']; ?>'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        connectorColor: 'silver'
                    }
                }
            },
            series: [{
                name: 'Share',
                data: <?php echo json_encode($array_Chart); ?>
            }]
        });
    </script>
<?php else : ?>
    Enquete não localizada.
<?php endif ?>

<?= $this->endSection() ?>