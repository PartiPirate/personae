<?php /*
	Copyright 2015 Cédric Levieux, Parti Pirate

	This file is part of Fabrilia.

    Fabrilia is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Fabrilia is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Fabrilia.  If age, see <http://www.gnu.org/licenses/>.
*/

if (!isset($api)) exit();

$connection = openConnection();

include_once("engine/bo/SkillBo.php");
include_once("engine/bo/SkillUserBo.php");

$userId = SessionUtils::getUserId($_SESSION);

if (!$userId) {
	echo json_encode(array("ko" => "ko", "message" => "must_be_connected"));
}

$skillBo = SkillBo::newInstance($connection, $config);
$skillUserBo = SkillUserBo::newInstance($connection, $config);

$skillUser = array();
$skillUser["sus_user_id"] = $userId;
$skillUser["sus_skill_id"] = $_REQUEST["sus_skill_id"];
$skillUser["sus_level"] = $_REQUEST["sus_level"];

// If the id of the skill is 0, it's a new one
if ($skillUser["sus_skill_id"] == "0") {
	$skill = array();
	$skill["ski_label"] = $_REQUEST["sus_label"];
	
	$skillBo->save($skill);
	
	$skillUser["sus_skill_id"] = $skill[$skillBo->ID_FIELD];
}

$skillUserBo->save($skillUser);

$data = array();
$data["ok"] = "ok";

echo json_encode($data, JSON_NUMERIC_CHECK);
?>