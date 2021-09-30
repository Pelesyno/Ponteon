<?php

namespace App\Models;

use CodeIgniter\Model;

class Enquetes extends Model
{
    protected $table = 'enquetes';

    protected $primaryKey = 'id_enquete';

    protected $allowedFields = ['pergunta', 'url', 'id_user'];

    public function getEnquetes($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->asArray()
            ->where(['id_enquete' => $id])
            ->first();
    }
}
