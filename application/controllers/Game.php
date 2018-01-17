<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Controller {
	private $data = [];
	
	public function __construct() {
		parent::__construct();
		$this->layout();
		$this->load->helper('url');
		$this->data['csrf'] = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
	}
	/**
	 * @author Oleg Stanislavchuk <legolassoi@gmail.com
	 * 
	 */
	public function index()
	{
		$this->load->library('session');
		$this->session->set_userdata([
			'player1' => null,
			'player2' => null,
			'hard_mode' => false,
		]);
		$this->load->view('index', $this->data);
	}
	
	public function play()
	{
		$this->load->library('session');
		if ($this->input->post('player1', true) && $this->input->post('player2', true)) {
			$this->session->set_userdata([
				'player1' => preg_replace("/[^0-9a-zA-Z ]/", "", $this->input->post('player1', true)),
				'player2' => preg_replace("/[^0-9a-zA-Z ]/", "", $this->input->post('player2', true)),
				'hard_mode' => $this->input->post('hard_mode', true),
			]);
			$_POST = [];
			redirect('/game/play');
		}
		$this->data['player1'] = $this->session->userdata('player1');
		$this->data['player2'] = $this->session->userdata('player2');
		$this->data['hard_mode'] = $this->session->userdata('hard_mode');
		if (!$this->data['player1'] || !$this->data['player2']) {
			redirect('/');
		}
		$model = $this->load->model('Results_model');
		$this->data['latest_results'] = $this->Results_model->getLastEntries();
		$this->load->view('play', $this->data);
	}
	
	public function store() {
		
		$model = $this->load->model('Results_model');
		if (!$this->Results_model->insertion()) {
			die('Something went wrong on saving result.');
		}
		$model = $this->load->model('Results_model');
		$latest_results = $this->Results_model->getLastEntries();
		$return = $this->load->view('partials/_results', [
			'latest_results' => $latest_results
		], true);
		echo $return;
		
	}
	
	public function view($id = 0) {
		$model = $this->load->model('Results_model');
		$this->data['result'] = $this->Results_model->getRowById($id);
		$this->data['latest_results'] = $this->Results_model->getLastEntries();
		if (!$this->data['result']) {
			show_404();
		}
		$this->data['result'] = $this->data['result'][0];
		$this->load->view('view', $this->data);
	}
	
	public function datatable() {
        $this->load->library('Datatable', array('model' => 'Results_dt', 'rowIdCol' => 'c.id'));

        $json = $this->datatable->datatableJson();

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json') -> set_output(json_encode($json));
	}
	
	public function results() {
		$this->load->view('results', $this->data);
	}
	
	private function layout() {
		$this->data['header']   = $this->load->view('layout/header', [], true);
	}
	
	protected function sendResponse($data = array()) {
        header('Content-type: application/json');
        echo json_encode($data);
    }
}
