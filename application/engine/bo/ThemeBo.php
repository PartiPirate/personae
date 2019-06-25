<?php /*
	Copyright 2015-2018 Cédric Levieux, Parti Pirate

	This file is part of Personae.

    Personae is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Personae is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Personae.  If not, see <http://www.gnu.org/licenses/>.
*/

class ThemeBo {
	var $pdo = null;
	var $database = "";
	var $personaeDatabase = "";

	function __construct($pdo, $database) {
		if ($database) {
			$this->database = $database . ".";
		}
		$this->pdo = $pdo;
	}

	static function newInstance($pdo, $database) {
		return new ThemeBo($pdo, $database);
	}

	function create(&$theme) {
		$query = "	INSERT INTO dlp_themes () VALUES ()	";

		$statement = $this->pdo->prepare($query);
		//		echo showQuery($query, $args);

		try {
			$statement->execute();
			$theme["the_id"] = $this->pdo->lastInsertId();

			return true;
		}
		catch(Exception $e){
			echo 'Erreur de requète : ', $e->getMessage();
		}

		return false;
	}

	function update($theme) {
		$query = "	UPDATE dlp_themes SET ";

		$separator = "";
		foreach($theme as $field => $value) {
			$query .= $separator;
			$query .= $field . " = :". $field;
			$separator = ", ";
		}

		$query .= "	WHERE the_id = :the_id ";

//		echo showQuery($query, $theme);

		$statement = $this->pdo->prepare($query);
		$statement->execute($theme);
	}

	function save(&$theme) {
 		if (!isset($theme["the_id"]) || !$theme["the_id"]) {
			$this->create($theme);
 		}

		$this->update($theme);
	}

	function delete($theme) {
		$theme["the_deleted"] = 1;
		$this->save($theme);
	}

	function getTheme($id) {
		$id = intval($id);

		$filters = array("the_id" => $id);
		$themes = $this->getThemes($filters);

		if (count($themes)) {
			return $themes[0];
		}

		return null;
	}

	function getThemes($filters = null) {
		$args = array();

		$query = "	SELECT *
					FROM  dlp_themes";

		if ($filters && isset($filters["with_fixation_information"]) && $filters["with_fixation_information"]) {
			$query .= "	LEFT JOIN dlp_fixations ON fix_id = the_current_fixation_id";
		}

		if ($filters && isset($filters["with_group_information"]) && $filters["with_group_information"]) {
			$query .= "	LEFT JOIN ".$this->personaeDatabase."dlp_group_themes ON gth_theme_id = the_id";
			$query .= "	LEFT JOIN ".$this->personaeDatabase."dlp_groups ON gth_group_id = gro_id";
		}

		$query .= "	WHERE
						1 = 1 \n";

		if ($filters && isset($filters["the_id"])) {
			$args["the_id"] = $filters["the_id"];
			$query .= " AND the_id = :the_id \n";
		}

		if ($filters && isset($filters["the_has_discourse"]) && $filters["the_has_discourse"]) {
			$query .= " AND the_discourse_group_labels != '[]' \n";
		}

		if ($filters && isset($filters["the_next_fixation_date"])) {
			$args["the_next_fixation_date"] = $filters["the_next_fixation_date"];
			$query .= " AND the_next_fixation_date = :the_next_fixation_date \n";
		}

		// periodic theme search, force the type date to periodicity
		if ($filters && isset($filters["the_periodicity"])) {
			$args["the_periodicity"] = $filters["the_periodicity"];
			$args["the_type_date"] = "periodicity";
			$query .= " AND the_periodicity = :the_periodicity \n";
			$query .= " AND the_type_date = :the_type_date \n";
		}

		if (!isset($filters["with_deleted"])) {
			$query .= " AND the_deleted = 0 \n";
		}

//		$query .= "	ORDER BY gro_label, the_label ";

		$statement = $this->pdo->prepare($query);
//		echo showQuery($query, $args);

		$results = array();

		try {
			$statement->execute($args);
			$results = $statement->fetchAll();

			foreach($results as $index => $line) {
				foreach($line as $field => $value) {
					if (is_numeric($field)) {
						unset($results[$index][$field]);
					}
				}
			}
		}
		catch(Exception $e){
			echo 'Erreur de requète : ', $e->getMessage();
		}

		return $results;
	}

	// Admin part

	function addMemberAdmin($admin) {
		$query = "	INSERT INTO dlp_theme_admins
						(tad_theme_id, tad_member_id)
					VALUES
						(:tad_theme_id, :tad_member_id) \n";

		//		$query .= "	ORDER BY gro_label, the_label ";

		$statement = $this->pdo->prepare($query);
		//		echo showQuery($query, $args);

		$statement->execute($admin);
	}

	function removeMemberAdmin($admin) {
		$query = "	DELETE FROM  dlp_theme_admins
					WHERE
						tad_theme_id = :tad_theme_id
					AND tad_member_id = :tad_member_id \n";

		//		$query .= "	ORDER BY gro_label, the_label ";

		$statement = $this->pdo->prepare($query);
		//		echo showQuery($query, $args);

		$statement->execute($admin);
	}

	function isMemberAdmin($theme, $memberId) {
		$args = array();
		$args["tad_theme_id"] = $theme["the_id"];
		$args["tad_member_id"] = $memberId;

		$query = "	SELECT *
					FROM  dlp_theme_admins
					WHERE
						tad_theme_id = :tad_theme_id
					AND tad_member_id = :tad_member_id \n";

		//		$query .= "	ORDER BY gro_label, the_label ";

		$statement = $this->pdo->prepare($query);
		//		echo showQuery($query, $args);

		$statement->execute($args);
		$results = $statement->fetchAll();

		return count($results) > 0;
	}

	function getMemberAdmins($theme) {
		$args = array();
		$args["tad_theme_id"] = $theme["the_id"];

		$query = "	SELECT *
					FROM dlp_theme_admins
					JOIN ".$this->database."galette_adherents ON id_adh = tad_member_id
					WHERE
						tad_theme_id = :tad_theme_id \n";

		//		$query .= "	ORDER BY gro_label, the_label ";

		$statement = $this->pdo->prepare($query);
		//		echo showQuery($query, $args);

		$statement->execute($args);
		$results = $statement->fetchAll();

		return $results;
	}
}