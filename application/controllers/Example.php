<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require (APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class Example extends REST_Controller  {

	function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    public function index_get()
    {
        // $this->load->helper('url');

        // $this->load->view('example');

    	$this->response(array('status' => 'success'), 201);
    }

    public function index_post()
    {
        $dateNow = date('Y-m-d H:i:s');
        $store_id = $this->post('Storeid');
        $region = $this->post('region');
        $subregion = $this->post('subregion');
        $policeNumber = $this->post('policeNumber');
        $NoPol = $this->post('NoPol');
        $listrating = json_decode($this->post('listrating'));
        $listtext = json_decode($this->post('listtext'));

    	try {
            $data = array(
                'store_id' => $store_id,
                'region' => $region,
                'subregion' => $subregion,
                'policeNumber' => $policeNumber,
                'NoPol' => $NoPol,
                'created_at' => $dateNow,
            );

            $this->db->insert('store_review', $data);
            $last_id = $this->db->insert_id();

            foreach ($listrating as $row) {
                $data = [
                    'id_store_review' => $last_id,
                    'id_list' => $row->id,
                    'description' => $row->description,
                    'data_value' => $row->value,
                    'type_detail' => '0',
                    'created_at' => $dateNow,
                ];
                $this->db->insert('detail_store_review', $data);
            }

            foreach ($listtext as $row) {
                $data = [
                    'id_store_review' => $last_id,
                    'id_list' => $row->id,
                    'description' => $row->description,
                    'data_value' => $row->value,
                    'type_detail' => '1',
                    'created_at' => $dateNow,
                ];
                $this->db->insert('detail_store_review', $data);
            }


            $response = [
             'status'=> 1,
             'message' => 'suksess',
            ];
            $this->response($response, 200);
        } catch (Exception $e) {
            $this->response($e, 500);
        }
    }
}
