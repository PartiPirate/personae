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

$lang["date_format"] = "d/m/Y";
$lang["time_format"] = "H:i";
$lang["fulldate_format"] = "dddd DD/MM/YYYY";
$lang["datetime_format"] = "le {date} à {time}";

$lang["common_validate"] = "Valider";
$lang["common_delete"] = "Supprimer";
$lang["common_fork"] = "Copier";
$lang["common_reject"] = "Rejeter";
$lang["common_connect"] = "Connecter";
$lang["common_ask_for_modification"] = "Demander modification";

$lang["language_fr"] = "Français";
$lang["language_en"] = "Anglais";
$lang["language_de"] = "Allemand";

$lang["personae_title"] = "Personae";

$lang["menu_language"] = "Langue : {language}";
$lang["menu_index"] = "Accueil";
$lang["menu_groups"] = "Groupes";
$lang["menu_my_groups"] = "Mes groupes";
$lang["menu_myprofile"] = "Mon profil";
$lang["menu_myrights"] = "Mes droits";
$lang["menu_mypreferences"] = "Mes préférences";
$lang["menu_logout"] = "Se déconnecter";
$lang["menu_login"] = "Se connecter";

$lang["login_title"] = "Identifiez vous";
$lang["login_loginInput"] = "Identifiant";
$lang["login_passwordInput"] = "Mot de passe";
$lang["login_button"] = "Me connecter";
$lang["login_rememberMe"] = "Se souvenir de moi";
$lang["register_link"] = "ou m'enregistrer";
$lang["forgotten_link"] = "j'ai oublié mon mot de passe";

$lang["breadcrumb_index"] = "Accueil";
$lang["breadcrumb_groups"] = "Groupes";
$lang["breadcrumb_my_groups"] = "Mes groupes";
$lang["breadcrumb_group_administration"] = "Administration";
$lang["breadcrumb_theme_administration"] = "Administration";
$lang["breadcrumb_connect"] = "Se connecter";
$lang["breadcrumb_mypreferences"] = "Mes préférences";
$lang["breadcrumb_register"] = "Enregistrement";
$lang["breadcrumb_activation"] = "Activation";
$lang["breadcrumb_forgotten"] = "J'ai oublié mon mot de passe";
$lang["breadcrumb_about"] = "À Propos";

$lang["index_guide"] = "<p>Personae vous permet de gérer de manière liquide la délégation de pouvoir à travers
des instances et des groupes de pouvoirs variés.</p>
<p>Ainsi vous pouvez définir qui peut recueillir les pouvoirs, qui peut le distribuer, comment (liquide, tirage au sort, simple
report d'information) et dans quelle durée.</p>
<p>Aujourd'hui Personae s'appuie sur les informations de Galette, l'outil de gestion d'adhérents, pour retrouver les membres
et leur répartition.</p>";
$lang["index_my_groups_button"] = "Mes groupes";
$lang["index_my_profile_button"] = "Mon profil";
$lang["index_groups_button"] = "Les groupes";
$lang["index_connect_button"] = "Se connecter";
$lang["index_description"] = "Gestionnaire de groupes et de pouvoirs décisionnels : par résultat, par tirage au sort, par démocratie liquide";

$lang["groups_guide"] = "Cliquez sur un groupe pour en connaitre la composition et distribuer vos délégations.";

$lang["mypreferences_guide"] = "Changer mes préférences.";
$lang["mypreferences_form_legend"] = "Configuration de vos accès";
$lang["mypreferences_form_passwordInput"] = "Nouveau mot de passe";
$lang["mypreferences_form_passwordPlaceholder"] = "votre nouveau mot de passe de connexion";
$lang["mypreferences_form_oldInput"] = "Mot de passe actuel";
$lang["mypreferences_form_oldPlaceholder"] = "votre mot de passe de connexion actuel";
$lang["mypreferences_form_confirmationInput"] = "Confirmation";
$lang["mypreferences_form_confirmationPlaceholder"] = "confirmation de votre nouveau mot de passe";
$lang["mypreferences_form_languageInput"] = "Langage";
$lang["mypreferences_validation_mail_empty"] = "Le champ mail ne peut être vide";
$lang["mypreferences_validation_mail_not_valid"] = "Cette adresse mail n'est pas une adresse valide";
$lang["mypreferences_validation_mail_already_taken"] = "Cette adresse mail est déjà prise";
$lang["mypreferences_form_mailInput"] = "Adresse mail";
$lang["mypreferences_save"] = "Sauver mes préférences";
$lang["mypreferences_style_legend"] = "Interface";
$lang["mypreferences_style_themeSelect"] = "Thème";
$lang["mypreferences_style_themeDefault"] = "Thème par défaut";
$lang["mypreferences_style_themeSlate"] = "Slate";

$lang["register_guide"] = "Bienvenue sur la page d'enregistrement d'Personae";
$lang["register_form_legend"] = "Configuration de votre accès";
$lang["register_form_loginInput"] = "Identifiant";
$lang["register_form_loginHelp"] = "Utilisez de préférence votre identifiant Twitter si vous voulez recevoir des notifications sur Twitter";
$lang["register_form_mailInput"] = "Adresse mail";
$lang["register_form_passwordInput"] = "Mot de passe";
$lang["register_form_passwordHelp"] = "Votre mot de passe ne doit pas forcement contenir de caractères bizarres, mais doit de préférence être long et mémorisable";
$lang["register_form_confirmationInput"] = "Confirmation du mot de passe";
$lang["register_form_languageInput"] = "Langage";
$lang["register_form_iamabot"] = "Je suis un robot et je ne sais pas décocher une case";
$lang["register_form_notificationInput"] = "Notification pour validation";
$lang["register_form_notification_none"] = "Aucune";
$lang["register_form_notification_mail"] = "Par mail";
$lang["register_form_notification_simpledm"] = "Par simple DM";
$lang["register_form_notification_dm"] = "DM multiple";
$lang["register_success_title"] = "Enregistrement réussi";
$lang["register_success_information"] = "Votre enregistrement a réussi.
<br>Vous allez recevoir un mail avec un lien à cliquer permettant l'activation de votre compte.";
$lang["register_mail_subject"] = "[OTB] Mail d'enregistrement";
$lang["register_mail_content"] = "Bonjour {login},

Il semblerait que vous vous soyez enregistré sur Personae. Pour confirmer votre enregistrement, veuillez cliquer sur le lien ci-dessous :
{activationUrl}

L'équipe @Personae";
$lang["register_save"] = "S'enregistrer";
$lang["register_validation_user_empty"] = "Le champ utilisateur ne peut être vide";
$lang["register_validation_user_already_taken"] = "Cet utilisateur est déjà pris";
$lang["register_validation_mail_empty"] = "Le champ mail ne peut être vide";
$lang["register_validation_mail_not_valid"] = "Cette adresse mail n'est pas une adresse valide";
$lang["register_validation_mail_already_taken"] = "Cette adresse mail est déjà prise";
$lang["register_validation_password_empty"] = "Le champ mot de passe ne peut être vide";

$lang["connect_guide"] = "Bienvenue sur l'écran de connexion de Personae";
$lang["connect_form_legend"] = "Connexion";
$lang["connect_form_loginInput"] = "Identifiant";
$lang["connect_form_loginHelp"] = "Votre identifiant Galette ou votre email";
$lang["connect_form_passwordInput"] = "Mot de passe";
$lang["connect_form_passwordHelp"] = "Votre mot de passe Galette";

$lang["activation_guide"] = "Bienvenue sur l'écran d'activation de votre compte";
$lang["activation_title"] = "Statut de votre activation";
$lang["activation_information_success"] = "L'activation de votre compte utilisateur a réussi. Vous pouvez maintenant vous <a id=\"connectButton\" href=\"#\">identifier</a>.";
$lang["activation_information_danger"] = "L'activation de votre compte utilisateur a échoué.";

$lang["forgotten_guide"] = "Vous avez oublié votre mot de passe, bienvenue sur la page qui vour permettra de récuperer un accès";
$lang["forgotten_form_legend"] = "Récupération d'accès";
$lang["forgotten_form_mailInput"] = "Adresse mail";
$lang["forgotten_save"] = "Envoyez moi un mail !";
$lang["forgotten_success_title"] = "Récupération en cours";
$lang["forgotten_success_information"] = "Un mail vous a été envoyé.<br>Ce mail contient un nouveau mot de passe. Veillez à le changer aussitôt que possible.";
$lang["forgotten_mail_subject"] = "[PERSONAE] J'ai oublié mon mot de passe";
$lang["forgotten_mail_content"] = "Bonjour,

Il semblerait que vous ayez oublié votre mot de passe sur Personae. Votre nouveau mot de passe est {password} .
Veuillez le changer aussitôt que vous serez connecté.

L'équipe @Personae";

$lang["success_theme_candidate"] = "Votre candidature a été mise à jour";
$lang["success_theme_voting"] = "Votre délégation de pouvoir a été mise à jour";
$lang["success_theme_theme"] = "Le thème a été mis à jour";
$lang["success_theme_fixation"] = "La fixation a été mise à jour";
$lang["success_group_group"] = "Le groupe a été mis à jour";
$lang["error_cant_change_password"] = "Le changement de mot de passe a échoué";
$lang["ok_operation_success"] = "Opération réussie";

$lang["error_voting_cycling"] = "Cette délégation n'est pas possible car vous recevez déjà sa délégation";
$lang["error_max_delegations"] = "Cette délégation n'est pas possible car la personne recevant déjà assez de délégations";

$lang["error_passwords_not_equal"] = "Votre mot de passe et sa confirmation sont différents";
$lang["error_cant_send_mail"] = "Personae n'arrive pas à envoyer de mail à votre adresse mail";
$lang["error_cant_register"] = "Personae n'arrive pas à traiter votre enregistrement";
$lang["error_cant_delete_files"] = "Personae n'arrive pas à supprimer les fichiers d'installation";
$lang["error_cant_connect"] = "Impossible de se connecter à la base de données";
$lang["error_database_already_exists"] = "La base de données existe déjà";
$lang["error_database_dont_exist"] = "La base de données n'existe pas";
$lang["error_login_ban"] = "Votre IP a été bloquée pour 10mn.";
$lang["error_login_bad"] = "Vérifier vos identifiants, l'identification a échouée.";

$lang["install_guide"] = "Bienvenue sur la page d'installation d'Personae.";
$lang["install_tabs_database"] = "Base de données";
$lang["install_tabs_mail"] = "Mail";
$lang["install_tabs_application"] = "Application";
$lang["install_tabs_final"] = "Finalisation";
$lang["install_tabs_license"] = "Licence";
$lang["install_database_form_legend"] = "Configuration des accès base de données";
$lang["install_database_hostInput"] = "Hôte";
$lang["install_database_hostPlaceholder"] = "l'adresse du serveur de base de données";
$lang["install_database_portInput"] = "Port";
$lang["install_database_portPlaceholder"] = "le port du serveur de base de données";
$lang["install_database_loginInput"] = "Identifiant";
$lang["install_database_loginPlaceholder"] = "l'identifiant de connexion";
$lang["install_database_loginHelp"] = "On évite l'utilisateur <em>root</em>";
$lang["install_database_passwordInput"] = "Mot de passe";
$lang["install_database_passwordPlaceholder"] = "le mot de passe de connexion";
$lang["install_database_databaseInput"] = "Base de données";
$lang["install_database_databasePlaceholder"] = "nom de la base de données";
$lang["install_database_operations"] = "Opérations";
$lang["install_database_saveButton"] = "Sauver la configuration";
$lang["install_database_pingButton"] = "Ping";
$lang["install_database_createButton"] = "Créer";
$lang["install_database_deployButton"] = "Déployer";
$lang["install_mail_form_legend"] = "Configuration des accès mail";
$lang["install_mail_hostInput"] = "Hôte";
$lang["install_mail_hostPlaceholder"] = "l'adresse du serveur de mail";
$lang["install_mail_portInput"] = "Port";
$lang["install_mail_portPlaceholder"] = "le port du serveur de mail";
$lang["install_mail_usernameInput"] = "Nom Utilisateur";
$lang["install_mail_usernamePlaceholder"] = "l'identifiant de connexion";
$lang["install_mail_passwordInput"] = "Mot de passe";
$lang["install_mail_passwordPlaceholder"] = "le mot de passe de connexion";
$lang["install_mail_fromMailInput"] = "Adresse émettrice";
$lang["install_mail_fromMailPlaceholder"] = "l'adresse d'émission";
$lang["install_mail_fromNameInput"] = "Nom émetteur";
$lang["install_mail_fromNamePlaceholder"] = "le nom de l'émetteur";
$lang["install_mail_testMailInput"] = "Adresse de test";
$lang["install_mail_testMailPlaceholder"] = "non sauvegardée";
$lang["install_mail_operation"] = "Opérations";
$lang["install_mail_saveButton"] = "Sauver la configuration";
$lang["install_mail_pingButton"] = "Ping";
$lang["install_application_form_legend"] = "Configuration de l'application";
$lang["install_application_baseUrlInput"] = "Url de base de l'application";
$lang["install_application_cronEnabledInput"] = "Autoriser l'envoi de tweet de manière différée";
$lang["install_application_cronEnabledHelp"] = "Veuillez rajouter dans votre table cron la commande <pre>* * * * * cd {path} && php do_cron.php</pre>";
$lang["install_application_saltInput"] = "Sel";
$lang["install_application_saltPlaceholder"] = "sel de l'application pour chiffrement et hachage";
$lang["install_application_defaultLanguageInput"] = "Langue par défaut";
$lang["install_application_operation"] = "Opérations";
$lang["install_application_saveButton"] = "Sauver la configuration";
$lang["install_autodestruct_guide"] = "Vous avez tout testé, tout configuré ? Alors un clic sur <em>autodestruction</em> pour supprimer cet installateur.";
$lang["install_autodestruct"] = "Autodestruction";

$lang["skill_level_concepts"] = "Notions";
$lang["skill_level_average"] = "Niveau moyen";
$lang["skill_level_good"] = "Bon niveau";
$lang["skill_level_advanced"] = "Avancé";
$lang["skill_level_expert"] = "Expert";

$lang["about_footer"] = "À Propos";
$lang["personae_footer"] = "<a href=\"https://www.personae.net/\" target=\"_blank\">Personae</a> est une application fournie par <a href=\"https://www.partipirate.org\" target=\"_blank\">le Parti Pirate</a>";
?>