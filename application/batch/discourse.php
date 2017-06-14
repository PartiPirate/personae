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

// Can only be call from CLI
if (php_sapi_name() != "cli") exit();

$path = "../";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

include_once("config/database.php");
require_once("engine/bo/ThemeBo.php");
require_once("engine/bo/FixationBo.php");
require_once("engine/bo/GaletteBo.php");
require_once("engine/discourse/DiscourseAPI.php");

$connection = openConnection();
//$discourseApi = new richp10\discourseAPI\DiscourseAPI("discourse.partipirate.org", $config["discourse"]["api_key"], "https");
$discourseApi = new richp10\discourseAPI\DiscourseAPI("127.0.0.1:480", $config["discourse"]["api_key"], "http");

$themeBo = ThemeBo::newInstance($connection, $config["galette"]["db"]);
$fixationBo = FixationBo::newInstance($connection, $config["galette"]["db"]);
$galetteBo = GaletteBo::newInstance($connection, $config["galette"]["db"]);

$groupedUsers = array();

// Put on-date members
$filters = array("adh_only" => true);
$filters["activite_adh"] = 1;
$members = $galetteBo->getMembers($filters);

$discourseGroupLabel = "Membres";

if (!isset($groupedUsers[$discourseGroupLabel])) {
	$groupedUsers[$discourseGroupLabel] = array();
}

foreach($members as $member) {
	$groupedUsers[$discourseGroupLabel][] = $member;
}

// Get all themes with discourse parameters
$filters = array("the_has_discourse" => true);
$themes = $themeBo->getThemes($filters);

foreach($themes as $theme) {
	$discourseGroupLabels = json_decode($theme["the_discourse_group_labels"], true);
	$fixationId = $theme["the_current_fixation_id"];
	
	if (!$fixationId) continue;

	$filters = array("fix_id" => $fixationId, "with_fixation_members" => true);
	$members = $fixationBo->getFixations($filters);

	if (!$discourseGroupLabels) $discourseGroupLabels = array();

//	echo "--------------\n";
//	print_r($discourseGroupLabels);

	foreach($discourseGroupLabels as $discourseGroupLabel) {
		if (!isset($groupedUsers[$discourseGroupLabel])) {
			$groupedUsers[$discourseGroupLabel] = array();
		}

		foreach($members as $member) {
			$groupedUsers[$discourseGroupLabel][] = $member;
		}
	}

//	echo "--------------\n";
}

// Get all groups with discourse parameters
$filters = array("has_discourse" => true);
$groups = $galetteBo->getGroups($filters);

foreach($groups as $group) {
	$discourseGroupLabels = json_decode($group["discourse_group_labels"], true);
	
	$filters = array("adh_only" => true, "adh_group_names" => array($group["group_name"]));
	$members = $galetteBo->getMembers($filters);

//	print_r($discourseGroupLabels);

	foreach($discourseGroupLabels as $discourseGroupLabel) {
		if (!isset($groupedUsers[$discourseGroupLabel])) {
			$groupedUsers[$discourseGroupLabel] = array();
		}

		foreach($members as $member) {
			$groupedUsers[$discourseGroupLabel][] = $member;
		}
	}
}

//print_r($groupedUsers);
//exit();

$cachedUsers = array();

$index = 0;
$numberOfOperationsForSleeping = 2;

foreach($groupedUsers as $groupLabel => $users) {
	echo $groupLabel . "\n";

 	$groupId = $discourseApi->getGroupIdByGroupName($groupLabel);
 	sleep(1);
 	
	echo $groupLabel . " => " . count($users) . " users in personae \n";
 	sleep(1);
 	
	$groupMembers = $discourseApi->getGroupMembers($groupLabel, count($users) + 100);
	sleep(1);

	echo $groupLabel . " => " . count($groupMembers->apiresult->members) . " users in discourse \n";

//	exit();
	
// 	if (count($users) == count($groupMembers->apiresult->members)) {
// 		$allFound = true;
// 		foreach($groupMembers->apiresult->members as $member) {
			
// 		}
		
// 		if ($allFound) continue;
// 	}
	
//	echo $groupLabel . "\n";
//	echo print_r($groupMembers->apiresult, true) . "\n"; 
	
	// Retrieve
	
	$toDeletes = $groupMembers->apiresult->members;
	$toAdd = array();

	$usernames = array();
	foreach($users as $memberIndex => $user) {
		if (isset($cachedUsers[$user["email_adh"]])) {
			$discourseUser = $cachedUsers[$user["email_adh"]];
			$usernames[] = $discourseUser->username;

			$found = false;
			foreach($groupMembers->apiresult->members as $memberIndex => $member) {
				if ($discourseUser->username == $member->username) {
					$found = true;

					echo $discourseUser->username . " found \n";

					break;
				}
			}
			
			if (!$found && !in_array($discourseUser->username, $toAdd)) {
				$toAdd[] = $discourseUser->username;
				echo $discourseUser->username . " to add \n";
			}

			foreach($toDeletes as $memberIndex => $member) {
				if ($discourseUser->username == $member->username) {
					unset($toDeletes[$memberIndex]);
					break;
				}
			}			
		}
		else {
			$discourseUser = $discourseApi->getUserByEmail($user["email_adh"]);
	 		if (($index++ % $numberOfOperationsForSleeping) == 0) {
	 			sleep(1);
	 			echo "Retrieving $memberIndex / " . count($users) . "\n";
	 		}
			
			if ($discourseUser) {
				$usernames[] = $discourseUser->username;

				$found = false;
				foreach($groupMembers->apiresult->members as $memberIndex => $member) {
					if ($discourseUser->username == $member->username) {
						$found = true;

						echo $discourseUser->username . " found \n";

						break;
					}
				}
				
				if (!$found && !in_array($discourseUser->username, $toAdd)) {
					$toAdd[] = $discourseUser->username;
					echo $discourseUser->username . " to add \n";
				}
				

				foreach($toDeletes as $memberIndex => $member) {
					if ($discourseUser->username == $member->username) {
						unset($toDeletes[$memberIndex]);
						break;
					}
				}			
				
				$cachedUsers[$user["email_adh"]] = $discourseUser; 
			}
			else if (isset($user["pseudo_adh"])) {
				$discourseUser = $discourseApi->getUserByUsername($user["pseudo_adh"]);
		 		if (($index++ % $numberOfOperationsForSleeping) == 0) sleep(1);
				
				if (isset($discourseUser->apiresult->user)) {
					$usernames[] = $discourseUser->apiresult->user->username;

					$found = false;
					foreach($groupMembers->apiresult->members as $memberIndex => $member) {
						if ($discourseUser->apiresult->user->username == $member->username) {
							$found = true;

							echo $discourseUser->apiresult->user->username . " found \n";

							break;
						}
					}
					
					if (!$found && !in_array($discourseUser->apiresult->user->username, $toAdd)) {
						$toAdd[] = $discourseUser->apiresult->user->username;
						echo $discourseUser->apiresult->user->username . " to add \n";
					}


					foreach($toDeletes as $memberIndex => $member) {
						if ($discourseUser->apiresult->user->username == $member->username) {
							unset($toDeletes[$memberIndex]);
							break;
						}
					}			
				}
				else {
					echo $user["email_adh"] . "not found with pseudo \n";
				}
			}
			else {
				echo $user["email_adh"] . "not found with no pseudo \n";
			}
		}
	}

	print_r($toAdd);
	print_r($toDeletes);
	
//	exit();

/*	if (count($groupMembers->apiresult->members) == count($usernames)) {
		echo $groupLabel . " => " . count($usernames) . " users - no touching \n";
		continue;
	}
*/	
	// Delete
	if (count($toDeletes)) {
		foreach($toDeletes as $memberIndex => $member) {
			$discourseApi->removeUserInGroup($groupId, $member->id);

			echo "Remove $memberIndex / " . count($groupMembers->apiresult->members) . "\n";

			if (($index++ % $numberOfOperationsForSleeping) == 0) {
				sleep(1);
			}
		}
	}
	
	// Add
/*	
	foreach($usernames as $memberIndex => $username) {
		$answer = $discourseApi->addUsersInGroup($groupLabel, array($username));
 		if (($index++ % $numberOfOperationsForSleeping) == 0) {
 			sleep(1);
 			echo "Adding $memberIndex / " . count($usernames) . "\n";
 		}
	}
*/
	if (count($toAdd)) {
		$answer = $discourseApi->addUsersInGroup($groupLabel, $toAdd);
		print_r($answer);
	}

	echo $groupLabel . " => " . count($usernames) . " users \n";
}

?>
