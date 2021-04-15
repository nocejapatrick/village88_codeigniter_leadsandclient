<?php 
class Reports extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Lead');
    }

    public function index(){
        // Generate the reports of leads
        $leads = $this->Lead->get_user_leads_where_date($this->input->get('from'),$this->input->get('to'));
        $this->load->view("report",array('leads'=>$leads,'from'=>$this->input->get('from'),'to'=>$this->input->get('to')));
    }
}