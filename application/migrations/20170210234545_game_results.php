<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Game_results extends CI_Migration {
	
	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'player1_name' => array(
				'type' => 'TINYTEXT',
			),
			'player2_name' => array(
				'type' => 'TINYTEXT',
			),
			'winner' => array(
				'type' => 'INT',
				'constraint' => 3,
			),
			'final_position' => array(
				'type' => 'text',
			),
			'played' => array(
				'type' => 'DATETIME',
			),
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('game_results');
	}

	public function down()
	{
		$this->dbforge->drop_table('game_results');
	}
}