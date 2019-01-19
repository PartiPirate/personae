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
require_once("engine/bo/GaletteBo.php");
require_once("engine/authenticators/GaletteAuthenticator.php");

session_start();

// We sanitize the request fields
xssCleanArray($_REQUEST);

$connection = openConnection();
$galetteAuthenticator = GaletteAuthenticator::newInstance($connection, $config["galette"]["db"]);

$login = $_REQUEST["login"];
$password = $_REQUEST["password"];
//$ajax = isset("")

$member = $galetteAuthenticator->authenticate($login, $password);
if ($member) {
	$connectedMember = array();
	$connectedMember["pseudo_adh"] = GaletteBo::showIdentity($member);
	$connectedMember["id_adh"] = $member["id_adh"];

	$_SESSION["member"] = json_encode($connectedMember);
	$_SESSION["memberId"] = $member["id_adh"];
}

session_write_close();

$referer = $_SERVER["HTTP_REFERER"];

echo $referer;

exit();

if ($referer && $referer != "connect.php") {
	header("Location: $referer");
}
else {
	header("Location: index.php");
}

?>