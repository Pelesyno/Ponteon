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
        Adicionar Enquete
    </div>
    <div class="card-body">
    <form action="<?= site_url('enquetes/store') ?>" method="post">
            <div class="form-group">
                <label for="pergunta">Pergunta:</label>
                <input type="text" class="form-control" name="pergunta" required value="<?= old('pergunta') ?>">

                <!-- Error -->
                <?php if ($validation->getError('pergunta')) { ?>
                    <div class='alert alert-danger mt-2'>
                        <?= $error = $validation->getError('pergunta'); ?>
                    </div>
                <?php } ?>
            </div>
            <table class="table table-bordered" id="add_new_resposta">
                <tr>
                    <td><input type="text" name="resposta[][resp]" placeholder="Resposta 1" class="form-control name_list" required="" /></td>
                </tr>
                <tr>
                    <td><input type="text" name="resposta[][resp]" placeholder="Resposta 2" class="form-control name_list" required="" /></td>
                    <td id='resp2'><button type="button" name="add" id="add" class="btn btn-success">Adicionar Resposta</button></td>
                </tr>
            </table>

            <button type="submit" class="btn btn-success" name="submit">Enviar</button>
        </form>
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
            i--;
            $('#row' + button_id + '').remove();
            if (i == 9) {
                $('#add').prop("disabled", false);
            }
        });

    });
</script>

<?= $this->endSection() ?>