



<div class="menu-09  input-line" style="z-index:150;">
    <!--<div class="menu-09 no-fixed-mobile input-line" style="z-index:150;">-->
    <div class="menu-09-left">
        <a href="/" class="menu-09-global"></a><a onclick="history.back();" class="menu-09-prev"><i></i></a>

        <?
        $id=0;
        $echo='';
        echo'<div rel_tabs="0" id="tabs2017">';
        if($sign_admin!=1)
        {
            $result_t=mysql_time_query($link,'Select a.id,a.town from i_town as a where a.id in ('.implode(',',$hie->id_town).') order by a.id');
        } else
        {
            $result_t=mysql_time_query($link,'Select a.id,a.town from i_town as a order by a.id');
        }
        $num_results_t = $result_t->num_rows;
        if($num_results_t!=0)
        {
            echo'<ul class="tabs_hed">';
            for ($ks=0; $ks<$num_results_t; $ks++)
            {
                $row__ = mysqli_fetch_assoc($result_t);
                //echo'<li><a href="#tabs-'.$ks.'">'.$row__["year"].'</a></li>';
                if($ks==0)
                {
                    echo'<li class="tab active"><a id="'.$row__["id"].'" href="#prime-'.$row__["id"].'" class="active">'.$row__["town"].'</a></li>';
                    $id=$row__["id"];
                } else
                {
                    echo'<li class="tab"><a  id="'.$row__["id"].'" href="#prime-'.$row__["id"].'">'.$row__["town"].'</a></li>';
                }

                $echo.='<div  id="tabs_0-'.$row__["id"].'" class="tb">';
                if($sign_admin!=1)
                {
                    $result_t1=mysql_time_query($link,'Select a.* from i_kvartal as a where a.id_town="'.$row__["id"].'" and  a.id in ('.implode(',',$hie->id_kvartal).') order by a.id');
                } else
                {
                    $result_t1=mysql_time_query($link,'Select a.* from i_kvartal as a where a.id_town="'.$row__["id"].'" order by a.id');
                }
                $num_results_t1 = $result_t1->num_rows;
                if($num_results_t1!=0)
                {

                    for ($kss=0; $kss<$num_results_t1; $kss++)
                    {
                        $row__1= mysqli_fetch_assoc($result_t1);
                        $echo.='<div kvartal="'.$row__1["id"].'" class="block_i active">';

                        $echo.='<div class="top_bl"><h2><span class="s_j">'.$row__1["kvartal"].'</span></h2></div>';
                        $echo.='<div class="rls">';
                        if($sign_admin!=1)
                        {
                            $result_t2=mysql_time_query($link,'Select a.* from i_object as a where a.id_kvartal="'.$row__1["id"].'" and  a.id in ('.implode(',',$hie->obj).') order by a.id');
                        } else
                        {
                            $result_t2=mysql_time_query($link,'Select a.* from i_object as a where a.id_kvartal="'.$row__1["id"].'" order by a.id');
                        }
                        $num_results_t2 = $result_t2->num_rows;
                        if($num_results_t2!=0)
                        {

                            $echo.='<table cellspacing="0"  cellpadding="0" border="0" id="table_freez_'.$ks.'_'.$kss.'" class="smeta"><thead>
		   <tr class="title_smeta">
		   <th class="t_1"></th>
		   <th class="t_2 no_padding_left_">Наименование объекта</th>
		   <th class="t_3">Площать (м2)</th>';
                            if(array_search('total_r0',$stack_td) === false)
                            {
                                $echo.='<th class="t_8">итого работа</th>
		    <th class="t_9">итого материал</th>
		    <th class="t_10">итого всего</th>';
                            }
                            if(array_search('total_r0_realiz',$stack_td) === false)
                            {
                                $echo.='<th class="t_10">Выполнено работы на сумму</th>
		    <th class="t_10">Остаток по смете</th>';
                            }
                            $echo.='</tr></thead><tbody>';
                            for ($ksss=0; $ksss<$num_results_t2; $ksss++)
                            {
                                $row__2= mysqli_fetch_assoc($result_t2);
                                $proc_realiz=0;
                                if($row__2["total_r0"]!=0)
                                {
                                    $proc_realiz=round(($row__2["total_r0_realiz"]*100)/$row__2["total_r0"]);
                                }
                                if($proc_realiz>100)
                                {
                                    $proc_realiz=100;
                                }

                                $echo.='<tr class="loader_tr"><td colspan="'.$count_rows.'"><div class="loaderr"><div class="teps" rel_w="'. $proc_realiz.'" style="width:0%"><div class="peg_div"><div><i class="peg"></i></div></div></div></div></td></tr>';


                                $echo.='<tr class=" n1n" rel_id="'.$row__2["id"].'"><td class="middle_"></td>
                  <td class="no_padding_left_ pre-wrap"><a class="musa" href="prime/'.$row__2["id"].'/"><span class="s_j">'.$row__2["object_name"].'</span></a></td>
<td class="pre-wrap">';

                                $echo.=$row__2["object_area"].' м2';

                                $echo.='</td>';

                                if(array_search('total_r0',$stack_td) === false)
                                {
                                    $echo.='<td><span class="s_j">'.rtrim(rtrim(number_format($row__2["total_r0"], 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format($row__2["total_m0"], 2, '.', ' '),'0'),'.').'</span></td>
<td><span class="s_j">'.rtrim(rtrim(number_format(($row__2["total_r0"]+$row__2["total_m0"]), 2, '.', ' '),'0'),'.').'</span></td>';
                                }
                                if(array_search('total_r0_realiz',$stack_td) === false)
                                {
                                    $echo.='<td><span class="s_j">
'.mor_class(($row__2["total_r0"]-$row__2["total_r0_realiz"]),rtrim(rtrim(number_format($row__2["total_r0_realiz"], 2, '.', ' '),'0'),'.'),0).'</span></td>

<td><strong><span class="s_j">'.mor_class(($row__2["total_r0"]-$row__2["total_r0_realiz"]),rtrim(rtrim(number_format(($row__2["total_r0"]-$row__2["total_r0_realiz"]), 2, '.', ' '),'0'),'.'),1).'</span></strong></td>';
                                }

                                $echo.='</tr>';



                            }
                            $echo.='</tbody></table>';
                            $echo.='<script>
				  OLD(document).ready(function(){  OLD("#table_freez_'.$ks.'_'.$kss.'").freezeHeader({\'offset\' : \'59px\'}); });
				  </script>';

                        }
                        $echo.='</div>';
                        $echo.='</div>';

                    }

                } else
                {

                    $echo.='<div class="block_i active">';

                    $echo.='<div class="top_bl"><h2>По этому городу не найдено объектов</h2></div></div>';

                }
                $echo.='</div>';



            }
            echo'<div class="slider"></div>';
            echo'</ul>';
        }

        echo'</div>';

        ?>

    </div>
    <div class="menu-09-right tours-right-block">
        <?



        include_once $url_system.'module/notification.php';
        include_once $url_system.'module/users.php';

        echo'</div>';




        ?>

        <!--<div class="inline_reload js-reload-top"><a href="task/" class="show_reload ">Применить</a></div> -->

    </div>
