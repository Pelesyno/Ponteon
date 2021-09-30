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

<div class="card mt-4">
    <div class="card-header">
        <?= esc($title) ?>
        <a class="btn btn-info float-right " href="<?= site_url('enquetes/create') ?>">Criar nova enquete</a>
    </div>
    <div class="card-body">
        <?php if (!empty($enquetes) && is_array($enquetes)) : ?>
            <div class="responsive">
                <table class="table table-hover" width="100%" border="1" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th width="40%">Enquetes</th>
                            <th width="35%">Links</th>
                            <th width="25">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($enquetes as $enquete) : ?>
                            <tr>
                                <td><?= $enquete['pergunta'] ?></td>
                                <td>
                                    <span id='<?= $enquete['id_enquete'] ?>'>http://ponteon.dsrtecnologia.com.br/index.php/enquetes/vote/<?= $enquete['id_enquete'] ?></span>
                                    <button class="btn btn-sm btn-primary" onclick="copyDivToClipboard(<?= $enquete['id_enquete'] ?>)">Copiar Link</button>
                                </td>
                                <td align="center">
                                    <a class="btn btn-sm btn-primary" href="<?= site_url('enquetes/resultado/' . $enquete['id_enquete']) ?>">Ver Resultados</a>
                                    <a class="btn btn-sm btn-info" href="<?= site_url('enquetes/edit/' . $enquete['id_enquete']) ?>">Editar</a>
                                    <a class="btn btn-sm btn-danger" href="<?= site_url('enquetes/delete/' . $enquete['id_enquete']) ?>">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else : ?>
                        <tr>
                            <td colspan="4">Nenhuma Enquete Cadastrada!</td>
                        </tr>
                    <?php endif ?>
                    </tbody>
                </table>
                <span id="msg"></span><br>
            </div>
    </div>
</div>

<script>
    function copyDivToClipboard(id) {
        // var id = $(this).attr('id');
        console.log(id);
        copyToClipboardMsg(document.getElementById(id), "msg")
    }
    
    function copyToClipboardMsg(elem, msgElem) {
	  var succeed = copyToClipboard(elem);
    var msg;
    if (!succeed) {
        msg = "Copiar não suportado ou bloqueado."
    } else {
        msg = "Link Copiado para a area de transferencia."
    }
    if (typeof msgElem === "string") {
        msgElem = document.getElementById(msgElem);
    }
    msgElem.innerHTML = msg;
    setTimeout(function() {
        msgElem.innerHTML = "";
    }, 2000);
}

function copyToClipboard(elem) {
	  // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}
</script>
<?= $this->endSection() ?>