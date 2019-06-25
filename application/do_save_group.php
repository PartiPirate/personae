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
require_once("engine/bo/GroupBo.php");
require_once("engine/bo/GaletteBo.php");
require_once("engine/bo/ServerAdminBo.php");

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

$groupBo = GroupBo::newInstance($connection, $config["galette"]["db"]);
$galetteBo = GaletteBo::newInstance($connection, $config["galette"]["db"]);

$group = array();
$group["gro_id"] = $_REQUEST["gro_id"];

$serverAdminBo = ServerAdminBo::newInstance($connection, $config);
$isAdmin = count($serverAdminBo->getServerAdmins(array("sad_member_id" => $sessionUserId))) > 0;
$isAdmin = $isAdmin || $groupBo->isMemberAdmin($group, $sessionUserId);

if (!$isAdmin) {
	echo json_encode(array("error" => "group_not_admin"));
	exit();
}

$group["gro_label"] = $_REQUEST["gro_label"];
$group["gro_contact_type"] = isset($_REQUEST["gro_contact_type"]) ? $_REQUEST["gro_contact_type"] : null;
$group["gro_contact"] = isset($_REQUEST["gro_contact"]) ? $_REQUEST["gro_contact"] : null;

$groupBo->save($group);

// TODO Update theme admin event

echo json_encode(array("ok" => "ok", "group" => $group));
?>