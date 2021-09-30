<?php

namespace App\Controllers;

use App\Models\Enquetes as mEnquetes;
use App\Models\RespostasEnquetes;

class Enquetes extends BaseController
{
    protected $session;

    function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
    }

    public function index()
    {
        if (!$this->session->get('logged')) {
            return view('login');
        }

        $model = new mEnquetes();

        $data = [
            'enquetes'  => $model->where('id_user', $this->session->get('id_user'))->findAll(),
            'title' => 'Enquetes',
        ];

        return view('enquetes/list', $data);
    }

    public function create()
    {
        if (!$this->session->get('logged')) {
            return view('login');
        }
        return view('enquetes/create');
    }

    public function store()
    {
        if (!$this->session->get('logged')) {
            return view('login');
        }

        $request = service('request');
        $postData = $request->getPost();

        $input = $this->validate([
            'pergunta' => 'required|min_length[3]',
            'resposta' => 'required'
        ]);

        if (!$input) {
            return redirect()->to('enquetes/create')->withInput()->with('validation', $this->validator);
        } else {
            $model = new mEnquetes();
            $opResposta = new RespostasEnquetes();

            $model->save([
                'pergunta' => $this->request->getPost('pergunta'),
                'id_user' => $this->session->get('id_user')
            ]);
            $id = $model->getInsertID();
            foreach ($this->request->getPost('resposta') as $key => $value) {
                $opResposta->save([
                    'resposta' => $value['resp'],
                    'votos' => 0,
                    'id_enquete' => $id
                ]);
            }

            return redirect()->to('enquetes');
        }
    }

    public function edit($id)
    {
        if (!$this->session->get('logged')) {
            return view('login');
        }
        $enquetes = new mEnquetes();
        $enquete = $enquetes->where('id_user', $this->session->get('id_user'))->find($id);
        $opResposta = new RespostasEnquetes();

        $data['enquete'] = $enquete;
        $data['opRespostas'] = $opResposta->getOpRespEnquetes($id);
        return view('enquetes/edit', $data);
    }

    public function update($id = 0)
    {
        $request = service('request');
        $postData = $request->getPost();

        if (isset($postData['submit'])) {

            ## Validation
            $input = $this->validate([
                'pergunta' => 'required|min_length[3]',
                'resposta' => 'required'
            ]);

            if (!$input) {
                return redirect()->to('enquetes/edit/' . $id)->withInput()->with('validation', $this->validator);
            } else {

                $enquetes = new mEnquetes();

                $data = [
                    'pergunta' => $postData['pergunta']
                ];

                ## Update record
                if ($enquetes->update($id, $data)) {
                    $opResposta = new RespostasEnquetes();
                    $opResposta->where('id_enquete', $id)->delete();

                    foreach ($postData['resposta'] as $key => $value) {
                        $opResposta->save([
                            'resposta' => $value['resp'],
                            'votos' => 0,
                            'id_enquete' => $id
                        ]);
                    }
                    session()->setFlashdata('message', 'Enquete Atualizada com sucesso!');
                    session()->setFlashdata('alert-class', 'alert-success');

                    return redirect()->to('/enquetes');
                } else {
                    session()->setFlashdata('message', 'Não foi possivel Salvar as alterações!');
                    session()->setFlashdata('alert-class', 'alert-danger');

                    return redirect()->to('enquetes/edit/' . $id)->withInput();
                }
            }
        }
    }

    public function delete($id = 0)
    {
        if (!$this->session->get('logged')) {
            return view('login');
        }

        $enquetes = new mEnquetes();

        ## Check record
        if ($enquetes->find($id)) {

            ## Delete record
            $enquetes->delete($id);
            $opResposta = new RespostasEnquetes();
            $opResposta->where('id_enquete', $id)->delete();

            session()->setFlashdata('message', 'Enquete deletada com Sucesso!');
            session()->setFlashdata('alert-class', 'alert-success');
        } else {
            session()->setFlashdata('message', 'Enquete não encontrada!');
            session()->setFlashdata('alert-class', 'alert-danger');
        }

        return $this->index();
    }

    public function vote($id)
    {
        $enquetes = new mEnquetes();
        $enquete = $enquetes->find($id);
        $opResposta = new RespostasEnquetes();

        $data['enquete'] = $enquete;
        $data['opRespostas'] = $opResposta->getOpRespEnquetes($id);
        return view('enquetes/votar', $data);
    }

    public function resultado($id = 0)
    {
        if ($id == 0) {
            $data['sem'] = true;
        } else {
            $data['sem'] = false;
            $enquetes = new mEnquetes();
            $enquete = $enquetes->find($id);
            $opResposta = new RespostasEnquetes();

            $data['enquete'] = $enquete;
            $data['opRespostas'] = $opResposta->getOpRespEnquetes($id);
            $data['total'] = 0;
            $maiorvoto = 0;
            for ($i = 0; $i < count($data['opRespostas']); $i++) {
                $data['total'] = $data['total'] + $data['opRespostas'][$i]['votos'];
                if ($maiorvoto < $data['opRespostas'][$i]['votos']) {
                    $maiorvoto = $data['opRespostas'][$i]['votos'];
                    $data['idMaiorVoto'] = $data['opRespostas'][$i]['id_respostas_enquetes'];
                }
            }
        }
        return view('enquetes/resultado', $data);
    }

    public function computarvoto()
    {
        $input = $this->validate([
            'id_enquete' => 'required',
            'voto' => 'required'
        ]);

        if (!$input) {
            session()->setFlashdata('message', 'Necessario selecionar uma opção!');
            session()->setFlashdata('alert-class', 'alert-danger');
            return redirect()->to('enquetes/vote/' . $this->request->getPost('id_enquete'))->withInput()->with('validation', $this->validator);
        } else {
            $op = new RespostasEnquetes();
            $op->where('id_respostas_enquetes ', $this->request->getPost('voto'));
            $votos = $op->first();
            $opResposta = new RespostasEnquetes();
            $opResposta->where('id_enquete', $this->request->getPost('id_enquete'));
            $opResposta->where('id_respostas_enquetes ', $this->request->getPost('voto'));
            $opResposta->set(array('votos' => $votos['votos'] + 1));
            $opResposta->update();

            return redirect()->to('enquetes/resultado/' . $this->request->getPost('id_enquete'));
        }
    }
}
