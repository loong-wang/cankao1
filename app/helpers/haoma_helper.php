<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//规律
function get_haoma_guilv($tit){
	if(substr(substr($tit,-6),0,1)==substr(substr($tit,-5),0,1) && substr(substr($tit,-5),0,1)==substr(substr($tit,-4),0,1) && substr(substr($tit,-3),0,1)==substr(substr($tit,-2),0,1) && substr(substr($tit,-2),0,1)==substr($tit,-1) && substr(substr($tit,-4),0,1)!=substr(substr($tit,-3),0,1)){
		$guilv="AAABBB";
	}elseif(substr(substr($tit,-4),0,1)==substr(substr($tit,-3),0,1) && substr(substr($tit,-3),0,1)==substr(substr($tit,-2),0,1) && substr(substr($tit,-2),0,1)==substr($tit,-1) && substr(substr($tit,-5),0,1)==substr(substr($tit,-4),0,1)){
		$guilv="AAAAA";
	}elseif(substr(substr($tit,-4),0,1)==substr(substr($tit,-3),0,1) && substr(substr($tit,-3),0,1)==substr(substr($tit,-2),0,1) && substr(substr($tit,-2),0,1)==substr($tit,-1) && substr(substr($tit,-5),0,1)!=substr(substr($tit,-4),0,1)){
		$guilv="AAAA";
	}elseif(substr(substr($tit,-3),0,1)==substr(substr($tit,-2),0,1) && substr(substr($tit,-2),0,1)==substr($tit,-1) && substr(substr($tit,-3),0,1)!=substr(substr($tit,-4),0,1)){
		$guilv="AAA";
	}elseif(substr($tit,-4)==1234 || substr($tit,-4)==2345 || substr($tit,-4)==3456 || substr($tit,-4)==4567 || substr($tit,-4)==5678 || substr($tit,-4)==6789 || substr($tit,-4)==4321 || substr($tit,-4)==5432 || substr($tit,-4)==6543 || substr($tit,-4)==7654 || substr($tit,-4)==8765 || substr($tit,-4)==9876){
		$guilv="升降序ABCD";
	}elseif(substr($tit,-3)==123 || substr($tit,-3)==234 || substr($tit,-3)==345 || substr($tit,-3)==456 || substr($tit,-3)==567 || substr($tit,-3)==678 || substr($tit,-3)==789 || substr($tit,-3)==321 || substr($tit,-3)==432 || substr($tit,-3)==543 || substr($tit,-3)==654 || substr($tit,-3)==765 || substr($tit,-3)==876 || substr($tit,-3)==987){
		$guilv="升降序ABC";
	}elseif(substr(substr($tit,-6),0,1)==substr(substr($tit,-5),0,1) && substr(substr($tit,-4),0,1)==substr(substr($tit,-3),0,1) && substr(substr($tit,-2),0,1)==substr($tit,-1) && substr(substr($tit,-5),0,1)!=substr(substr($tit,-4),0,1) && substr(substr($tit,-3),0,1)!=substr(substr($tit,-2),0,1)){
		$guilv="AABBCC";
	}elseif(substr(substr($tit,-6),0,1)==substr(substr($tit,-5),0,1) && substr(substr($tit,-5),0,1)==substr(substr($tit,-4),0,1) && substr(substr($tit,-3),0,1)==substr(substr($tit,-2),0,1) && substr(substr($tit,-2),0,1)==substr($tit,-1) && substr(substr($tit,-4),0,1)!=substr(substr($tit,-3),0,1)){
		$guilv="AAABBB";
	}elseif(substr(substr($tit,-4),0,2)==substr($tit,-2) && substr(substr($tit,-2),0,1)!=substr($tit,-1)){
		$guilv="ABAB";
	}elseif(substr(substr($tit,-4),0,1)==substr(substr($tit,-3),0,1) && substr(substr($tit,-2),0,1)==substr($tit,-1) && substr(substr($tit,-3),0,1)!=substr(substr($tit,-2),0,1)){
		$guilv="AABB";
	}elseif(substr(substr($tit,-3),0,1)==substr(substr($tit,-2),0,1) && substr(substr($tit,-4),0,1)==substr($tit,-1) && substr(substr($tit,-2),0,1)!=substr($tit,-1)){
		$guilv="ABBA";
	}else{
		$guilv="";
	}
	return $guilv;
}
//寓意
function get_haoma_yuyi($str){
    $num=intval(substr($str, 4))%80;
    return $num;
}

function get_haoma_shuwei($str,$num=5) {
    if(isset($str)){
        $arr=str_split($str); 
        $unique=array_unique($arr); 
        foreach ($unique as $a){ 
            $arr2[$a]=substr_count($str, $a); 
        } 
        arsort($arr2); 
            if(current($arr2)>$num){
                $hao=current(array_flip($arr2));
            }else{
                $hao=9999;
            }    
    }
    return $hao;
}