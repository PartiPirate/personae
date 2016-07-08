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
include_once("config/database.php");
require_once("engine/utils/FormUtils.php");
require_once("engine/bo/FixationBo.php");
require_once("engine/bo/ThemeBo.php");
require_once("engine/bo/GaletteBo.php");

// We sanitize the request fields
xssCleanArray($_REQUEST);

session_start();

if (isset($_SESSION["memberId"])) {
	$sessionUserId = $_SESSION["memberId"];
}
else {
	echo json_encode(array("error" => "error_not_connected"));
}

$connection = openConnection();

$themeBo = ThemeBo::newInstance($connection, $config["galette"]["db"]);
$fixationBo = FixationBo::newInstance($connection, $config["galette"]["db"]);

$theme = array();
$theme["the_id"] = $_REQUEST["the_id"];

if (!$themeBo->isMemberAdmin($theme, $sessionUserId)) {
	echo json_encode(array("error" => "theme_not_admin"));
	exit();
}

$theme = $themeBo->getTheme($theme["the_id"]);

$fixation = array();
$fixation["fix_until_date"] = $theme["the_next_fixation_date"];
$fixation["fix_theme_id"] = $theme["the_id"];
$fixation["fix_theme_type"] = "dlp_themes";

$fixationBo->save($fixation);

$themeToSave = array("the_id" => $theme["the_id"]);
$themeToSave["the_current_fixation_id"] = $fixation["fix_id"];

$themeBo->save($themeToSave);

// TODO Update theme admin event

echo json_encode(array("ok" => "ok", "fixation" => $fixation));
?>