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
include_once("engine/bo/SkillEndorsmentBo.php");

$userId = SessionUtils::getUserId($_SESSION);

if (!$userId) {
	echo json_encode(array("ko" => "ko", "message" => "must_be_connected"));
	exit();
}

$skillBo = SkillBo::newInstance($connection, $config);
$skillUserBo = SkillUserBo::newInstance($connection, $config);
$skillEndorsmentBo = SkillEndorsmentBo::newInstance($connection, $config);

$skillUser = $skillUserBo->getById($_REQUEST["sus_id"]);

if (!$skillUser) {
	echo json_encode(array("ko" => "ko", "message" => "no_skill_user"));
	exit();
}

if ($skillUser["sus_user_id"] != $userId) {
	echo json_encode(array("ko" => "ko", "message" => "not_user_skill"));
	exit();
}

// Then remove all endorsments
$skillEndorsments = $skillEndorsmentBo->getByFilters(array("sen_skill_user_id" => $skillUser[$skillUserBo->ID_FIELD]));
foreach($skillEndorsments as $skillEndorsment) {
	$skillEndorsmentBo->delete($skillEndorsment);
}

$skillUserBo->delete($skillUser);

$data = array();
$data["ok"] = "ok";

echo json_encode($data, JSON_NUMERIC_CHECK);
?>