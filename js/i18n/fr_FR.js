(function () {
	"use strict";
	angular.module('RbsChangeWebInstaller').run(['RbsChange.i18n', function (i18n) {
		i18n.setStrings({
			'installer-title' : "RBS Change - programme d'installation",
			'password' : "Mot de passe",
			'confirm-password' : "Confirmer le mot de passe",
			'continue' : "Continuer",
			'back' : "Retour",
			'bad' : "mauvais",
			'medium' : "moyen",
			'good' : "bon",
			'very good' : "très bon",

			'welcome.message1' : "Bienvenue dans le processus d'installation de <a href=\"http://www.rbschange.fr\" target=\"_blank\">RBS Change</a>,<br/>le <strong>CMS E-commerce open source</strong> !",
			'welcome.message2' : "Toute l'équipe de RBS Change vous remercie chaleureusement d'avoir choisi sa plate-forme pour gérer votre site internet !",
			'welcome.message3' : "Commençons l'installation de votre futur site internet sans plus attendre !",
			'welcome.start' : "Commencer",

			'check.title' : "Vérification du système",
			'check.checking' : "RBS Change vérifie la configuration du serveur...",
			'check.great-news' : "Bonne nouvelle !",
			'check.server-is-ok' : "Votre serveur dispose de tous les éléments nécessaires à l'installation de RBS Change.",
			'check.bad-news' : "Oh non !",
			'check.server-is-not-ok' : "La configuration actuelle de votre serveur ne permet pas d'installer RBS Change.",

			'settings.title' : "Paramètres",
			'settings.website' : "Site web",
			'settings.website-help-text' : "<strong>Merci de bien vouloir indiquer l'URL d'accès à votre futur site internet.</strong><br/>Nous avons trouvé une URL possible et l'avons placée dans le champ de saisie correspondant. Vous pouvez changer cette valeur si vous savez ce que vous faites.",
			'settings.website-url' : "URL d'accès au site",
			'settings.website-document-root' : "<em>Document Root</em>",
			'settings.website-url-placeholder' : "URL d'accès au site",
			'settings.db' : "Base de données",
			'settings.db-help-text' : "<strong>Veuillez choisir le type de la base de données à utiliser pour votre site internet.</strong><br/>Les choix proposés ici dépendent de votre système et des extensions du moteur PHP qui sont installées.",
			'settings.db-host' : "Serveur MySQL",
			'settings.db-host-same-server' : "Même serveur",
			'settings.db-host-placeholder' : "Nom ou adresse IP du serveur MySQL",
			'settings.db-database' : "Base de données",
			'settings.db-database-placeholder' : "Nom de la base de données",
			'settings.db-type' : "Type de base de données",
			'settings.db-user' : "Utilisateur",
			'settings.db-user-placeholder' : "Utilisateur MySQL",
			'settings.db-password' : "Mot de passe",
			'settings.db-password-placeholder' : "Mot de passe MySQL",
			'settings.db-sqlite-default-file' : "Fichier par défaut",
			'settings.db-sqlite-file' : "Fichier SQLite",
			'settings.db-sqlite-file-help' : "Il est recommandé de ne pas mettre un chemin absolu, afin que le fichier soit placé dans le répertoire <strong>App</strong> de votre installation de Change.",
			'settings.db-port' : "Port",
			'settings.db-port-use-default' : "Port par défaut",
			'settings.admin' : "Compte administrateur Change",
			'settings.admin-help-text' : "<strong>RBS Change a besoin d'un minimum d'information pour la création du compte de l'administrateur.</strong><br/>Lors de votre première connexion à l'interface d'administration de Change, nous vous proposerons de compléter votre profil utilisateur, en saisissant votre nom et pourquoi pas un petit avatar sympa !",
			'settings.admin-email' : "Adresse e-mail",
			'settings.admin-password' : "Mot de passe",
			'settings.admin-email-placeholder' : "Adresse e-mail de l'administrateur"
		});
	}]);
})();