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

$limit = "all";

if (isset($_REQUEST["limit"])) {
	$limit = $_REQUEST["limit"];
}

include_once("header.php");

require_once("engine/bo/GroupBo.php");
require_once("engine/bo/GaletteBo.php");

$groupFilters = array();

$groupBo = GroupBo::newInstance($connection, $config["galette"]["db"]);
$groups = $groupBo->getGroups(array("for_user_only" => (isset($_GET["limit"]) ? $sessionUserId : 0)));

if ($sessionUserId) {
	foreach($groups as $index => $group) {
		$groups[$index]["gro_is_admin"] = $groupBo->isMemberAdmin($group, $sessionUserId);
	}
}

$myVotingGroups = array();
$myEligibleGroups = array();
if ($sessionUserId) {
	$myVotingGroups = $groupBo->getMyGroups(array("userId" => $sessionUserId, "state" => "voting"));
	$myEligibleGroups = $groupBo->getMyGroups(array("userId" => $sessionUserId, "state" => "eligible"));

//	print_r($myVotingGroups);
//	print_r($myEligibleGroups);
	
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
	<?php echo getBreadcrumb(); ?>


<?php
foreach($groups as $groupId => $group) {
?>
	<div class="panel panel-default group">
		<div class="panel-heading">
		<?php if (isset($group["gro_is_admin"]) && $group["gro_is_admin"]) {?>
			<div class="pull-right" >
				<button data-group-id="<?php echo $groupId; ?>" class="btn btn-default btn-xs handleGroupButton">G&eacute;rer <span class="glyphicon glyphicon-cog"></span></button>
				<button data-group-id="<?php echo $groupId; ?>" class="btn btn-default btn-xs addThemeButton">Ajouter un th&egrave;me <span class="glyphicon glyphicon-plus"></span></button>
			</div>
		<?php }?>

			<a href="group.php?id=<?php echo $groupId; ?>"><?php echo $group["gro_label"]; ?></a>&nbsp;
		</div>
		<div class="panel-body">

		<ul>
		<?php
		foreach($group["gro_themes"] as $themeId => $theme) {
			$class = "theme ";
			$class .= isInMyGroup($theme, $myVotingGroups) ? "voting" : "no-voting";
			$class .= isInMyGroup($theme, $myEligibleGroups) ? " eligible" : " no-eligible";
			$class .= $isConnected ? "" : " not-connected";
			if (!isInMyGroup($theme, $myVotingGroups) && !isInMyGroup($theme, $myEligibleGroups) && $limit == "mine") {
				$class .= " not-mine";
			}
		?>
			<li class='<?php echo $class ?>'><h2><a href="theme.php?id=<?php echo $themeId; ?>"><?php echo $theme["the_label"]; ?></a></h2>

			<?php
//					print_r($theme);
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
				<br/><span class="glyphicon glyphicon-time" title="Fin théorique des mandats" data-toggle="tooltip" data-placement="bottom"></span> <span class="date"><?php echo $theme["fixation"]["fix_until_date"]; ?></span>
				<?php }?>
			</li>
		<?php
		}
		?>
		</ul>

		</div>
	</div>

<?php
}
?>

<?php include("connect_button.php"); ?>

</div>

<div class="lastDiv"></div>

<?php include("footer.php");?>
<script>

function checkGroupVisibility() {
	$(".group").each(function() {
		var numberOfVisibleThemes = $(this).find(".theme:visible").length;

		if (numberOfVisibleThemes == 0) {
			$(this).hide();
		}

		// TODO if there is an admin button, show the group in all case
	});
}

function addGroupHandlers() {
	$(".handleGroupButton").click(function(event) {
		var groupId = $(this).data("group-id");
		window.location.href = "group.php?id=" + groupId + "&admin=";
	});
	$(".addThemeButton").click(function(event) {
		var groupId = $(this).data("group-id");
		window.location.href = "theme.php?groupId=" + groupId + "&id=0&admin=";
	});
}

$(function() {
	addGroupHandlers();
	checkGroupVisibility();
});

</script>

</body>
</html>
