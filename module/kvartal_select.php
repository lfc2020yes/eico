<?php
$user_select_kvartal=0;
if(count($hie_kvartal)>1)
{
    if(( isset($_COOKIE["cc_town".$id_user]))and($_COOKIE["cc_town".$id_user]!='')and(is_numeric(trim($_COOKIE["cc_town".$id_user])))) {
        if (in_array($_COOKIE["cc_town" . $id_user], $hie_kvartal)) {

            $user_select_kvartal=$_COOKIE["cc_town".$id_user];
        }
    }

    if($user_select_kvartal==0)
    {
        $user_select_kvartal=$hie_kvartal[0];
    }

} else
{
    if(count($hie_kvartal)!=0)
    {
        $user_select_kvartal=$hie_kvartal[0];
    }

}
$result_uu_kva = mysql_time_query($link, 'select kvartal from i_kvartal where id="' . ht($user_select_kvartal) . '"');
$num_results_uu_kva = $result_uu_kva->num_rows;

if ($num_results_uu_kva != 0) {
    $row_uu_kva = mysqli_fetch_assoc($result_uu_kva);
    $user_select_kvartal_name=$row_uu_kva["kvartal"];
}
?>