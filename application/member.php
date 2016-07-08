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
include_once("header.php");

require_once("engine/bo/GaletteBo.php");
require_once("engine/bo/FixationBo.php");

$galetteBo = GaletteBo::newInstance($connection, $config["galette"]["db"]);
$fixationBo = FixationBo::newInstance($connection, $config["galette"]["db"]);

$member = $galetteBo->getMemberById(intval($_REQUEST["id"]));
$fixations = array();

if ($member) {
	$filters = array();
	$filters["with_fixation_members"] = true;
	$filters["fme_member_id"] = $member["id_adh"];

	$fixations = $fixationBo->getFixations($filters);
}

?>

<div class="container theme-showcase" role="main">
	<ol class="breadcrumb">
		<li><a href="index.php"><?php echo lang("breadcrumb_index"); ?></a></li>
<!--
		TODO add members page
		<li><a href="groups.php"><?php echo lang("breadcrumb_groups"); ?></a></li>
 -->
		<li class="active"><?php echo GaletteBo::showPseudo($member); ?></li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Identité&nbsp;
		</div>
		<div class="panel-body">

Pseudo : <?php echo GaletteBo::showPseudo($member); ?><br />

<?php if ($isConnected) {?>
Identité : <?php echo GaletteBo::showFullname($member); ?><br />
Mail : <?php echo $member["email_adh"]; ?><br />
<?php }?>

<?php if (count($fixations)) {?>

		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			Pouvoir&nbsp;
		</div>
		<div class="panel-body">

<?php
foreach($fixations as $fixation) {
	if ($fixation["fix_is_current"] != 1) continue;

	if (!isset($encours)) {
		echo "<h3>En cours</h3>";
		$encours = true;
	}

	echo $fixation["the_label"];
	if ($fixation["fix_until_date"]) {
		echo " Jusqu'au ";
		echo $fixation["fix_until_date"];
	}
	echo " avec une confiance de ";
	echo $fixation["fme_power"];
	echo "<br/>";
}
?>

<?php
foreach($fixations as $fixation) {
	if ($fixation["fix_is_current"] != 0) continue;

	if (!isset($passes)) {
		echo "<h3>Passés</h3>";
		$passes = true;
	}

	echo $fixation["the_label"];
	if ($fixation["fix_until_date"]) {
		echo " Jusqu'au ";
		echo $fixation["fix_until_date"];
	}
	echo " avec une confiance de ";
	echo $fixation["fme_power"];
	echo "<br/>";
}
?>

<?php }?>
		</div>
	</div>

</div>

<div class="lastDiv"></div>

<?php include("footer.php");?>

</body>
</html>