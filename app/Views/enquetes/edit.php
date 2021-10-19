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
<?php $validation = \Config\Services::validation(); ?>
<div class="card mt-4">
    <div class="card-header">
        Alterar Enquete
    </div>
    <div class="card-body">
        <?php if (!empty($enquete) && is_array($enquete)) : ?>
            <form action="<?= site_url('enquetes/update/' . $enquete['id_enquete']) ?>" method="post"  enctype="multipart/form-data">
                <div class="form-group">
                    <label for="pergunta">Pergunta:</label>
                    <input type="text" class="form-control" name="pergunta" required value="<?= old('pergunta', $enquete['pergunta']) ?>">
                    <!-- Error -->
                    <?php if ($validation->getError('pergunta')) { ?>
                        <div class='alert alert-danger mt-2'>
                            <?= $error = $validation->getError('pergunta'); ?>
                        </div>
                    <?php } ?>
                </div>
                <input type="file" class="form-control" name="image" accept='.png'>
                <label>Opções:</label>
                <button type="button" name="add" id="add" class="btn btn-success float-right mb20">Adicionar Resposta</button>
                <table class="table table-bordered" id="add_new_resposta">
                    <?php for ($i = 0; $i < count($opRespostas); ++$i) : ?>
                        <tr id="row<?= $i ?>">
                            <td>
                                <input type="text" name="resposta[][resp]" class="form-control name_list" required="" value="<?= old('resposta', $opRespostas[$i]['resposta']) ?>" />
                            </td>
                            <?php if($i == 0): ?>
                            <td rowspan="2">
                                <?php
                                $url = base_url() . '/imagens/' . $enquete['id_enquete'] . '.png';
                                $file_headers = @get_headers($url);
                                if ($file_headers[0] !== 'HTTP/1.1 404 Not Found') : ?>
                                    <img class="float-right" src='<?= $url ?>' alt="Imagem da Enquete" width="150">
                                <?php endif; ?>
                            </td>
                            <?php endif; ?>
                            <?php if ($i > 1) : ?>
                                <td>
                                    <button type="button" name="remove" id="<?= $i ?>" class="btn btn-danger btn_remove">X</button>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endfor; ?>
                </table>

                <button type="submit" class="btn btn-success" name="submit">Alterar</button>
            </form>
        <?php else : ?>
            <div>Enquete não encontrada!</div>
        <?php endif ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var i = 2;

        $('#add').click(function() {
            console.log('click_add')
            if (i < 10) {
                i++;
                $('#add_new_resposta').append('<tr id="row' + i + '" class="dynamic-added"><td><input type="text" name="resposta[][resp]" placeholder="Resposta" class="form-control name_list" required /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
            }
            if (i == 10) {
                $('#add').prop("disabled", true);
            }
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            console.log(button_id);
            i--;
            $('#row' + button_id + '').remove();
            if (i == 9) {
                $('#add').prop("disabled", false);
            }
        });

    });
</script>

<?= $this->endSection() ?>