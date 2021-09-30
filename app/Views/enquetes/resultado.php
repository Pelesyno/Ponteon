<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<?php if (!$sem) : ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white bg-secondary mb-3 mt-4">
                <div class="card-header"><?= $enquete['pergunta']; ?></div>
                <div class="card-body">
                    <?php if ($total == 0) :
                    ?>
                        Essa Enquete ainda não recebeu Votos.<br>
                        <?php
                    else :
                        foreach ($opRespostas as $opcoes) :

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
                <a class="btn btn-primary mb20" href="http://ponteon.dsrtecnologia.com.br/index.php/enquetes/vote/<?= $enquete['id_enquete'] ?>">Votar Novamente</a>
            </div>
        </div>
    </div>
<?php else : ?>
    Enquete não localizada.
<?php endif ?>

<?= $this->endSection() ?>