<?php /*
	Copyright 2015-2017 Cédric Levieux, Parti Pirate

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

$groupFilters = array();

$galetteBo = GaletteBo::newInstance($connection, $config["galette"]["db"]);

$isAdmin = false;
$showAdmin = false;
$authoritatives = array();

if ($isConnected) {
	if ($group["gro_id"]) {
		$isAdmin = $groupBo->isMemberAdmin($group, $sessionUserId);
		$showAdmin = isset($_REQUEST["admin"]);

		if ($isAdmin) {
			$admins = $groupBo->getMemberAdmins($group);
			$authorityAdmins = $groupBo->getAuthorityAdmins($group);
			$authoritatives = $galetteBo->getGroups();
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

	<div id="information">
		<div class="panel panel-success">
			<div class="panel-heading">
				Information&nbsp;
			</div>
			<div class="panel-body">

				<form id="saveGroupForm" action="do_save_group.php" method="post" class="form-horizontal">
					<fieldset>
						<input type="hidden" name="gro_id" value="<?php echo $group["gro_id"]; ?>" />

						<?php // echo print_r($group, true); ?>

						<div class="form-group">
							<label class="col-md-3 control-label" for="gro_label">Libellé : </label>
							<div class="col-md-3">
								<input type="text" name="gro_label" id="gro_label"
									placeholder="" class="form-control input-md"
									value="<?php echo $group["gro_label"]; ?>"/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="gro_contact_type">Type de contact : </label>
							<div class="col-md-3">
								<select name="gro_contact_type" id="gro_contact_type" class="form-control input-md">
									<option value="none" <?php echo $group["gro_contact_type"] == "none" ? 'selected="selected"' : ''; ?>>Aucun</option>
									<option value="mail" <?php echo $group["gro_contact_type"] == "mail" ? 'selected="selected"' : ''; ?>>Par mail</option>
									<option value="discourse_group" <?php echo $group["gro_contact_type"] == "discourse_group" ? 'selected="selected"' : ''; ?>>Groupe Discourse</option>
									<option value="discourse_category" <?php echo $group["gro_contact_type"] == "discourse_category" ? 'selected="selected"' : ''; ?>>Catégorie Discourse</option>
								</select>
							</div>			

							<label class="col-md-3 control-label contact-type mail" for="gro_contact">Adresse mail : </label>
							<label class="col-md-3 control-label contact-type discourse_group" for="gro_contact">Groupe Discourse : </label>
							<label class="col-md-3 control-label contact-type discourse_category" for="gro_contact">Categorie Discourse : </label>
							<div class="col-md-3 contact-type mail discourse_group discourse_category">
								<input type="text" name="gro_contact" id="gro_contact"
									placeholder="" class="form-control input-md"
									value="<?php echo $group["gro_contact"]; ?>"/>
							</div>
						</div>

					</fieldset>

				</form>
			</div>
		</div>
	</div>

	<div id="authoritative">
		<div class="panel panel-success">
			<div class="panel-heading">
				A autorité sur&nbsp;
			</div>
			<div class="panel-body">

				<form id="addAuthoritativeForm" action="do_set_group_authority.php" method="post" class="form-horizontal">
					<fieldset>
						<input type="hidden" name="action" value="add_authority" />
						<input type="hidden" name="gau_group_id" value="<?php echo $group["gro_id"]; ?>" />

						<label class="col-md-4 control-label" for="gau_authoritative_id">Groupe d'utilisateurs à ajouter : </label>
						<div class="col-md-6">
							<select name="gau_authoritative_id" id="gau_authoritative_id" class="form-control input-md">
								<option value=""></option>
								<option value="0">Tous les membres</option>
							<?php 	foreach($authoritatives as $authoritative) { ?>
								<option value="<?php echo $authoritative["id_group"]; ?>"><?php echo utf8_encode($authoritative["group_name"]); ?></option>
							<?php	} ?>
							</select>
						</div>
						<div class="col-md-2">
							<button id="addAuthoritativeButton" class="btn btn-primary">Ajouter <span class="glyphicon glyphicon-plus"></span></button>
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
		<tr data-template-id="template-group-authoritative" class="template">
			<td>${gau_authoritative_name}</td>
			<td>&nbsp;<a href="#" class="removeAuthoritativeLink text-danger" data-group-id="${gau_group_id}" data-authoritative-id="${gau_authoritative_id}"><span class="glyphicon glyphicon-remove"></span></td>
		</tr>
	</table>
</templates>

<script>
var groupAdmins = [];
var groupAuthoritatives = [];

<?php 	foreach($admins as $admin) {?>
groupAdmins[groupAdmins.length] = {	gad_member_identity: "<?php echo GaletteBo::showIdentity($admin); ?>",
									gad_group_id : <?php echo $admin["gad_group_id"]; ?>,
									gad_member_id : <?php echo $admin["gad_member_id"]; ?>
								};
<?php 	}?>

<?php 	foreach($authorityAdmins as $admin) {?>
groupAuthoritatives[groupAuthoritatives.length] = {	gau_authoritative_name: "<?php echo utf8_encode($admin["gau_authoritative_name"] ? $admin["gau_authoritative_name"] : "Tous les membres"); ?>",
									gau_group_id : <?php echo $admin["gau_group_id"]; ?>,
									gau_authoritative_id : <?php echo $admin["gau_authoritative_id"]; ?>
								};
<?php 	}?>



</script>
<?php include("footer.php");?>

</body>
</html>