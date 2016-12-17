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
?>

<!-- Administration part -->

<?php if ($isAdmin && $showAdmin) {?>

<form id="saveThemeForm" action="do_save_theme.php" method="post" class="form-horizontal">
	<div class="saved" style="display: none;">Sauv&eacute;</div>
	<input type="hidden" name="the_id" id="the_id" value="<?php echo $theme["the_id"]; ?>" />

<div class="panel panel-default admin">
	<div class="panel-heading">
		R&egrave;gle de fixation&nbsp;
	</div>
	<div class="panel-body">

		<fieldset>

			<?php if (isset($_REQUEST["groupId"])) {?>
			<input name="the_group_id" type="hidden" value="<?php echo intval($_REQUEST["groupId"]); ?>" />
			<?php }?>

			<div class="form-group">
				<label class="col-md-4 control-label" for="the_label">Nom du thème :</label>
				<div class="col-md-8">
					<input type="text" name="the_label" id="the_label"
						placeholder="" class="form-control input-md"
						value="<?php echo $theme["the_label"]; ?>"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="the_min_members">Nombre minimum de personnes :</label>
				<div class="col-md-2">
					<input type="text" name="the_min_members" id="the_min_members"
						placeholder="" class="form-control input-md"
						value="<?php echo $theme["the_min_members"]; ?>"/>
				</div>
				<label class="col-md-4 control-label method demliq" for="the_max_members">Nombre maximum de personnes : </label>
				<div class="col-md-2 method demliq">
					<input type="text" name="the_max_members" id="the_max_members"
						placeholder="" class="form-control input-md"
						value="<?php echo $theme["the_max_members"]; ?>"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="the_next_fixation_date">Date de la prochaine fixation : </label>
				<div class="col-md-2">
					<input type="date" name="the_next_fixation_date" id="the_next_fixation_date"
						placeholder="" class="form-control input-md"
						value="<?php echo $theme["the_next_fixation_date"]; ?>"/>
				</div>
				<label class="col-md-4 control-label" for="the_next_fixed_until_date">Date prévue de fin de mandat pour la prochaine fixation : </label>
				<div class="col-md-2">
					<input type="date" name="the_next_fixed_until_date" id="the_next_fixed_until_date"
						placeholder="" class="form-control input-md"
						value="<?php echo $theme["the_next_fixed_until_date"]; ?>"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="the_voting_method">Méthode de fixation : </label>
				<div class="col-md-2">
					<select name="the_voting_method" id="the_voting_method" class="form-control input-md">
						<option value="demliq" <?php echo $theme["the_voting_method"] == "demliq" ? 'selected="selected"' : ''; ?>>Démocratie liquide</option>
						<option value="sort" <?php echo $theme["the_voting_method"] == "sort" ? 'selected="selected"' : ''; ?>>Tirage au sort</option>
						<option value="external_results" <?php echo $theme["the_voting_method"] == "external_results" ? 'selected="selected"' : ''; ?>>Résultats externes</option>
					</select>

				</div>
			</div>
			<div class="form-group method demliq">
				<label class="col-md-4 control-label" for="the_voting_power">Pouvoir de vote par votants : </label>
				<div class="col-md-2">
					<input type="text" name="the_voting_power" id="the_voting_power"
						placeholder="" class="form-control input-md"
						value="<?php echo $theme["the_voting_power"]; ?>"/>
				</div>
			</div>
			<div class="form-group method demliq">
				<div class="col-md-4 text-right">
					<input type="checkbox" name="the_secret_until_fixation" id="the_secret_until_fixation"
						placeholder="" class=""
						<?php echo $theme["the_secret_until_fixation"] ? " checked " : ""; ?>
						value="1"/>
				</div>
				<div class="col-md-6">
					<label class="form-control labelForCheckbox" for="the_secret_until_fixation">D&eacute;l&eacute;gation secr&egrave;te jusqu'&agrave; la fixation</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="the_discourse_group_labels">Groupes discourse : </label>
				<div class="col-md-8">
					<input type="text" name="the_discourse_group_labels" id="the_discourse_group_labels"
						placeholder="" class="form-control input-md"
						value="<?php echo htmlspecialchars($theme["the_discourse_group_labels"], ENT_QUOTES); ?>"/>
				</div>
			</div>
		</fieldset>
	</div>
</div>

<div id="source" class="panel panel-default voting">
	<div class="panel-heading">
		Source des candidats&nbsp;
	</div>
	<div class="panel-body">
		<fieldset>
			<div class="form-group">
				<label class="col-md-3 control-label" for="the_eligible_group_type">Source primaire : </label>
				<div class="col-md-3">
					<select id="the_eligible_group_type" name="the_eligible_group_type" class="form-control input-md">
						<option value="dlp_groups" <?php echo ($theme["the_eligible_group_type"] == "dlp_groups") ? " selected " : ""; ?>>Groupe</option>
						<option value="dlp_themes" <?php echo ($theme["the_eligible_group_type"] == "dlp_themes") ? " selected " : ""; ?>>Theme</option>
						<option value="galette_groups" <?php echo ($theme["the_eligible_group_type"] == "galette_groups") ? " selected " : ""; ?>>Groupe Galette</option>
						<option value="galette_adherents" <?php echo ($theme["the_eligible_group_type"] == "galette_adherents") ? " selected " : ""; ?>>Adh&eacute;rents Galette</option>
					</select>
				</div>
				<label class="col-md-3 control-label" for="the_eligible_group_id">Source secondaire : </label>
				<div class="col-md-3">
					<select id="the_eligible_group_id" name="the_eligible_group_id" class="form-control input-md">
						<option class="dlp_groups" value="0" >Veuillez choisir un groupe</option>
				<?php 	foreach($groups as $listGroup) {?>
						<option class="dlp_groups"
							value="<?php echo $listGroup["gro_id"]; ?>"
						<?php  if ($theme["the_eligible_group_type"] == "dlp_groups" && $theme["the_eligible_group_id"] == $listGroup["gro_id"]) {?>
							selected="selected"
						<?php 	}?>

						><?php echo $listGroup["gro_label"]; ?></option>
				<?php 	}?>

						<option class="dlp_themes" value="0" >Veuillez choisir un theme</option>
				<?php 	foreach($themes as $listTheme) {?>
						<option class="dlp_themes"
							value="<?php echo $listTheme["the_id"]; ?>"

						<?php  if ($theme["the_eligible_group_type"] == "dlp_themes" && $theme["the_eligible_group_id"] == $listTheme["the_id"]) {?>
							selected="selected"
						<?php 	}?>

						><?php echo $listTheme["the_label"]; ?></option>
				<?php 	}?>

						<option class="galette_groups" value="0" >Veuillez choisir un groupe</option>
				<?php 	foreach($galetteGroups as $listGroup) {?>
						<option class="galette_groups"
							value="<?php echo $listGroup["id_group"]; ?>"

						<?php  if ($theme["the_eligible_group_type"] == "galette_groups" && $theme["the_eligible_group_id"] == $listGroup["id_group"]) {?>
							selected="selected"
						<?php 	}?>

						><?php echo utf8_encode($listGroup["group_name"]); ?></option>
				<?php 	}?>

						<option class="galette_adherents" value="0" >Tous les adh&eacute;rents</option>
					</select>
				</div>
			</div>
		</fieldset>
	</div>
</div>

<div id="voting" class="method demliq panel panel-default voting">
	<div class="panel-heading">
		Source des &eacute;lecteurs&nbsp;
	</div>
	<div class="panel-body">
		<fieldset>
			<div class="form-group">
				<label class="col-md-3 control-label" for="the_voting_group_type">Source primaire : </label>
				<div class="col-md-3">
					<select id="the_voting_group_type" name="the_voting_group_type" class="form-control input-md">
						<option value="dlp_groups" <?php echo ($theme["the_voting_group_type"] == "dlp_groups") ? " selected " : ""; ?>>Groupe</option>
						<option value="dlp_themes" <?php echo ($theme["the_voting_group_type"] == "dlp_themes") ? " selected " : ""; ?>>Theme</option>
						<option value="galette_groups" <?php echo ($theme["the_voting_group_type"] == "galette_groups") ? " selected " : ""; ?>>Groupe Galette</option>
						<option value="galette_adherents" <?php echo ($theme["the_voting_group_type"] == "galette_adherents") ? " selected " : ""; ?>>Adh&eacute;rents Galette</option>
					</select>
				</div>


				<label class="col-md-3 control-label" for="the_voting_group_id">Source secondaire : </label>
				<div class="col-md-3">
					<select id="the_voting_group_id" name="the_voting_group_id" class="form-control input-md">
						<option class="dlp_groups" value="0" >Veuillez choisir un groupe</option>
				<?php 	foreach($groups as $listGroup) {?>
						<option class="dlp_groups"
							value="<?php echo $listGroup["gro_id"]; ?>"

						<?php  if ($theme["the_voting_group_type"] == "dlp_groups" && $theme["the_voting_group_id"] == $listGroup["gro_id"]) {?>
							selected="selected"
						<?php 	}?>

						><?php echo $listGroup["gro_label"]; ?></option>
				<?php 	}?>

						<option class="dlp_themes" value="0" >Veuillez choisir un theme</option>
				<?php 	foreach($themes as $listTheme) {?>
						<option class="dlp_themes"
							value="<?php echo $listTheme["the_id"]; ?>"

						<?php  if ($theme["the_voting_group_type"] == "dlp_themes" && $theme["the_voting_group_id"] == $listTheme["the_id"]) {?>
							selected="selected"
						<?php 	}?>

						><?php echo $listTheme["the_label"]; ?></option>
				<?php 	}?>

						<option class="galette_groups" value="0" >Veuillez choisir un groupe</option>
				<?php 	foreach($galetteGroups as $listGroup) {?>
						<option class="galette_groups"
							value="<?php echo $listGroup["id_group"]; ?>"

						<?php  if ($theme["the_voting_group_type"] == "galette_groups" && $theme["the_voting_group_id"] == $listGroup["id_group"]) {?>
							selected="selected"
						<?php 	}?>

						><?php echo utf8_encode($listGroup["group_name"]); ?></option>
				<?php 	}?>

						<option class="galette_adherents" value="0" >Tous les adh&eacute;rents</option>
					</select>
				</div>
			</div>
		</fieldset>
	</div>
</div>

</form>

<div class="method external_results">
	<div class="panel panel-default fixation">
		<div class="panel-heading">
			Gestion de la fixation&nbsp;
		</div>
		<div class="panel-body">


			<form id="newFixationForm" action="do_set_new_fixation_theme.php" method="post">
				<input type="hidden" name="the_id" value="<?php echo $theme["the_id"]; ?>" />
				<button id="newFixationButton" class="btn btn-success">Nouvelle fixation <span class="glyphicon glyphicon-refresh"></span></button>
			</form>


			<div id="fixedMembers">
				<h3>En poste</h3>

				<form id="addElectedForm" action="do_set_fixation_member.php" method="post" class="form-horizontal">
					<input type="hidden" name="action" value="add_member" />
					<input type="hidden" name="fme_fixation_id" value="<?php echo $theme["the_current_fixation_id"]; ?>" />
					<div class="form-group">
						<label class="col-md-4 control-label" for="tad_member_mail">Utilisateur qui a du pouvoir : </label>
						<div class="col-md-4">
							<div class="input-group">
								<input type="text" id="fme_member_mail" name="fme_member_mail" placeholder="email ou pseudo"
								class="form-control"
								/><span class="input-group-btn"><button
									data-success-function="showFixedMemberFromSearchForm"
									data-success-label="Selectionner"
									data-selection-type="single"
									data-filter-with="true"
									data-filter-theme-id="<?php echo $theme["the_id"]; ?>"
									class="btn btn-default search-user"><span class="fa fa-search"></span></button></span>
							</div>
						</div>
						<div class="col-md-2">
							<input type="text" class="form-control"
								name="fme_power" placeholder="pouvoir" style="text-align: right;"/>
						</div>
						<div class="col-md-2">
							<button id="addElectedButton" class=" btn btn-primary">Ajouter <span class="glyphicon glyphicon-plus"></span></button>
						</div>
					</div>
				</form>

				<table class="no-pagination">
					<tbody>
						<?php 	if ($fixation) {
									foreach($fixation["members"] as $memberId => $member) {
										if (!$memberId) continue;
						?>
						<tr>
							<td><?php echo GaletteBo::showIdentity($member); ?></td>
							<td class="text-right"><?php echo $member["fme_power"]?></td>
							<td>&nbsp;<a href="#" class="removeElectedLink text-danger" data-fixation-id="<?php echo $theme["the_current_fixation_id"]; ?>" data-member-id="<?php echo $memberId; ?>"><span class="glyphicon glyphicon-remove"></span></td>
						</tr>
						<?php 		}
								}?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div id="admins">
	<div class="panel panel-primary theme <?php echo $class ?>">
		<div class="panel-heading">
			Administrateurs du thème&nbsp;
		</div>
		<div class="panel-body">

			<form id="addAdminForm" action="do_set_theme_admin.php" method="post" class="form-horizontal">
				<fieldset>
					<input type="hidden" name="action" value="add_admin" />
					<input type="hidden" name="tad_theme_id" value="<?php echo $theme["the_id"]; ?>" />

					<div class="form-group">
						<label class="col-md-4 control-label" for="tad_member_mail">Utilisateur à ajouter en tant qu'administrateur : </label>
						<div class="col-md-6">
							<div class="input-group">
								<input type="text" name="tad_member_mail" placeholder="email ou pseudo"
									class="form-control"
								/><span class="input-group-btn"><button
									data-success-function="addThemeAdminFromSearchForm"
									data-success-label="Ajouter"
									class="btn btn-default search-user"><span class="fa fa-search"></span></button></span>
							</div>
						</div>
						<div class="col-md-2">
							<button id="addAdminButton" class="btn btn-primary">Ajouter <span class="glyphicon glyphicon-plus"></span></button>
						</div>
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

<div id="deleteTheme">
	<h2>Suppression</h2>

	<form id="deleteThemeForm" action="do_delete_theme.php" method="post">
		<input type="hidden" name="the_id" value="<?php echo $theme["the_id"]; ?>" />
		<button id="deleteThemeButton" class=" btn btn-danger">Supprimer <span class="glyphicon glyphicon-remove"></span></button>
	</form>
</div>

<templates>
	<table>
		<tr data-template-id="template-theme-admin" class="template">
			<td>${tad_member_identity}</td>
			<td>&nbsp;<a href="#" class="removeAdminLink text-danger" data-theme-id="${tad_theme_id}" data-member-id="${tad_member_id}"><span class="glyphicon glyphicon-remove"></span></td>
		</tr>
	</table>
</templates>

<script>
var themeAdmins = [];

<?php 	foreach($admins as $admin) {?>
themeAdmins[themeAdmins.length] = {	tad_member_identity: "<?php echo GaletteBo::showIdentity($admin); ?>",
									tad_theme_id : <?php echo $admin["tad_theme_id"]; ?>,
									tad_member_id : <?php echo $admin["tad_member_id"]; ?>
								};
<?php 	}?>

</script>

<?php }?>
