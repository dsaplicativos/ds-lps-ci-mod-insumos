<?php

include_once APPPATH . 'modules/insumos/libraries/Insumo.php';
include_once APPPATH . 'libraries/component/Table.php';

class InsumoModel extends CI_Model {

    /**
     * @var Insumo
     */
    private $insumo;

    /**
     * InsumoModel constructor.
     * Criação de objeto Insumo
     * Carregamento de dependências do CodeIgniter (prevenindo falhas de autoload)
     */
    public function __construct()
    {
        parent::__construct();
        $this->insumo = new Insumo();
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    /**
     * Criação de variáveis para a view de página principal (index)
     * @param bool $edit
     * @return array
     */
    function getIndexPageData($edit = false) {
        if ($edit == false) {
            $data['collapse_btn'] = 1;
            $data['label'] = 'Adicionar';
            $data['collapse_id'] = 'newServiceInput';
        }
        $data['setMargin'] = true;
        $data['title'] = 'Equipamentos e Produtos';
        $data['content'] = $this->listServiceInputs();
        return $data;
    }

    /**
     * Criação de variáveis para collapse de criação de insumo
     * @return array
     */
    function getInsertPageData() {
        $data['title'] = 'Novo equipamento/produto';
        $data['action'] = 'insumos/index';
        return $data;
    }

    /**
     * Criação de variáveis para collapse de edição de insumo
     * @param int $id
     * @return array
     */
    function getEditPageData($id) {
        $data['showCollapse'] = 1;
        $data['title'] = 'Editar equipamento/produto';
        $data['action'] = 'insumos/edit/' . $id;
        return $data;
    }

    /**
     * Recuperação de dados enviados por formulário via POST
     * @return array
     */
    private function getPostServiceInput() {
        $data['nome'] = $this->input->post('nome');
        $data['marca'] = $this->input->post('marca');
        $data['observacao'] = $this->input->post('observacao');
        return $data;
    }

    /**
     * Validação de formulário
     */
    private function validate() {
        $this->form_validation->set_rules('nome', 'Nome', 'required|max_length[250]');
        $this->form_validation->set_rules('marca', 'Marca', 'required|max_length[250]');
        $this->form_validation->set_rules('observacao', 'Observacao', 'max_length[250]');
    }

    /**
     * Criação de Insumo
     */
    function newServiceInput() {
        $this->validate();
        if ($this->form_validation->run()) {
            $data = $this->getPostServiceInput();
            if ($this->insumo->newServiceInput($data)) {
                redirect('/insumos');
            }
        }
        else {
            return validation_errors();
        }
    }

    /**
     * Remoção de insumo
     * @param int $id
     * @return method
     */
    function deleteServiceInput($id) {
        return $this->insumo->deleteServiceInput($id);
    }

    /**
     * Edição de dados de insumo
     * @param int $id
     * @return array
     */
    function editServiceInput($id) {
        if (sizeof($_POST) > 0) {
            $this->validate();
            if ($this->form_validation->run()) {
                $data = $this->getPostServiceInput();
                if ($this->insumo->editServiceInput($id, $data)) {
                    redirect('/insumos');
                }
            }
            return validation_errors();
        }
        else {
            $this->getServiceInputData($id);
        }
    }

    /**
     * Retorna dados específicos de um insumo
     * @param int $id
     */
    private function getServiceInputData($id) {
        $data = $this->insumo->getServiceInputData($id)[0];
        $keys = array_keys($data);
        foreach ($keys as $key) {
            $_POST[$key] = $data[$key];
        }
    }

    /**
     * Retorna dados de um insumo para visualização
     * @param int $id
     */
    function viewServiceInputData($id) {
        return $this->getServiceInputData($id);
    }

    /**
     * Apresenta uma tabela com a lista de insumos cadastrados, caso exista.
     * @return string
     */
    function listServiceInputs() {
        $list = $this->insumo->getServiceInputs();
        if (sizeof($list) > 0) {
            $labels = array('Nome', 'Marca', 'Observação', '', '');
            $i = 0;
            foreach ($list as $item) {
                $data[$i]['nome'] = $item->nome;
                $data[$i]['marca'] = $item->marca;
                $data[$i]['observacao'] = $item->observacao;
                $data[$i]['btn'] = $this->getActionButtons($item->id, $item->nome);
                $data[$i]['id'] = $item->id;
            }
            $data = Table::buildDataArray($data, $labels);
            $table = new Table($data);
            $table->setColWidths(array(18, 18, 54, 10));
            return $table->getHTML();
        }
        return '<div class="container">Nenhum insumo cadastrado.</div>';
    }

    /**
     * Gera botões de ação para cada linha da tabela
     * @param int $id
     * @param string $name
     * @return string
     */
    private function getActionButtons($id, $name) {
        $html = "<a class='' href='" . base_url('/insumos/edit/' . $id) . "'><i class='fa fa-pencil fa-lg fa-fw'></i></a>";
        $html .= "<a href='" . base_url('/insumos/delete/' . $id) . "' class='red-text' onclick=\"return confirm('Excluir Insumo: " . trim($name) . "?'); return false;\"><i class='fa fa-times fa-lg fa-fw'></i></a>";
        return $html;
    }

    /**
     * Retorna uma lista de checkboxes contendo insumos que podem ser destinados à uma tarefa.
     * @return string
     */
    function getServiceInputsSelect() {
        $list = $this->insumo->getServiceInputs();
        $select = '';
        $i = 0;
        foreach ($list as $item) {
            $select .= '<div class="form-group">
                            <input type="checkbox" id="s_input_' . $i . '" name="insumo[]" value="' . $item['id'] . '">
                            <label for="s_input_' . $i . '">' . $item['nome'] . '</label>
                        </div>';
            $i++;
        }
        return $select;
    }

    /**
     * Retorna os dados recebidos de um formulário via POST
     * @return array
     */
    private function getPostAllocation() {
        $data['insumo_id'] = $this->input->post('insumo');
//        Modifique a linha abaixo de acordo com a organização de tarefas
        $data['tarefa_id'] = $this->input->post('tarefa_id');
        return $data;
    }

    /**
     * Validação de formulário de associação entre serviço e insumo
     */
    private function validateAllocation() {
        $this->form_validation->set_rules('insumo[]', 'Insumo', 'required');
//        Modifique a linha abaixo de acordo com a organização de tarefas
        $this->form_validation->set_rules('tarefa_id', 'Tarefa', 'required|numeric');
    }

    /**
     * Insere uma associação entre serviço e insumo
     * @return string
     */
    function newAllocation() {
        if (sizeof($_POST) > 0) {
            $this->validateAllocation();
            if ($this->form_validation->run()) {
                $data = $this->getPostAllocation();
                foreach ($data['insumo_id'] as $item) {
                    $this->addServiceInput($item, $data['tarefa_id']);
                }
//                modifique esta linha para definir redirecionamento
                redirect('/');
            }
            else {
                return validation_errors();
            }
        }
    }

    /**
     * Realiza loop de inserção de várias associações entre insumo e serviço
     * @param int $serviceInput
     * @param $task
     */
    private function addServiceInput($serviceInput, $task) {
        if (!is_array($serviceInput)) {
            $serviceInput = array($serviceInput);
        }

        foreach ($serviceInput as $item) {
            $this->insumo->newAllocation($item, $task);
        }
    }

    /**
     * Retorna uma lista, em formato de tabela, de associações entre serviço e insumo
     * @param $task
     * @return string
     */
    function listInputsByService($task) {
        $list = $this->insumo->getAllocations($task);
        if (sizeof($list) > 0) {
            $labels = array('Nome', '');
            $i = 0;
            foreach ($list as $item) {
                $data[$i]['nome'] = $item['nome'];
                $data[$i]['id'] = $item['id'];
            }
            $data = Table::buildDataArray($data, $labels);
            $table = new Table($data);
            return $table->getHTML();
        }
        return '<div class="container">Nenhum insumo cadastrado.</div>';
    }

}