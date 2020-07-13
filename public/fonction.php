<?php
function prenom($chaine){
            $n='';
            for ($i=0;(isset($chaine[$i])) ; $i++) {
                if($i<2){
                    $n.=$chaine[$i];
                }
            }
            return $n;
}

//php cette fonction permet de determiner la longueur d'une chaine.
function nmbr_carac_ch($chaine){
    $n=0;
    for ($i=0;(isset($chaine[$i])) ; $i++) { 
        $n=$n+1;
    }
    return $n;
}

function Nom($chaine){
    $nmbre=nmbr_carac_ch($chaine);
    $n='';
    for ($i=0;$i<$nmbre ; $i++) {
        if($i>$nmbre-3){
            $n.=$chaine[$i];
        }
    }
    return $n;
}