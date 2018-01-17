<?php
class Results_model extends CI_Model {
	public $player1_name = '';
	public $player2_name = '';
	public $winner = '';
	public $final_position = '';
	public $played;
	
	private $tablename;
	
	public function __construct() {
		parent::__construct();
		$this->tablename = 'game_results';
	}
	
	private function fillFromPost() {
		foreach($_POST as $key=>$value) {
			if (isset($this->$key)) {
				$this->$key = strip_tags($this->input->post($key, true));
			}
		}
	}
	
	public function insertion()	{
		$required_fields = [
			'player1_name',
			'player2_name',
			'winner',
			'final_position'
		];
		foreach($required_fields as $fieldname) {
			$val = strip_tags($this->input->post($fieldname, true));
			if ($val == '' || $val === NULL) {
				return false;
			}
		}
		$this->fillFromPost();
		$this->played = date("Y-m-d H:i:s");

		$this->db->insert($this->tablename, $this);
		return true;
	}
	
	public function getLastEntries() {
		$this->db->order_by('played DESC');
		$query = $this->db->get($this->tablename, 5);
		return $query->result();
	}
	
	public function getRowById($id) {
		$query = $this->db->get_where($this->tablename, array('id' => $id), 1, 0);
		return $query->result();
	}
	
	public static function wonText() {
		switch ($this->winner) {
			case 1:
				return $this->player1_name." won!";
			case 1:
				return $this->player2_name." won!";
			default: 
				return 'Tie!';
		}
	}
}