<?php

class Insumos extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('insumos/InsumoModel', 'model');
    }

    function index() {
        $v = $this->model->getInsertPageData();
        $v['res'] = $this->model->newServiceInput();
        $data = $this->model->getIndexPageData();
        $data['collapse'] = $this->load->view('insumos/newServiceInput', $v, true);
        $this->show($this->load->view('tableView', $data, true));
    }

}