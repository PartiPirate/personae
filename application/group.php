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

require_once("engine/bo/GroupBo.php");
require_once("engine/bo/GaletteBo.php");

$groupFilters = array();

$groupBo = GroupBo::newInstance($connection, $config["galette"]["db"]);
$group = $groupBo->getGroup($_GET["id"]);

$isAdmin = false;
$showAdmin = false;
if ($isConnected) {
	if ($group["gro_id"]) {
		$isAdmin = $groupBo->isMemberAdmin($group, $sessionUserId);
		$showAdmin = isset($_REQUEST["admin"]);

		if ($isAdmin) {
			$admins = $groupBo->getMemberAdmins($group);
		}
	}
	else {
		$isAdmin = true;
		$showAdmin = true;
		$admins = array();
	}
}

$myVotingGroups = array();
$myEligibleGroups = array();
if ($sessionUserId) {
	$myVotingGroups = $groupBo->getMyGroups(array("userId" => $sessionUserId, "state" => "voting"));
	$myEligibleGroups = $groupBo->getMyGroups(array("userId" => $sessionUserId, "state" => "eligible"));
}

function isInMyGroup($theme, $mygroups) {
	foreach($mygroups as $group) {
		foreach($group["gro_themes"] as $myTheme) {
			if ($myTheme["the_id"] == $theme["the_id"]) return true;
		}
	}

	return false;
}

?>

<div class="container theme-showcase" role="main">
	<ol class="breadcrumb">
		<li><a href="index.php"><?php echo lang("breadcrumb_index"); ?></a></li>
		<li><a href="groups.php"><?php echo lang("breadcrumb_groups"); ?></a></li>

<?php 	if (false) {?>
		<li><a href="groups.php?limit=mine"><?php echo lang("breadcrumb_my_groups"); ?></a></li>
<?php 	}?>

<?php if (!$showAdmin) {?>
		<li class="active"><?php echo $group["gro_label"]; ?></li>
<?php } else {?>
		<li><a href="group.php?id=<?php echo $group["gro_id"];?>" id="group_link"><?php echo $group["gro_label"]; ?></a></li>
<?php }?>

<?php if ($isAdmin) {?>
<?php if (!$showAdmin) {?>
		<li><a href="group.php?id=<?php echo $group["gro_id"];?>&admin=" id="group_admin_link"><?php echo lang("breadcrumb_group_administration"); ?></a></li>
<?php } else {?>
		<li class="active"><?php echo lang("breadcrumb_group_administration"); ?></li>
<?php }?>
<?php }?>

	</ol>

<?php
foreach($group["gro_themes"] as $themeId => $theme) {
	$class = "";
	$class .= isInMyGroup($theme, $myVotingGroups) ? "voting" : "no-voting";
	$class .= isInMyGroup($theme, $myEligibleGroups) ? " eligible" : " no-eligible";
?>

	<div class="panel panel-default theme <?php echo $class ?>">
		<div class="panel-heading">

		<?php if ($showAdmin) {?>
			<div class="pull-right" >
				<form id="exclude-<?php echo $themeId; ?>" action="do_exclude_theme_group.php" method="post">
					<input type="hidden" name="gth_group_id" value="<?php echo $group["gro_id"]; ?>" />
					<input type="hidden" name="gth_theme_id" value="<?php echo $themeId; ?>" />
					<button class="btn btn-danger btn-xs excludeButton">Exclure du groupe <span class="glyphicon glyphicon-remove"></span></button>
				</form>
			</div>
		<?php } ?>

			<a href="theme.php?id=<?php echo $themeId; ?>"><?php echo $theme["the_label"]; ?></a>&nbsp;
		</div>
		<div class="panel-body">


	<?php if ($showAdmin) {?>
		<form id="savePower-<?php echo $themeId; ?>" action="do_save_power_theme.php" method="post">
			<div class="saved" style="display: none;">Sauv&eacute;</div>
			<input type="hidden" name="gth_group_id" value="<?php echo $group["gro_id"]; ?>" />
			<input type="hidden" name="gth_theme_id" value="<?php echo $themeId; ?>" />
			Pouvoir de vote dans le groupe :
			<input type="number" name="gth_power" value="<?php echo $theme["gth_power"]; ?>" />
		</form>
	<?php }?>

	<?php if (!$showAdmin) {?>

	<?php
	if ($theme["the_delegate_only"] != "1") {
		foreach($theme["fixation"]["members"] as $memberId => $member) {
	?>
		<a href="member.php?id=<?php echo $memberId; ?>"><?php echo GaletteBo::showIdentity($member); ?></a><br/>
	<?php
		}
	}
	else {
		echo "Seulement de la délégation";
	}
	?>
<!--
		<br/>
		<button data-theme="<?php echo $themeId; ?>" class="delegate-button">Deleguer</button>
		<button data-theme="<?php echo $themeId; ?>" class="candidate-button">Candidater</button>
		<br/>
 -->
			<?php if ($theme["fixation"]["fix_until_date"]) { ?>
			<br/><span class="glyphicon glyphicon-time"></span> <span class="date"><?php echo $theme["fixation"]["fix_until_date"]; ?></span>
			<?php }?>

		<?php }?>

		</div>
	</div>
<?php
}
?>

<?php if ($isAdmin && $showAdmin) {?>
	<div id="admins">
		<div class="panel panel-primary theme <?php echo $class ?>">
			<div class="panel-heading">
				Administrateurs du groupe&nbsp;
			</div>
			<div class="panel-body">

				<form id="addAdminForm" action="do_set_group_admin.php" method="post" class="form-horizontal">
					<fieldset>
						<input type="hidden" name="action" value="add_admin" />
						<input type="hidden" name="gad_group_id" value="<?php echo $group["gro_id"]; ?>" />

						<label class="col-md-4 control-label" for="gad_member_mail">Utilisateur à ajouter en tant qu'administrateur : </label>
						<div class="col-md-6">
							<div class="input-group">
								<input type="text" name="gad_member_mail" placeholder="email ou pseudo"
									class="form-control"
								/><span class="input-group-btn"><button
									data-success-function="addGroupAdminFromSearchForm"
									data-success-label="Ajouter"
									class="btn btn-default search-user"><span class="fa fa-search"></span></button></span>
							</div>
						</div>
						<div class="col-md-2">
							<button id="addAdminButton" class="btn btn-primary">Ajouter <span class="glyphicon glyphicon-plus"></span></button>
						</div>

					</fieldset>

				</form>

				<table>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div style="text-align: center;">
		<button data-group-id="<?php echo $group["gro_id"]; ?>" class="btn btn-primary addThemeButton">Ajouter un th&egrave;me <span class="glyphicon glyphicon-plus"></span></button>
	</div>
<?php }?>

<?php include("connect_button.php"); ?>

</div>


<div class="container otbHidden">
	<?php echo addAlertDialog("success_group_groupAlert", lang("success_group_group"), "success"); ?>
</div>

<div class="lastDiv"></div>

<templates>
	<table>
		<tr data-template-id="template-group-admin" class="template">
			<td>${gad_member_identity}</td>
			<td>&nbsp;<a href="#" class="removeAdminLink text-danger" data-group-id="${gad_group_id}" data-member-id="${gad_member_id}"><span class="glyphicon glyphicon-remove"></span></td>
		</tr>
	</table>
</templates>

<script>
var groupAdmins = [];

<?php 	foreach($admins as $admin) {?>
groupAdmins[groupAdmins.length] = {	gad_member_identity: "<?php echo GaletteBo::showIdentity($admin); ?>",
									gad_group_id : <?php echo $admin["gad_group_id"]; ?>,
									gad_member_id : <?php echo $admin["gad_member_id"]; ?>
								};
<?php 	}?>
</script>
<?php include("footer.php");?>

</body>
</html>