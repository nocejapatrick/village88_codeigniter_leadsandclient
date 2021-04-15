<?php

class Lead extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_user_leads_where_date($from=null,$to=null){
        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        $this->db->select("CONCAT(clients.first_name,' ',clients.last_name) as customer_name, COUNT(*) as number_of_leads");
        $this->db->from('leads');
        $this->db->join('sites','sites.site_id = leads.site_id');
        $this->db->join('clients','clients.client_id = sites.client_id');

        // If has from date and to date but by default this query will generate all leads of all time
        if($from != null && $to != null){
            $this->db->where(array(
                    "leads.registered_datetime >="=>$from,
                    "leads.registered_datetime <="=>$to
                )
            );
        }
        $this->db->group_by(array("clients.first_name","clients.last_name"));
        $this->db->order_by("clients.client_id",'ASC');
        return $this->db->get()->result();
    }
}