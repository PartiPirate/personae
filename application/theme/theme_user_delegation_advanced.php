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

<?php   if (!$isVoting || $theme["the_voting_method"] != "demliq") return; ?>

<!-- DEV -->
<?php   if ($sessionUserId != 12 && $sessionUserId != 1 && $sessionUserId != 649 && $sessionUserId != 338 && $sessionUserId != 887 && $sessionUserId != 731) return; ?>


<?php   
        $statusEligibles = array("candidate" => array(), "anti" => array(), "voting" => array());

        foreach($eligibles as $eligible) {
		    if ($eligible["id_adh"] == $sessionUserId) continue;
		    if (!$eligible["id_type_cotis"]) continue; // TODO view to change that
		    
		    switch($eligible["can_status"]) {
    			case "candidate":
    			    $statusEligibles["candidate"][] = $eligible;
    				break;
    			case "anti":
    			    $statusEligibles["anti"][] = $eligible;
    				break;
    			case "neutral":
    			case "voting":
    			    $statusEligibles["voting"][] = $eligible;
    				break;
		    }
	    }
?>

<div id="conditional-delegetation-container">

<div class="panel panel-default conditional-delegation">
	<div class="panel-heading">
        <button type="button" class="btn btn-danger remove-conditional-delegation-btn pull-right" title="Retirer une règle de délégation"><i class="fa fa-minus" aria-hidden="true"></i></button>
		<input class="conditional-delegation-label-input form-control" placeholder="Libellé de la règle de délégation" style="width: calc(100% - 42px); display: inline-block;">
	</div>
	<div class="panel-body">

        <div class="form-group form-headers">
            <label class="col-md-2 control-label" ></label>
            <label class="col-md-3 control-label" >Champ</label>
            <label class="col-md-3 control-label" >Operateur</label>
            <label class="col-md-2 control-label" >Valeur</label>
            <label class="col-md-2 control-label" ></label>
        </div>
        <div class="clearfix"></div>

        <div class="condition-container">
            <div class="form-group condition clearfix">
                <div class="col-md-2">
                    <select name="condition-interaction-select" class="form-control">
                        <option value="if">Si</option>
                        <option value="and">Et</option>
                        <option value="or">Ou</option>
                        <option value="andif">Et si</option>
                        <option value="orif">Ou si</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="field-select" class="form-control">
                        <option value=""></option>
                        <optgroup label="Motion">
                            <option value="motion_title" data-type="string">Le titre de la motion</option>
                            <option value="motion_description" data-type="string">La description de la motion</option>
                        </optgroup>
                        <optgroup label="Votants">
                            <option value="voter_me" data-type="me">Moi en tant que votant</option>
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="operator-select" class="form-control">
                        <option value="" data-need-value="false"></option>
                        <optgroup label="Chaîne" data-type="string">
                            <option value="contains" data-need-value="true">contient</option>
                            <option value="do_not_contain" data-need-value="true">ne contient pas</option>
                        </optgroup>
                        <optgroup label="Moi" data-type="me">
                            <option value="do vote" data-need-value="false">, j'ai voté</option>
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-2">
                    <input name="value-input" type="text" placeholder="" class="form-control input-md">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary add-condition-btn" title="Ajouter une condition"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-danger remove-condition-btn" title="Retirer une condition"><i class="fa fa-minus" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>

        <hr>

        <div class="form-group form-headers">
            <label class="col-md-2 control-label" ></label>
            <label class="col-md-4 control-label" >Délégataire</label>
            <label class="col-md-4 control-label" >Pouvoir</label>
            <label class="col-md-2 control-label" ></label>
        </div>
        <div class="clearfix"></div>

        <div class="delegation-container">
            <div class="form-group delegation clearfix">
                <div class="col-md-2" style="padding-top:  10px; text-align: right; ">
                    Je donne à
                </div>
                <div class="col-md-4">
                    <select name="person-select" class="form-control">
                        <option value=""></option>
                        <optgroup label="Volontaire pour recevoir des délégations">
                            <?php   foreach($statusEligibles["candidate"] as $eligible) { ?>
                                <option value="<?php echo $eligible["id_adh"]; ?>"><?php echo GaletteBo::showIdentity($eligible); ?></option>
                            <?php   } ?>
                        </optgroup>
                        <optgroup label="Peut recevoir des délégations">
                            <?php   foreach($statusEligibles["voting"] as $eligible) { ?>
                                <option value="<?php echo $eligible["id_adh"]; ?>"><?php echo GaletteBo::showIdentity($eligible); ?></option>
                            <?php   } ?>
                        </optgroup>
                        <optgroup label="Ne veut pas de délégation">
                            <?php   foreach($statusEligibles["anti"] as $eligible) { ?>
                                <option value="<?php echo $eligible["id_adh"]; ?>"><?php echo GaletteBo::showIdentity($eligible); ?></option>
                            <?php   } ?>
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-4">
                    <input name="value-input" type="number" min="0" max="<?php echo $theme["the_voting_power"]; ?>" placeholder="" class="form-control input-md">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary add-delegation-btn" title="Ajouter une délégation"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-danger remove-delegation-btn" title="Retirer une délégation"><i class="fa fa-minus" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>            

        <div class="form-group">
            <div class="col-md-2 text-right">
                <label class="checkbox-inline">
                    <input type="checkbox" name="end-of-delegation" value="1">
                </label>
            </div>
            <label class="col-md-10 control-label" style="padding-top:  10px; ">Et c'est la fin des délégations (les délégations suivantes, conditionnelles et par défaut, ne seront pas prises en compte)</label>
        </div>

    </div>
</div>

</div>



<button id="add-conditional-delegation-btn" type="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter des délégations conditionnelles</button>

<br>
<br>

<div class="panel panel-default" id="default-delegation">
	<div class="panel-heading">
		Délégations par défaut&nbsp;
	</div>
	<div class="panel-body">

        <div class="form-group form-headers">
            <label class="col-md-2 control-label" ></label>
            <label class="col-md-4 control-label" >Délégataire</label>
            <label class="col-md-4 control-label" >Pouvoir</label>
            <label class="col-md-2 control-label" ></label>
        </div>
        <div class="clearfix"></div>

        <div class="delegation-container">
            <div class="form-group delegation clearfix">
                <div class="col-md-2" style="padding-top:  10px; text-align: right; ">
                    Je donne à
                </div>
                <div class="col-md-4">
                    <select name="person-select" class="form-control">
                        <option value=""></option>
                        <optgroup label="Volontaire pour recevoir des délégations">
                            <?php   foreach($statusEligibles["candidate"] as $eligible) { ?>
                                <option value="<?php echo $eligible["id_adh"]; ?>"><?php echo GaletteBo::showIdentity($eligible); ?></option>
                            <?php   } ?>
                        </optgroup>
                        <optgroup label="Peut recevoir des délégations">
                            <?php   foreach($statusEligibles["voting"] as $eligible) { ?>
                                <option value="<?php echo $eligible["id_adh"]; ?>"><?php echo GaletteBo::showIdentity($eligible); ?></option>
                            <?php   } ?>
                        </optgroup>
                        <optgroup label="Ne veut pas de délégation">
                            <?php   foreach($statusEligibles["anti"] as $eligible) { ?>
                                <option value="<?php echo $eligible["id_adh"]; ?>"><?php echo GaletteBo::showIdentity($eligible); ?></option>
                            <?php   } ?>
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-4">
                    <input name="value-input" type="number" min="0" max="<?php echo $theme["the_voting_power"]; ?>" placeholder="" class="form-control input-md">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary add-delegation-btn" title="Ajouter une délégation"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-danger remove-delegation-btn" title="Retirer une délégation"><i class="fa fa-minus" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>            

    </div>
</div>

<button type="button" id="save-delegations-btn" class="btn btn-success" title="Sauver les délégation"><i class="fa fa-save" aria-hidden="true"></i> Sauver les délégation</button>

<br><br>
