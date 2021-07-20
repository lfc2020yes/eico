<?
//

$query_string.='<div class="input-block-2020">';


$result_uu = mysql_time_query($link, '
select distinct b.id 
from z_invoice_material as a,
     z_invoice as b
where a.id_invoice=b.id and
b.status=3 and 
      a.id_acc="'.ht($id).'"
');

$num_results_uu = $result_uu->num_rows;

if ($num_results_uu != 0) {
    $invoice = '';
    while ($row_uu = mysqli_fetch_assoc($result_uu)) {


        $result_uu2 = mysql_time_query($link, 'select b.number,b.date,b.id_user,f.name,f.units,a.count_units,a.defect,a.count_defect from z_invoice as b,z_invoice_material as a,z_stock as f where f.id=a.id_stock and a.id_invoice=b.id and a.id_acc="'.ht($id).'" and b.id="' . ht($row_uu['id']) . '"');
        $num_results_uu2 = $result_uu2->num_rows;

        if ($num_results_uu2 != 0) {
            $row_uu2 = mysqli_fetch_assoc($result_uu2);

            $name_kto='';
            $result_uu4 = mysql_time_query($link, 'select name_user from r_user where id="' . ht($row_uu2["id_user"]) . '"');
            $num_results_uu4 = $result_uu4->num_rows;

            if ($num_results_uu4 != 0) {
                $row_uu4 = mysqli_fetch_assoc($result_uu4);
                $name_kto=$row_uu4["name_user"];
            }

            $query_string .= '<div class="state-invoice"> <div class="st-state"></div>             
               <div class="st-task"><span class="label-task-gg ">накладная</span>';
if($invoice==$row_uu["id"])
{
    $query_string .= '→';
} else {
    $query_string .= '<a class="link-acc-2021" href="invoice/' . $row_uu["id"] . '/">№' . $row_uu2["number"] . '</a>';
}

            $invoice=$row_uu["id"];

            $query_string .= '<div class="pass_wh_trips" style="margin-top: 10px;"><label>Принял</label><div class="obi">'.$name_kto.'</div></div></div>
               <div class="st-kto"><span class="label-task-gg ">Материал
</span><span class="send_mess" sm="35">'.$row_uu2["name"].'</span></div>
               <div class="st-srok"><span class="label-task-gg ">Количество
        </span><div class="obi-x">'.$row_uu2["count_units"].'</div> '.$row_uu2["units"].'</div>
               <div class="st-date"><span class="label-task-gg ">Брак
        </span>';
if($row_uu2["defect"]==1)
{
    $query_string .='<div class="obi-x">'.$row_uu2["count_defect"].'</div> '.$row_uu2["units"];
} else
{
    $query_string .='—';
}

            $query_string .= '</div>
            </div>';
        }
    }
} else
{
    $query_string.='<div class="help_div da_book1"><div class="not_boolingh"></div><span class="h5"><span>Накладные не найдены</span></span></div>';
}



$query_string.='</div>';
