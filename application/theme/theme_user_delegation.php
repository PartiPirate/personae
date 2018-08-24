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

<!-- DELEGATION ADVANCED part -->

<?php if (!$isVoting || $theme["the_voting_method"] != "demliq") return; ?>

<div class="panel panel-default voting">
	<div class="panel-heading">
		Délégation par démocratie liquide&nbsp;
	</div>
	<div class="panel-body tabs-bottom">

        <!-- Tab panes -->
        <div class="tab-content">
        	<div role="tabpanel" class="tab-pane active" id="delegation-standard">
        <?php include("theme/theme_user_delegation_standard.php"); ?>
            </div>
        	<div role="tabpanel" class="tab-pane" id="delegation-advanced">
        <?php include("theme/theme_user_delegation_advanced.php"); ?>
            </div>
        </div
        
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist" style="margin: 0 -16px -15px -16px;">
        	<li role="presentation" class="active">
        		<a href="#delegation-standard" aria-controls="home" role="tab" data-toggle="tab">Délégations standards<?php //echo lang("construction_arguments"); ?></a>
        	</li>
        	<li role="presentation">
        		<a href="#delegation-advanced" aria-controls="profile" role="tab" data-toggle="tab">Délégations avancées<?php //echo lang("construction_sources"); ?></a>
        	</li>
        </ul>
        

	</div>
</div>
