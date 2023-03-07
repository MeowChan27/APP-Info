<!--******************************************************
* APP - Projet Système Numérique - Composante Informatique
* ISEP - A1 - G7C
* Semestre 2
* Auteur : - MAILLEY_Charles 
           - MAIZA_Fares
           - MARTINEZ_Eliot
           - PAVIOT-ADET_Flore
           - SPASOJEVIC_Fanny
           - VINGADASSAMY_Prasanaa
* Date de rendu  : 05/06/2023
********************************************************-->

<?php 
    // On get la langue de la page : defaut="fr"
    $lang = isset($_GET['lang']) ? $_GET['lang'] : 'fr';

    // Vérifie si le fichier de langue existe pour le charger en mémoire
    if (file_exists('lang/text_' . $lang . '.json')) {
        $translat = json_decode(file_get_contents('lang/text_' . $lang . '.json'), true);
    } // Redirection vers une page d'erreur
    else {header("Location: error.php"); exit;}
?>



<header class="header_all">
    <div class="header_left">
        <a class="header_title" href="mainType.html">
            <img class="header_logo" src="img/Logo_Appea-grey.svg" alt="Logo APPNEA">
            <?php echo $translat['title_brand']; ?>
        </a>
        <nav class="header_language"> 
            <?php echo '<img class="header_flag" src="vendors/icon-flag/'.$lang.'.svg">'; ?>
            <ul class="header_listFlag">
                <li><a href="?lang=fr"><img class="header_flag" src="vendors/icon-flag/fr.svg" alt="Francais"></a></li> 
                <li><a href="?lang=us" ><img class="header_flag" src="vendors/icon-flag/us.svg" alt="English"></a></li> 
            </ul> 
        </nav>
    </div>
    <ul class="header_right">
        <li><a href=""><?php echo $translat['header_link1']; ?></a></li>
        <li><a href=""><?php echo $translat['header_link2']; ?></a></li>
        <li><a href=""><?php echo $translat['header_link3']; ?></a></li>
        <li><a href=""><?php echo $translat['header_link4']; ?></a></li>
        <li class="header_log"><a href= ""><?php echo $translat['header_linkConn']; ?></a></li>
    </ul>
</header>
        
