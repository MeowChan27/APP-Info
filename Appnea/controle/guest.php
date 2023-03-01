<?php

/**
 * Affiche la page d'accueil
 */
function accueil(){
	require("./vue/accueil.tpl");
}


/**
 * Inscription
 */
function inscription(){
    $nom = isset($_POST['nom'])?($_POST['nom']):'';
    $mdp = isset($_POST['mdp'])?($_POST['mdp']):'';
    $mail = isset($_POST['mail'])?($_POST['mail']):'';
    $prenom = isset($_POST['prenom'])?($_POST['prenom']):''; 
    $pseudo = isset($_POST['pseudo'])?($_POST['pseudo']):'';
    $nomE = isset($_POST['nomE'])?($_POST['nomE']):'';
    $adresse = isset($_POST['adresseE'])?($_POST['adresseE']):'';


    $msg='';

    $erreurDetec = false;

    require('./modele/visiteurBD.php');

    if ($nom == '' || $mdp == '' || $mail == '' || $pseudo == '' || verifInscription($mdp,$mail,$nom,$prenom,$pseudo)){
        require ("./vue/inscription.tpl");
    }
    else if  (verif_ident_bd($nom, $mdp)) {
        $msg ="On vous connaît déjà !";
        require("./vue/inscription.tpl");
        
    }
    else {
        new_Utilisateur($nom, $pseudo, $mail, $prenom, $mdp, $nomE, $adresse); 
        $_SESSION['profil']= array();
        $_SESSION['profil']['nom']= $nom;
        $_SESSION['profil']['id_client'] = getId($nom, $mdp);

        /* Faire les bidouilles de cookies */
        $cookie_nom = 'Cookie abonnement';
        $cookie_value = "$nom";
        setcookie($cookie_nom, $cookie_value, time() + (86400 * 30), "/");

        $url = "index.php?controle=entreprise&action=afficherFlotte";
		header ("Location:" .$url);
    }
}

/**
 * Connexion
 */
function connexion(){
    $id = isset($_POST['identifiant'])?($_POST['identifiant']):"";
    $mdp= isset($_POST['mdp'])?($_POST['mdp']):"";
    $msg='';

    if(COUNT($_POST) == 0){
        require("./vue/connexion.tpl");
    }
    else{
        require("./modele/visiteurBD.php");
        if(!verif_ident($id,$mdp) || !verif_ident_bd($id, $mdp, $resultat)){
			echo "<br> Veuillez saisir un idenfiant et/ou un mot de passe valide(s) !";
            $_SESSION['profil'] = array();
            require("./vue/connexion.tpl");
        }
        else{
            $_SESSION['profil'] = $resultat[0];

			if($_SESSION['profil']['admin'] == 0){
				$url="index.php?controle=admin&action=accueilAdmin";
            	header("Location:" . $url);
			}
			else if($_SESSION['profil']['modo']){
				$url="index.php?controle=moderateur&action=accueilModerateur";
				header("Location:" . $url);
			}
			else{
			    $url="index.php?controle=user&action=accueilUser";
			}
        }
    }
}

/**
 * Appelle le fichier tpl pour la connexion.
 */
function lanceConnexion(){
    require("./vue/connexion.tpl");
}
/**
 * Vérifie que l'id et le mot de passe correspondent bien aux regex (pour la connexion).
 */
function verif_ident($id, $mdp){
	if(verif_id($id) && verif_password($mdp)) return true;
	else return false;
}

/**
 * Vérifie que l'id soit conforme : 
 * il doit faire au minimum 2 et au maximum 49 caractères, il peut êter composé de majuscules, d'espaces, de chiffres, "-".
 * OU
 * doit correspondre à une adresse mail 
 */
function verif_id($id){
	if(preg_match("`^[A-Z][[:alnum:]\-[:space:]]{2,49}$`", $id) || preg_match("`^(.+)@(.+)\.(.+)$`", $id)){
		return true;
	}
	else{
		echo "Identifiant non valide";
		return false;
	}
}

/**
 * Le mot de passe doit faire au minimum 3 caractères, au maximum 20.
 */
function verif_password($mdp){
	if(preg_match("`^[[[:alnum:]\-[:space:]]|[~]]{3,20}$`", $mdp))
		return true;
	else{
		echo "Mot de passe non valide";
		return false;
	}
}
/**
 * Vérifie que tous les champs soient bons.
 */
function verifInscription($mdp, $mail, $nom, $prnom, $pseudo){
    return verif_password($mdp) && verifMail($mail) && verifNom($nom) && verifNom($prenom) && verifPseudo($pseudo);
}

/**
 * Déconnecte un utilisateur connecté
 */
function deconnexion(){
	session_unset();
	$url = "index.php?controle=guest&action=accueil";
	header("Location: " . $url);
}

?>