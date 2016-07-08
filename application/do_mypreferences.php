<?php /*
	Copyright 2014 Cédric Levieux, Jérémy Collot, ArmagNet

	This file is part of OpenTweetBar.

    OpenTweetBar is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    OpenTweetBar is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with OpenTweetBar.  If not, see <http://www.gnu.org/licenses/>.
*/
session_start();
include_once("config/database.php");
require_once("engine/utils/SessionUtils.php");
require_once("engine/bo/GaletteBo.php");
require_once("engine/authenticators/GaletteAuthenticator.php");

$user = SessionUtils::getUser($_SESSION);
$password = $_REQUEST["password"];
$confirmation = $_REQUEST["confirmation"];
$old = $_REQUEST["old"];

$connection = openConnection();
$galetteBo = GaletteBo::newInstance($connection, $config["galette"]["db"]);
$galetteAuthenticator = GaletteAuthenticator::newInstance($connection, $config["galette"]["db"]);

$user = $galetteBo->getMemberById(SessionUtils::getUserId($_SESSION));

if (!$user) {
	echo json_encode(array("ko" => "ko", "message" => "error_cant_change_password"));
	exit();
}

if ($password != $confirmation) {
	echo json_encode(array("ko" => "ko", "message" => "error_cant_change_password"));
	exit();
}

if (!password_verify($old, $user["mdp_adh"])) {
	echo json_encode(array("ko" => "ko", "message" => "error_cant_change_password"));
	exit();
}

$data = array();

if ($password) {
	$galetteAuthenticator->forgotten($user["email_adh"], $password);
}

$data["ok"] = "ok";

echo json_encode($data);
?>