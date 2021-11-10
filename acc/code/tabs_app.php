<?
//

$query_string.='<div class="input-block-2020">';


$result_uu = mysql_time_query($link, '
Select distinct c.id,c.* from z_doc_material_acc as a,z_doc_material as b,z_doc as c where a.id_doc_material=b.id and b.id_doc=c.id and a.id_acc="'.ht($id).'" order by a.id
');


$num_results_uu = $result_uu->num_rows;

if ($num_results_uu != 0) {
    $invoice = '';
    while ($row_uu = mysqli_fetch_assoc($result_uu)) {


                $name_kto = '';
                $result_uu4 = mysql_time_query($link, 'select name_user from r_user where id="' . ht($row_uu["id_user"]) . '"');
                $num_results_uu4 = $result_uu4->num_rows;

                if ($num_results_uu4 != 0) {
                    $row_uu4 = mysqli_fetch_assoc($result_uu4);
                    $name_kto = $row_uu4["name_user"];
                }



                $query_string .= '<div class="state-invoice"> <div class="st-state"></div>            
<div class="trips-b-number"><div style="width: 100%;">'.$row_uu["id"].'</div></div> 
               <div class="st-task" style="width: 50%"><span class="label-task-gg ">Заявка</span>';

                    $query_string .= '<a class="link-acc-2021" href="app/'.$row_uu["id"].'/">№'.$row_uu["number"].' '.$row_uu["name"].'</a>';



$query_string .= '</div>
<div class="st-task" style="width: 50%">';
        $query_string .= '<span class="label-task-gg ">Создал</span><div class="pass_wh_trips" style="margin-top: 0px;"><div class="obi" style="padding-top: 0px;">' . $name_kto . '</div></div>';
        $query_string .= '</div>


               
            </div>';
            }
        }
     else
{
    $query_string.='<div class="help_div da_book1"><div class="not_boolingh"></div><span class="h5"><span>Связанные со счетом заявки не найдены</span></span></div>';
}



$query_string.='</div>';
