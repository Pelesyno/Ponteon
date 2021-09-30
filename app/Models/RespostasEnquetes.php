<?php

namespace App\Models;

use CodeIgniter\Model;

class RespostasEnquetes extends Model
{
    protected $table = 'respostas_enquetes';

    protected $primaryKey = 'id_respostas_enquetes';

    protected $allowedFields = ['id_enquete', 'resposta', 'votos'];

    public function getOpRespEnquetes($id)
    {
        return $this->asArray()
            ->where(['id_enquete' => $id])
            ->findAll();
    }
}