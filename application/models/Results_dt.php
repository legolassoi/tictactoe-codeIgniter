<?php
class Results_dt implements DatatableModel{

	public function appendToSelectStr() {
		return array(
			'winner_str' => 'case c.winner'
			. ' when 1 then c.player1_name'
			. ' when 2 then c.player2_name'
			. ' when 0 then "Tie"'
			. ' end',
			'played_formatted' => "DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(c.played)), '%d.%m.%Y %H:%i')"
		);
	}

	public function fromTableStr() {
		return 'game_results c';
	}

	public function joinArray(){
		return NULL;
	}

	public function whereClauseArray(){
		return NULL;
	}
}