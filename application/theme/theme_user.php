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

<?php if ($showAdmin && $isAdmin) return; ?>

<?php include("theme/theme_user_fixation.php"); ?>

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
?>

<?php
	if ($fixation && !$isFixed && $isElegible && $theme["the_free_fixed"] == 1) {?>
	
<div class="row">
	<div class="col-md-12">
		<a href="#" id="free-theme-enter-btn" class="btn btn-default btn-lg btn-full-width" data-theme-id="<?php echo $theme["the_id"]; ?>">Entrer librement</a>
	</div>
</div>
<br>
<?php	
	} 
	else if ($fixation && $isFixed && $isElegible && $theme["the_free_fixed"] == 1) { ?>

<div class="row">
	<div class="col-md-12">
		<a href="#" id="free-theme-exit-btn" class="btn btn-default btn-lg btn-full-width" data-theme-id="<?php echo $theme["the_id"]; ?>">Sortir librement</a>
	</div>
</div>
<br>
<?php	
	}
?>

<?php if (($isElegible && (true || $theme["the_delegate_only"] != "1") && !$theme["the_delegation_closed"])) {?>
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

<?php if ($isVoting && $theme["the_voting_method"] == "sort") {?>
<div class="panel panel-default voting">
	<div class="panel-heading">
		Délégation par tirage au sort&nbsp;
	</div>
</div>
<?php }?>

<?php include("theme/theme_user_delegation_standard.php"); ?>
<?php include("theme/theme_user_delegation_advanced.php"); ?>

