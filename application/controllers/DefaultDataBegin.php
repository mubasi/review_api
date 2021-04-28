<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require (APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class DefaultDataBegin extends REST_Controller  {

	function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    public function index_get()
    {
        $storeId = 'STR-20-00001';
        $data = [
            'status'=> '1',
            'message'=> $this->db->query("select store_id,store_name,'TOTO GROUP' as GroupHeader,'Pusat nya Oli' RemarkHeader, 'bin123' as Pwd  from aroomitc_kasirin.stores where store_id = '".$storeId."'")->row(),
            'listrating'=> $this->db->query("select * from aroomitc_kasirin.master_review where Type='Star'")->result_array(),
            'listtext'=> $this->db->query("select * from aroomitc_kasirin.master_review where Type='Text'")->result(),
        ];
    	$this->response($data, 200);
    }
}
