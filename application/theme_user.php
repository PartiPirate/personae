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
?>

<!-- User part -->

<?php if (!$showAdmin) {?>
<link href="assets/css/editor.css" type="text/css" rel="stylesheet"/>
<?php }?>

<?php if ($fixation && !$showAdmin && $theme["the_delegate_only"] != "1") {?>
<div class="panel panel-default currentFixation">
	<div class="panel-heading">
		Mandats en cours&nbsp;
	</div>
	<table class="table no-pagination">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Pouvoir</th>
				<!--
				<th>Actions</th>
				 -->
			</tr>
		</thead>
		<tbody>
<?php		foreach($fixation["members"] as $memberId => $member) { ?>
			<tr>
				<td><a href="member.php?id=<?php echo $memberId; ?>"><?php echo GaletteBo::showIdentity($member); ?></a></td>
				<td style="text-align: right;"><?php echo $member["fme_power"]?></td>
				<!--
				<td>Voir <?php if ($isElegible) {?>Déléguer<?php }?></td>
				 -->
			</tr>
<?php 		}?>
		</tbody>
	</table>
	<div class="panel-footer text-right">
		<span class="glyphicon glyphicon-time"></span> <span class="date"><?php echo $fixation["fix_until_date"]; ?>
	</div>
</div>
<?php }?>

<?php 	
	$isFixed = false;

	if ($fixation) {
		foreach($fixation["members"] as $memberId => $member) {
			if ($memberId == $sessionUserId) {
				$isFixed = true;
				break;
			}
		}
	}

	if ($fixation && !$showAdmin && !$isFixed && $isElegible && $theme["the_free_fixed"] == 1) {?>
<div class="row">
	<div class="col-md-12">
		<a href="#" id="free-theme-enter-btn" class="btn btn-default btn-lg btn-full-width" data-theme-id="<?php echo $theme["the_id"]; ?>">Entrer librement</a>
	</div>
</div>
<br>
<?php	} ?>

<?php if ($isElegible && !$showAdmin && (true || $theme["the_delegate_only"] != "1")) {?>
<div class="panel panel-default eligible">
	<div class="panel-heading">
		Moi, délégué·e…&nbsp;
	</div>
	<div class="panel-body">
		<form id="candidateForm" action="do_candidate.php" method="post">
		<input type="hidden" name="can_theme_id" id="can_theme_id" value="<?php echo $candidate["can_theme_id"]; ?>" />
		<input type="hidden" name="can_member_id" id="can_member_id" value="<?php echo $candidate["can_member_id"]; ?>" />
		<input type="checkbox" value="candidate"
			<?php echo $candidate["can_status"] == "candidate" ? 'checked="checked"' :  '';?>
			id="can_status_candidate" name="can_status" /> J'accepte les délégations

		<input type="checkbox" value="anti"
			<?php echo $candidate["can_status"] == "anti" ? 'checked="checked"' :  '';?>
			id="can_status_anti" name="can_status" /> Je refuse les délégations

		<br/>
		<!--
		<textarea id="can_text" name="can_text" style="width: 100%; height: 50px;">
		 -->
		<input type="hidden" name="can_text" />
		<div id="can_text">
		<?php echo $candidate["can_text"]; ?>
		</div>
		<!-- </textarea> -->
		</form>
	</div>
</div>
<?php }?>

<?php if ($isVoting && !$showAdmin && $theme["the_voting_method"] == "sort") {?>
<div class="panel panel-default voting">
	<div class="panel-heading">
		Délégation par tirage au sort&nbsp;
	</div>
</div>
<?php }?>

<?php if ($isVoting && !$showAdmin && $theme["the_voting_method"] == "demliq") {?>
<form id="votingForm" action="do_voting.php" method="post" class="form-horizontal">

<div class="panel panel-default voting">
	<div class="panel-heading">
		Délégation par démocratie liquide&nbsp;
	</div>
	<div class="panel-body">

		<?php if (count($powers) && $theme["the_secret_until_fixation"] == "0") {?>
		<h3>Délégation en cours</h3>

		<table id="powerInProgressTable" class="table no-pagination">
			<thead>
				<tr>
					<th style="width: 20%">Nom</th>
					<th style="width: 10%">Pouvoir</th>
					<th>Délégations</th>
				</tr>
			</thead>
			<tbody>
		<?php

		function showGivers($givers) {
			if (!$givers || !count($givers)) return "";

			//$return = '"';
			$return = '';

			$offset = 0;
			foreach($givers as $giver) {
				if ($offset) {
					$return .= ", ";
				}
				$return .= GaletteBo::showIdentity($giver);
				$return .= "[+".$giver["given_power"]."]";

				$childrenGivers = showGivers($giver["givers"]);

				if ($childrenGivers) {
					$return .= " ($childrenGivers)";
				}
				$offset++;
			}

	//		$return .= '"';
			$return .= '';

			return $return;
		}

		foreach($powers as $power) {
			if ($power["power"] <= $theme["the_voting_power"]) continue;

			echo "<tr>";

			echo "<td>";
			echo "<a href=\"member.php?id=" . $power["id_adh"] . "\">";
			echo GaletteBo::showIdentity($power);
			echo "</a>";
			echo "</td>";

			echo "<td class='text-right'>";
			echo $power["power"];
			echo "</td>";

			echo "<td>";
			echo showGivers($power["givers"]);
			echo "</td>";

			echo "</tr>";
		}

		?>

			</tbody>
		</table>
		<?php }?>

		<h3>Mes délégations</h3>

		Mes délégations : <span id="delegations"></span><br />
		Pouvoir de délégation restant : <span id="delegative-remaining-power">2</span><br />

		<input type="hidden" name="del_theme_id" id="del_theme_id" value="<?php echo $theme["the_id"]; ?>" />
		<input type="hidden" name="del_theme_type" id="del_theme_type" value="dlp_themes" />
		<input type="hidden" name="del_member_from" id="del_member_from" value="<?php echo $sessionUserId; ?>" />
		<input type="hidden" name="del_power" id="del_power" value="0" />
		<input type="hidden" id="del_previous_power" value="0" />

		<input type="hidden" name="del_member_to" id="del_member_to">

		<div class="form-group">
			<label class="col-md-4 control-label" for="tad_member_mail">Donner ma délégation à : </label>
			<div class="col-md-6">
				<div class="input-group">
					<input type="text" id="delegated_member_nickname" placeholder="email ou pseudo"
						class="form-control"
					/><span class="input-group-btn"><button
						data-success-function="showDelegationFromSearchForm"
						data-success-label="Donner ma délégation"
						data-selection-type="single"
						data-filter-theme-id="<?php echo $theme["the_id"]; ?>"
						class="btn btn-default search-user"><span class="fa fa-search"></span></button></span>
				</div>
			</div>
		</div>
	</div>
</div>

	<?php foreach($eligibles as $eligible) {
				$delegativePower = 0;
				foreach($delegations as $delegation) {
					if ($eligible["id_adh"] == $delegation["del_member_to"]) {
						$delegativePower = $delegation["del_power"];
						break;
					}
				}
			?>

<div class="panel panel-default voting delegative" 
		id="delegative-<?php echo $eligible["id_adh"]; ?>"
				data-nickname="<?php echo strtolower($eligible["pseudo_adh"]); ?>"
				data-mail="<?php echo strtolower($eligible["email_adh"]); ?>"
				data-id="<?php echo $eligible["id_adh"]; ?>"
				data-eligible="<?php echo $eligible["can_status"]; ?>"
				style="display:<?php echo ($eligible["can_status"] == "candidate" ? "block" : "none"); ?>;">
	<div class="panel-heading">
		Délégué·e : <span id="delegate-name"><?php echo GaletteBo::showIdentity($eligible); ?></span>
		<?php

		switch($eligible["can_status"]) {
			case "candidate":
				echo "<span title='Candidat' class='text-success fa fa-thumbs-o-up'></span>";
				break;
			case "anti":
				echo "<span title='Ne veut pas être élu' class='text-danger fa fa-thumbs-o-down'></span>";
				break;
			case "neutral":
			case "voting":
				echo "<span title='Eligible ou votant' class='text-primary fa fa-hand-paper-o'></span>";
				break;
		}

		?>
	</div>
	<div class="panel-body">
		<fieldset>
			<div>
				<?php if (trim($eligible["can_text"])) {?>
<!--				Proposition de candidature : <br/>-->
				<?php echo $eligible["can_text"]; ?>
				<?php }?>
			</div>
			<hr>
			<div class="form-group">
				<label class="col-md-4 control-label" for="tad_member_mail">Pouvoir de délégation confié : </label>
				<div class="col-md-6">
					<input id="delegative-power" type="number" min="0" value="<?php echo $delegativePower; ?>" class="form-control" />
					<input type="hidden" id="delegative-previous-power" value="<?php echo $delegativePower; ?>" />
				</div>
				<div class="col-md-2">
					<button id="delegateButton" type="button" class="btn btn-primary" data-id="<?php echo $eligible["id_adh"]; ?>">Déléguer</button>
				</div>
			</div>
		</fieldset>
	</div>
</div>
	<?php }?>

</form>

<?php }?>
