<?php /*
	Copyright 2015 Cédric Levieux, Parti Pirate

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

// Can only be call from CLI
if (php_sapi_name() != "cli") exit();

$path = "../";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

include_once("config/database.php");
require_once("engine/bo/CandidateBo.php");
require_once("engine/bo/DelegationBo.php");
require_once("engine/bo/GroupBo.php");
require_once("engine/bo/ThemeBo.php");
require_once("engine/bo/FixationBo.php");

$connection = openConnection();

$groupBo = GroupBo::newInstance($connection, $config["galette"]["db"]);
$themeBo = ThemeBo::newInstance($connection, $config["galette"]["db"]);
$delegationBo = DelegationBo::newInstance($connection);
$fixationBo = FixationBo::newInstance($connection);

$yesterday = new DateTime();
$yesterday = $yesterday->sub(new DateInterval("P1D"));

// Get yesterday's (by default) fixation themes
$filters = array("the_next_fixation_date" => $yesterday->format("Y-m-d"));
$filters["with_fixation_information"] = true;

$themes = $themeBo->getThemes($filters);

// Foreach

foreach($themes as $theme) {
	echo "Fix " . $theme["the_id"] . "\n";
// Get the fixation method

	if ($theme["the_id"] != 25) continue;

	$method = $theme["the_voting_method"];

	$fixation = array();
	$fixation["fix_until_date"] = $theme["the_next_fixed_until_date"];
	$fixation["fix_theme_id"] = $theme["the_id"];
	$fixation["fix_theme_type"] = "dlp_themes";

// 	echo "<br/>---------------<br/>\n";
// 	print_r($theme);
// 	echo "<br/>---------------<br/>\n";

	if ($method == "sort") {
		$eligiblesGroups = $groupBo->getMyGroups(array("the_id" => $theme["the_id"], "state" => "eligible"));
		foreach($eligiblesGroups as $eligiblesGroup) {
			foreach($eligiblesGroup["gro_themes"] as $eligiblesTheme) {
				$eligibles = $eligiblesTheme["members"];
			}
		}

		$candidates = array();

		foreach($eligibles as $eligible) {
			if ($eligible["can_status"] == "candidate") {
				$candidates[] = $eligible;
			}
		}

		// Uncomment
// 		if (count($candidates) < $theme["the_min_members"]) {
// 			continue;
// 		}

		$leftRooms = $theme["the_min_members"];

		$fixationBo->save($fixation);

		while($leftRooms > 0 && count($candidates) > 0) {
			$sort = mt_rand(0, count($candidates) - 1);

			$member = $candidates[$sort];
			unset($candidates[$sort]);

			$fixationMember = array();
			$fixationMember["fme_fixation_id"] = $fixation["fix_id"];
			$fixationMember["fme_member_id"] = $member["id_adh"];
			$fixationMember["fme_power"] = 1;

			echo $member["pseudo_adh"] . " gains power with 1\n";
			//print_r($fixationMember);

			$fixationBo->addFixationMember($fixationMember);

			$leftRooms--;
		}
	}
	else  if ($method == "demliq") {

		$eligiblesGroups = $groupBo->getMyGroups(array("the_id" => $theme["the_id"], "state" => "eligible"));
		foreach($eligiblesGroups as $eligiblesGroup) {
			foreach($eligiblesGroup["gro_themes"] as $eligiblesTheme) {
				$eligibles = $eligiblesTheme["members"];
			}
		}

		$votingsGroups = $groupBo->getMyGroups(array("the_id" => $theme["the_id"], "state" => "voting"));
		foreach($votingsGroups as $votingsGroup) {
			foreach($votingsGroup["gro_themes"] as $votingsTheme) {
				$votings = $votingsTheme["members"];
			}
		}

//		print_r($eligibles);

// 		echo "<br/>----- Start members -------<br/>\n";
// 		print_r($eligibles);
// 		exit();

		$theme["eligibles"] = $eligibles;
		$theme["votings"] = $votings;

// 		echo "Eligibles : " . count($theme["eligibles"]) . "\n";
// 		echo "Votings : " . count($theme["votings"]) . "\n";

		$powers = $delegationBo->computeFixation($theme);

//		print_r($powers);

		// Clean powerless members
		foreach($powers as $memberId => $member) {
			if ($member["power"] <= 0) unset($powers[$memberId]);
		}

//		if (count($powers) < $theme["the_max_members"]) {
//			continue;
//		}

		$leftRooms = $theme["the_max_members"];

		$fixationBo->save($fixation);

		foreach($powers as $memberId => $member) {
			if ($leftRooms == 0) break;

			$fixationMember = array();
			$fixationMember["fme_fixation_id"] = $fixation["fix_id"];
			$fixationMember["fme_member_id"] = $memberId;
			$fixationMember["fme_power"] = $member["power"];

			echo $member["pseudo_adh"] . " gains power with " . $member["power"] . "\n";
			//print_r($fixationMember);

			$fixationBo->addFixationMember($fixationMember);

			$leftRooms--;
		}
	}


// Next fixed until date become, by default, the next fixation date
	$themeToSave = array("the_id" => $theme["the_id"]);
	$themeToSave["the_next_fixation_date"] = $theme["the_next_fixed_until_date"];
	$themeToSave["the_next_fixed_until_date"] = null;
	$themeToSave["the_current_fixation_id"] = $fixation["fix_id"];

	$themeBo->save($themeToSave);

// Create fixation event

}

?>
