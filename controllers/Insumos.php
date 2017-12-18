<?php

class Insumos extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('InsumoModel', 'model');
    }

    function index() {
        $v = $this->model->getInsertPageData();
        $v['res'] = $this->model->newServiceInput();
        $data = $this->model->getIndexPageData();
        $data['collapse'] = $this->load->view('service_inputs/newServiceInput', $v, true);
        $this->show($this->load->view('tableView', $data, true));
    }

}