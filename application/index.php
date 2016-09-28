<?php /*
	Copyright 2015 Cédric Levieux, Parti Pirate

	This file is part of PPSignature.

    PPSignature is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    PPSignature is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with PPSignature.  If not, see <http://www.gnu.org/licenses/>.
*/
include_once("header.php");

//include_once("groups.php");

?>

<div class="container theme-showcase" role="main">
	<ol class="breadcrumb">
		<li class="active"><?php echo lang("breadcrumb_index"); ?></li>
	</ol>

	<div class="well well-sm">
		<p><?php echo lang("index_guide"); ?></p>
	</div>

<?php 	if ($isConnected) {?>

	<div class="row">
		<div class="col-md-6">
			<a href="groups.php?limit=mine" class=" btn btn-default btn-lg btn-full-width"><?php echo lang("index_my_groups_button"); ?></a>
		</div>
		<div class="col-md-6">
			<a href="member.php?id=<?php echo $sessionUserId; ?>" class="btn btn-default btn-lg btn-full-width"><?php echo lang("index_my_profile_button"); ?></a>
		</div>
	</div>

<?php 	} else {?>

	<div class="row">
		<div class="col-md-6">
			<a href="groups.php" class=" btn btn-default btn-lg btn-full-width"><?php echo lang("index_groups_button"); ?></a>
		</div>
		<div class="col-md-6">
			<a href="connect.php" id="connectButton" class="btn btn-default btn-lg btn-full-width"><?php echo lang("index_connect_button"); ?></a>
		</div>
	</div>

<?php 	}?>

</div>


<?php include("footer.php");?>

</body>
</html>