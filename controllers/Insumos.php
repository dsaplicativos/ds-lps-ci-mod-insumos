<?php

class Insumos extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('insumos/InsumoModel', 'model');
    }

    /**
     * Página inicial
     * Visualização de lista e criação de elemento
     */
    function index() {
        $v = $this->model->getInsertPageData();
        $v['res'] = $this->model->newServiceInput();
        $data = $this->model->getIndexPageData();
        $data['collapse'] = $this->load->view('insumos/newServiceInput', $v, true);
        $this->show($this->load->view('tableView', $data, true));
    }

    /**
     * Página de edição
     * Visualização de lista e modificação do elemento
     * @param int $id
     */
    function edit($id) {
        $v = $this->model->getEditPageData($id);
        $v['res'] = $this->model->editServiceInput($id);
        $data = $this->model->getIndexPageData(true);
        $data['collapse'] = $this->load->view('insumos/newServiceInput', $v, true);
        $this->show($this->load->view('tableView', $data, true));
    }

    /**
     * Link de remoção de elemento
     * @param int $id
     */
    function delete($id) {
        $this->model->deleteServiceInput($id);
        redirect('/insumos');
    }

}