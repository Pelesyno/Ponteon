<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<?php
// Display Response
if (session()->has('message')) {
?>
    <div class="alert <?= session()->getFlashdata('alert-class') ?>">
        <?= session()->getFlashdata('message') ?>
    </div>
<?php
}
?>
<form action="<?= site_url('enquetes/computarvoto') ?>" method="post">
    <div class="row">
        <div class="col-sm-12">
            <div class="card text-white bg-secondary mb-3 mt-4">
                <div class="card-header"><?= $enquete['pergunta']; ?></div>
                <div class="card-body">
                    <input type="hidden" name="id_enquete" value="<?= $enquete['id_enquete'] ?>">
                    <?php foreach ($opRespostas as $opcoes) : ?>
                        <div class="custom-control custom-radio">
                            <input type="radio" value="<?= $opcoes['id_respostas_enquetes'] ?>" id='<?= $opcoes['id_respostas_enquetes'] ?>' name="voto" class="custom-control-input">
                            <label class="custom-control-label" for="<?= $opcoes['id_respostas_enquetes'] ?>"><?= $opcoes['resposta'] ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php if (count($opRespostas) > 1) : ?> 
        <div class="col-sm-12">
            <div class="actionbutton mt-2">
                <button class="btn btn-primary btn-block mb20" type="submit">Votar</button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</form>


<?= $this->endSection() ?>