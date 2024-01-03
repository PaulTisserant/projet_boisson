<?php 
include "fonctions.php" ;
if(verifConn()){
    echo ' Bonjour ' . $_SESSION['login'] ;
}
else{
    echo 'Bonjour Visiteur ' ;
}



?>