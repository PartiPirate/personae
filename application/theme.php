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
include_once("header.php");

require_once("engine/bo/CandidateBo.php");
require_once("engine/bo/DelegationBo.php");
require_once("engine/bo/GaletteBo.php");
require_once("engine/bo/GroupBo.php");

$groupFilters = array();

// If there is no theme, this is a new theme
if (!$theme) {
	$theme = array();
	$theme["the_id"] = 0;

	$theme["the_label"] = "Nouveau thème";

	// Fixation rules
	$theme["the_min_members"] = 1;
	$theme["the_max_members"] = 1;
	$theme["the_next_fixation_date"] = "";
	$theme["the_voting_power"] = 1;
	$theme["the_secret_until_fixation"] = 1;
	$theme["the_voting_method"] = "demliq";

	// Eligibles persons source
	$theme["the_eligible_group_type"] = "galette_adherents";
	$theme["the_eligible_group_id"] = 0;

	// Voters persons source
	$theme["the_voting_group_type"] = "galette_adherents";
	$theme["the_voting_group_id"] = 0;

	$theme["the_discourse_group_labels"] = "[]";
	$theme["the_discord_export"] = 0;
	$theme["the_delegate_only"] = 0;
	$theme["the_delegation_closed"] = 0;
}

$isAdmin = false;
$showAdmin = false;
if ($isConnected) {
	if ($theme["the_id"]) {
		$isAdmin = $themeBo->isMemberAdmin($theme, $sessionUserId);
		$showAdmin = isset($_REQUEST["admin"]);

		if ($isAdmin) {
			$admins = $themeBo->getMemberAdmins($theme);
		}
	}
	else {
		$isAdmin = true;
		$showAdmin = true;
		$admins = array();
	}
}

$candidateBo = CandidateBo::newInstance($connection);
$delegationBo = DelegationBo::newInstance($connection);

$delegations = array();
if ($isConnected) {
$delegations = $delegationBo->getDelegations(array("del_theme_id" => $theme["the_id"],
													"del_theme_type" => "dlp_themes",
													"del_member_from" => $sessionUserId));
}

$groupBo = GroupBo::newInstance($connection, $config["galette"]["db"]);
$galetteBo = GaletteBo::newInstance($connection, $config["galette"]["db"]);

$isVoting = false;
$isElegible = false;
if ($isConnected) {
	$isVoting = count($groupBo->getMyGroups(array("the_id" => $_REQUEST["id"], "userId" => $sessionUserId, "state" => "voting"))) > 0;
	$isElegible = count($groupBo->getMyGroups(array("the_id" => $_REQUEST["id"], "userId" => $sessionUserId, "state" => "eligible"))) > 0;
}

$eligibles = array();
$eligiblesGroups = $groupBo->getMyGroups(array("the_id" => $_REQUEST["id"], "state" => "eligible"));
foreach($eligiblesGroups as $eligiblesGroup) {
	foreach($eligiblesGroup["gro_themes"] as $eligiblesTheme) {
		$eligibles = $eligiblesTheme["members"];
	}
}

$votings = array();
$votingsGroups = $groupBo->getMyGroups(array("the_id" => $_REQUEST["id"], "state" => "voting"));
foreach($votingsGroups as $votingsGroup) {
	foreach($votingsGroup["gro_themes"] as $votingsTheme) {
		$votings = $votingsTheme["members"];
	}
}

$instance = $theme;
$instance["eligibles"] = $eligibles;
$instance["votings"] = $votings;

$powers = $delegationBo->computeFixation($instance);

// Candidate part

if ($isElegible) {
	$candidate = array();
	$candidate["can_member_id"] = $sessionUserId;
	$candidate["can_theme_id"] = $theme["the_id"];

	$candidates = $candidateBo->getCandidates($candidate);
	if (count($candidates)) {
		$candidate = $candidates[0];
	}
	else {
		$candidate["can_status"] = "";
		$candidate["can_text"] = "";
	}
}

// END Candidate part

// Retrieve information for the admin part (but not only)
$themes = $themeBo->getThemes();
$groups = $groupBo->getGroups();
$galetteGroups = $galetteBo->getGroups();

$fixation = null;
foreach($groups as $groupId => $lgroup) {
	foreach($lgroup["gro_themes"] as $themeId => $ltheme) {
		if ($themeId == $theme["the_id"]) {
			$fixation = $ltheme["fixation"];
		}
	}
}

?>

<div class="container theme-showcase" role="main">
	<ol class="breadcrumb">
		<li><a href="index.php"><?php echo lang("breadcrumb_index"); ?></a></li>
		<li><a href="groups.php"><?php echo lang("breadcrumb_groups"); ?></a></li>

<?php if (!$showAdmin) {?>
		<li class="active"><?php echo $theme["the_label"]; ?></li>
<?php } else {?>
		<li><a href="theme.php?id=<?php echo $theme["the_id"];?>" id="theme_link"><?php echo $theme["the_label"]; ?></a></li>
<?php }?>

<?php if ($isAdmin) {?>
<?php if (!$showAdmin) {?>
		<li><a href="theme.php?id=<?php echo $theme["the_id"];?>&admin=" id="theme_admin_link"><?php echo lang("breadcrumb_theme_administration"); ?></a></li>
<?php } else {?>
		<li class="active"><?php echo lang("breadcrumb_theme_administration"); ?></li>
<?php }?>
<?php }?>

	</ol>


<!-- User part -->
<?php include("theme_user.php"); ?>

<!-- Administration part -->
<?php include("theme_admin.php"); ?>

<?php include("connect_button.php"); ?>

</div>

<div class="container otbHidden">
	<?php echo addAlertDialog("success_theme_candidateAlert", lang("success_theme_candidate"), "success"); ?>
	<?php echo addAlertDialog("success_theme_votingAlert", lang("success_theme_voting"), "success"); ?>
	<?php echo addAlertDialog("success_theme_themeAlert", lang("success_theme_theme"), "success"); ?>

	<?php echo addAlertDialog("error_voting_cyclingAlert", lang("error_voting_cycling"), "danger"); ?>
	<?php echo addAlertDialog("error_max_delegationsAlert", lang("error_max_delegations"), "danger"); ?>
</div>

<div class="lastDiv"></div>

<script>
	themePower = <?php echo $theme["the_voting_power"]; ?>;
</script>
<?php include("footer.php");?>

</body>
</html>