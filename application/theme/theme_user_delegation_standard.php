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

<!-- DELEGATION STANDARD part -->

<?php if (!$isVoting || $theme["the_voting_method"] != "demliq") return; ?>

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
		
				if ($eligible["id_adh"] == $sessionUserId) continue;

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
					<input id="delegative-power" type="number" min="0" value="<?php echo $delegativePower; ?>" class="form-control"  <?php	if ($theme["the_delegation_closed"]) { echo "disabled=disabled"; } ?> />
					<input type="hidden" id="delegative-previous-power" value="<?php echo $delegativePower; ?>" />
				</div>
				<div class="col-md-2">
					<button id="delegateButton" type="button" class="btn btn-primary" data-id="<?php echo $eligible["id_adh"]; ?>" <?php	if ($theme["the_delegation_closed"]) { echo "disabled=disabled"; } ?>>Déléguer</button>
				</div>
			</div>
		</fieldset>
	</div>
</div>
	<?php }?>
</form>
