<?php

/**
 * Class Insumo
 * Tabela insumos
 */
class Insumo {

    /**
     * @var db: recebe instância de banco de dados
     */
    private $db;

    /**
     * Insumo constructor.
     */
    public function __construct()
    {
        $ci = &get_instance();
        $this->db = $ci->db;
    }

    /**
     * Insere um registro de insumo.
     * @param array $data
     * @return method
     */
    function newServiceInput($data) {
        return $this->db->insert('insumos', $data);
    }

    /**
     * Insere um registro de associação entre insumo e serviço.
     * @param int $input_id
     * @param $service_id
     * @return method
     */
    function newAllocation($input_id, $service_id) {
        return $this->db->insert('table_name', array('insumo_id' => $input_id, 'tarefa_id' => $service_id));
    }

    /**
     * Retorna lista de insumos associados a um serviço
     * @param $service_id
     */
    function getAllocations($service_id) {
//        lista de associações
    }

    /**
     * Retorna lista de registros da tabela de insumos
     */
    function getServiceInputs() {
        $res = $this->db->where('deleted', 0)->order_by('nome', 'ASC')->get('insumos');
    }

    /**
     * Atualiza insumo como deletado
     * @param int $id
     * @return method
     */
    function deleteServiceInput($id) {
        return $this->db->update('insumos', array('deleted' => 1), array('id' => $id));
    }

    /**
     * Atualiza dados de um insumo
     * @param int $id
     * @param array $data
     * @return method
     */
    function editServiceInput($id, $data) {
        return $this->db->update('insumos', $data, array('id' => $id));
    }

    /**
     * Retorna dados específicos de um insumo
     * @param int $id
     * @return method
     */
    function getServiceInputData($id) {
        $res = $this->db->where('id', $id)->get('insumos');
        return $res->result_array();
    }

}