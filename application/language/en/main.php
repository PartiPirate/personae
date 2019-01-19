<?php /*
	Copyright 2014-2019 Cédric Levieux, Parti Pirate

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

$lang["date_format"] = "m/d/Y";
$lang["time_format"] = "H:iA";
$lang["datetime_format"] = "the {date} at {time}";

$lang["common_validate"] = "Validate";
$lang["common_delete"] = "Delete";
$lang["common_fork"] = "Fork";
$lang["common_reject"] = "Reject";
$lang["common_connect"] = "Connect";
$lang["common_ask_for_modification"] = "Ask modification";

$lang["language_fr"] = "French";
$lang["language_en"] = "English";
$lang["language_de"] = "German";

$lang["personae_title"] = "Personae";

$lang["menu_language"] = "Language : {language}";
$lang["menu_index"] = "Home";
$lang["menu_groups"] = "Groups";
$lang["menu_my_groups"] = "My groups";
$lang["menu_myprofile"] = "My profile";
$lang["menu_myrights"] = "My rights";
$lang["menu_mypreferences"] = "My preferences";
$lang["menu_myaccounts"] = "My accounts";
$lang["menu_logout"] = "Log out";
$lang["menu_login"] = "Log in";

$lang["login_title"] = "Log in";
$lang["login_loginInput"] = "Identifier";
$lang["login_passwordInput"] = "Password";
$lang["login_button"] = "Log in";
$lang["login_rememberMe"] = "Remember me";
$lang["register_link"] = "or sign in";
$lang["forgotten_link"] = "I forgot my password";

$lang["breadcrumb_index"] = "Home";
$lang["breadcrumb_groups"] = "Groups";
$lang["breadcrumb_my_groups"] = "My groups";
$lang["breadcrumb_group_administration"] = "Administration";
$lang["breadcrumb_theme_administration"] = "Administration";
$lang["breadcrumb_connect"] = "Log in";
$lang["breadcrumb_mypreferences"] = "My preferences";
$lang["breadcrumb_register"] = "Sign in";
$lang["breadcrumb_activation"] = "Activation";
$lang["breadcrumb_forgotten"] = "I forgot my password";
$lang["breadcrumb_about"] = "About";

$lang["index_guide"] = "<p>Personae allows you to liquidally manage the delegation of power through
various instances and groups of powers.</p>
<p>So you can define who can collect the powers, who can distribute it, how (liquid, draw, simple
reporting) and how long.</p>
<p>Today Personae relies on information from Galette, the member management tool, to retrieve members
and their distribution.</p>";
$lang["index_my_groups_button"] = "My groups";
$lang["index_my_profile_button"] = "My profile";
$lang["index_groups_button"] = "Groups";
$lang["index_connect_button"] = "Connect";
$lang["index_description"] = "Manager of groups and decision-making powers: by result, by draw, by liquid democracy";

$lang["mypreferences_guide"] = "Change my preferences.";
$lang["mypreferences_form_legend"] = "Configuration of your access";
$lang["mypreferences_form_passwordInput"] = "Password";
$lang["mypreferences_form_passwordPlaceholder"] = "the password of your connection";
$lang["mypreferences_form_oldInput"] = "Your current password";
$lang["mypreferences_form_oldPlaceholder"] = "Your current connection password";
$lang["mypreferences_form_confirmationInput"] = "Confirmation";
$lang["mypreferences_form_confirmationPlaceholder"] = "Confirm your new password";
$lang["mypreferences_form_languageInput"] = "Language";
$lang["mypreferences_form_mailInput"] = "Mail address";
$lang["mypreferences_validation_mail_empty"] = "The mail field can't be empty";
$lang["mypreferences_validation_mail_not_valid"] = "This mail is not a valid mail";
$lang["mypreferences_validation_mail_already_taken"] = "This mail is already taken";
$lang["mypreferences_style_legend"] = "Interface";
$lang["mypreferences_style_themeSelect"] = "Theme";
$lang["mypreferences_style_themeDefault"] = "Default theme";
$lang["mypreferences_style_themeSlate"] = "Slate";
$lang["mypreferences_save"] = "Save my preferences";

$lang["register_guide"] = "Welcome to the register page of Personae";
$lang["register_form_legend"] = "Configuration of your access";
$lang["register_form_loginInput"] = "Login";
$lang["register_form_loginHelp"] = "Preferably use your Twitter ID if you want to receive notifications on Twitter";
$lang["register_form_mailInput"] = "Mail address";
$lang["register_form_passwordInput"] = "Password";
$lang["register_form_passwordHelp"] = "Your password doesn't have to inevitably contain strange characters, but it should preferably be long and memorizable";
$lang["register_form_confirmationInput"] = "Password confirmation";
$lang["register_form_languageInput"] = "Language";
$lang["register_form_iamabot"] = "I'm a bot and i don't know how to uncheck a checkbox";
$lang["register_form_notificationInput"] = "Validation notification";
$lang["register_form_notification_none"] = "None";
$lang["register_form_notification_mail"] = "By mail";
$lang["register_form_notification_simpledm"] = "By simple DM";
$lang["register_form_notification_dm"] = "By multiple DM";
$lang["register_success_title"] = "Successful sign in";
$lang["register_success_information"] = "Your registration is done.
<br>You will soon receive a mail with a link to click letting you activate your account.";
$lang["register_mail_subject"] = "[OTB] Registration mail";
$lang["register_mail_content"] = "Hello {login},

It seems that you registered yourself on Personae. To confirm your registration, please click the link below :
{activationUrl}

The @Personae Team";
$lang["register_save"] = "Sign in";
$lang["register_validation_user_empty"] = "The user field can't be empty";
$lang["register_validation_user_already_taken"] = "This username is already taken";
$lang["register_validation_mail_empty"] = "The mail field can't be empty";
$lang["register_validation_mail_not_valid"] = "This mail is not a valid mail";
$lang["register_validation_mail_already_taken"] = "This mail is already taken";
$lang["register_validation_password_empty"] = "The password field can't be empty";

$lang["connect_guide"] = "Welcome on the Personae connection screen";
$lang["connect_form_legend"] = "Connection";
$lang["connect_form_loginInput"] = "Login";
$lang["connect_form_loginHelp"] = "Your login or email";
$lang["connect_form_passwordInput"] = "Password";
$lang["connect_form_passwordHelp"] = "Your password";

$lang["activation_guide"] = "Welcome on the activation screen of your user account";
$lang["activation_title"] = "Activation status";
$lang["activation_information_success"] = "The activation of your user account succeeded. You can now <a id=\"connectButton\" href=\"#\">sign-in</a> yourself.";
$lang["activation_information_danger"] = "The activation of your user account failed.";

$lang["forgotten_guide"] = "You forgot your password, welcome on the page that will let you recover your access";
$lang["forgotten_form_legend"] = "Access retrieving";
$lang["forgotten_form_mailInput"] = "Mail address";
$lang["forgotten_save"] = "Send me a mail !";
$lang["forgotten_success_title"] = "Recory in progress";
$lang["forgotten_success_information"] = "An email has been sent.<br>This email contains a new password. Be sure to change it as soon as possible.";
$lang["forgotten_mail_subject"] = "[PERSONAE] I Forgot my password";
$lang["forgotten_mail_content"] = "Hello,

It seems that you forgot your password on Personae. Your new password is {password} .
Please change it as soon as you are connected.

The @Personae Team";

$lang["success_theme_candidate"] = "Votre candidature a été mise à jour";
$lang["success_theme_voting"] = "Votre délégation de pouvoir a été mise à jour";
$lang["success_theme_theme"] = "Le thème a été mis à jour";
$lang["success_group_group"] = "Le groupe a été mis à jour";
$lang["error_cant_change_password"] = "The password change failed";
$lang["ok_operation_success"] = "Succeeded operation";

$lang["error_voting_cycling"] = "This delegation is not possible because you already receive his delegation";
$lang["error_max_delegations"] = "This delegation is not possible because the person already receiving enough delegations";

$lang["error_passwords_not_equal"] = "Your password and its confirmation are different";
$lang["error_cant_send_mail"] = "Personae can not send mail to your mail address";
$lang["error_cant_register"] = "Personae can not process your registration";
$lang["error_cant_delete_files"] = "Personae can not delete delete installation files";
$lang["error_cant_connect"] = "Impossible to connect to the database";
$lang["error_database_already_exists"] = "The database already exists";
$lang["error_database_dont_exist"] = "The database does not exist";
$lang["error_login_ban"] = "Your IP has been blocked for 10mn.";
$lang["error_login_bad"] = "Vérifier vos identifiants, l'identification a échouée.";

$lang["install_guide"] = "Welcome on the installation page of Personae.";
$lang["install_tabs_database"] = "Database";
$lang["install_tabs_mail"] = "Mail";
$lang["install_tabs_application"] = "Application";
$lang["install_tabs_final"] = "Finalization";
$lang["install_tabs_license"] = "License";
$lang["install_database_form_legend"] = "Database access configuration";
$lang["install_database_hostInput"] = "Host";
$lang["install_database_hostPlaceholder"] = "database server host";
$lang["install_database_portInput"] = "Port";
$lang["install_database_portPlaceholder"] = "database server port";
$lang["install_database_loginInput"] = "Login";
$lang["install_database_loginPlaceholder"] = "Connection identifier";
$lang["install_database_loginHelp"] = "<em>Root</em> is avoided";
$lang["install_database_passwordInput"] = "Password";
$lang["install_database_passwordPlaceholder"] = "Connection password";
$lang["install_database_databaseInput"] = "Database";
$lang["install_database_databasePlaceholder"] = "database name";
$lang["install_database_operations"] = "Operations";
$lang["install_database_saveButton"] = "Save configuration";
$lang["install_database_pingButton"] = "Ping";
$lang["install_database_createButton"] = "Create";
$lang["install_database_deployButton"] = "Deploy";
$lang["install_mail_form_legend"] = "Mail access configuration";
$lang["install_mail_hostInput"] = "Host";
$lang["install_mail_hostPlaceholder"] = "Mail server host";
$lang["install_mail_portInput"] = "Port";
$lang["install_mail_portPlaceholder"] = "Mail server port";
$lang["install_mail_usernameInput"] = "Username";
$lang["install_mail_usernamePlaceholder"] = "Connection identifier";
$lang["install_mail_passwordInput"] = "Password";
$lang["install_mail_passwordPlaceholder"] = "Connection password";
$lang["install_mail_fromMailInput"] = "Sender address";
$lang["install_mail_fromMailPlaceholder"] = "Sender address";
$lang["install_mail_fromNameInput"] = "Sender name";
$lang["install_mail_fromNamePlaceholder"] = "sender name";
$lang["install_mail_testMailInput"] = "Test address";
$lang["install_mail_testMailPlaceholder"] = "not saved";
$lang["install_mail_operation"] = "Operations";
$lang["install_mail_saveButton"] = "Save configuration";
$lang["install_mail_pingButton"] = "Ping";
$lang["install_application_form_legend"] = "Application url";
$lang["install_application_baseUrlInput"] = "Application base url";
$lang["install_application_cronEnabledInput"] = "Allow sending deferred tweet";
$lang["install_application_cronEnabledHelp"] = "Please add in your cron table the following command <pre>* * * * * cd {path} && php do_cron.php</pre>";
$lang["install_application_saltInput"] = "Salt";
$lang["install_application_saltPlaceholder"] = "Application salt for ciphering and hashing";
$lang["install_application_defaultLanguageInput"] = "Default language";
$lang["install_application_operation"] = "Operations";
$lang["install_application_saveButton"] = "Save configuration";
$lang["install_autodestruct_guide"] = "You have tested everything, everything configured ? Then clicking <em>autodestruction</em> to remove this installer.";
$lang["install_autodestruct"] = "Autodestruction";

$lang["skill_level_concepts"] = "Notions";
$lang["skill_level_average"] = "Average";
$lang["skill_level_good"] = "Good";
$lang["skill_level_advanced"] = "Advanced";
$lang["skill_level_expert"] = "Expert";

$lang["about_footer"] = "About";
$lang["personae_footer"] = "<a href=\"https://www.personae.net/\" target=\"_blank\">Personae</a> is an application provided by <a href=\"https://www.partipirate.org\" target=\"_blank\">Parti Pirate</a>";
?>