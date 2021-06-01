<?php

//-----------------контроль заполненности данных перед сохранением
/*
 * обязательно должна быть заполненна дата документа
 * 
 * подсветить после сохранения пустые поля
 * принимающий
 * кол-во 0 или пусто
 */
function POST_control(&$stack_error,&$stack_warn) {

    $stack_error = array();
    $stack_warn = array();
    //=================================дата документа
    if (! ( isset($_POST['date_akt']) && $_POST['date_akt']>0 ))
       //Set_WARN('date_hidden_table',&$stack_error);
       $stack_error[]='date_table';
    //=================================Пользователь
    if ( ! ( isset($_POST['id1_user']) && $_POST['id1_user']>0 )) 
       //Set_WARN('id1_user',&$stack_warn);
       $stack_warn[]='id1_user';

    //======================пройтись по количеству
    if ( isset($_POST['count_mat']) && $_POST['count_mat']>0 )
    for($p=0;$p<$_POST['count_mat'];$p++) {    //----------------переписать материалы
            $volC=$_POST['count_'.$p]; 
            if (!($volC>0))
                //Set_WARN('count_'.$p,&$stack_warn); 
                $stack_warn[]='edc'.$p;   //edc

    } 
}
