<?php

$font0=array(
	'name'      	=> 'Arial',
	'size'     	=> 8,
	'bold'      	=> true,
	'italic'    	=> false,
	'underline' 	=> PHPExcel_Style_Font::UNDERLINE_NONE,
	'strike'    	=> false,
	'superScript' 	=> false,
	'subScript' 	=> false,
	'color'     	=> array('rgb' => '808080')
        );   
 $font=array(
	'name'      	=> 'Arial',
	'size'     	=> 12,
	'bold'      	=> true,
	'italic'    	=> false,
	'underline' 	=> PHPExcel_Style_Font::UNDERLINE_NONE,
	'strike'    	=> false,
	'superScript' 	=> false,
	'subScript' 	=> false,
	'color'     	=> array('rgb' => '000000' )
        );
 $fontN=array(
	'name'      	=> 'Arial',
	'size'     	=> 12,
	'bold'      	=> false,
	'italic'    	=> false,
	'underline' 	=> PHPExcel_Style_Font::UNDERLINE_NONE,
	'strike'    	=> false,
	'superScript' 	=> false,
	'subScript' 	=> false,
	'color'     	=> array('rgb' => '000000' )
        );
 $fontNB=array(
	'name'      	=> 'Arial',
	'size'     	=> 12,
	'bold'      	=> true,
	'italic'    	=> false,
	'underline' 	=> PHPExcel_Style_Font::UNDERLINE_NONE,
	'strike'    	=> false,
	'superScript' 	=> false,
	'subScript' 	=> false,
	'color'     	=> array('rgb' => '000000' )
        );
$fontI=array(
	'name'      	=> 'Arial',
	'size'     	=> 12,
	'bold'      	=> false,
	'italic'    	=> true,
	'underline' 	=> PHPExcel_Style_Font::UNDERLINE_NONE,
	'strike'    	=> false,
	'superScript' 	=> false,
	'subScript' 	=> false,
	'color'     	=> array('rgb' => '808080' )
        );
$fontA=array(
	'name'      	=> 'Arial',
	'size'     	=> 14,
	'bold'      	=> true,
	'italic'    	=> false,
	'underline' 	=> PHPExcel_Style_Font::UNDERLINE_NONE,
	'strike'    	=> false,
	'superScript' 	=> false,
	'subScript' 	=> false,
	'color'     	=> array('rgb' => 'FFFFFF' )
        );
$fontHi1=array(
	'name'      	=> 'Arial',
	'size'     	=> 20,
	'bold'      	=> true,
	'italic'    	=> false,
	'underline' 	=> PHPExcel_Style_Font::UNDERLINE_NONE,
	'strike'    	=> false,
	'superScript' 	=> false,
	'subScript' 	=> false,
	'color'     	=> array('rgb' => '000000')
        );  
$fontHi2I=array(
	'name'      	=> 'Arial',
	'size'     	=> 16,
	'bold'      	=> false,
	'italic'    	=> true,
	'underline' 	=> PHPExcel_Style_Font::UNDERLINE_NONE,
	'strike'    	=> false,
	'superScript' 	=> false,
	'subScript' 	=> false,
	'color'     	=> array('rgb' => '000000')
        ); 
$fontHi3B=array(
	'name'      	=> 'Arial',
	'size'     	=> 16,
	'bold'      	=> true,
	'italic'    	=> false,
	'underline' 	=> PHPExcel_Style_Font::UNDERLINE_NONE,
	'strike'    	=> false,
	'superScript' 	=> false,
	'subScript' 	=> false,
	'color'     	=> array('rgb' => '000000')
        );  
$border =  array(
       
	'bottom'     => array(
		'style' => PHPExcel_Style_Border::BORDER_THIN,
		'color' => array('rgb' => '080808')
	),
	'top'     => array(
		'style' => PHPExcel_Style_Border::BORDER_THIN,
		'color' => array('rgb' => '080808')
	),
       'left'     => array(
		'style' => PHPExcel_Style_Border::BORDER_THIN,
		'color' => array('rgb' => '080808')
	),
        'right'     => array(
		'style' => PHPExcel_Style_Border::BORDER_THIN,
		'color' => array('rgb' => '080808')
	) 
);  
$fill=array(
	'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	'rotation'   => 0,
	'startcolor' => array(
		'rgb' => 'ffffff'
	),
	'endcolor'   => array(
		'argb' => '888888'
	)
);
$fillRBlack=array(
	'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	'color'   => array(
		'rgb' => '888888'
	)
);
$fillI=array(
	'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	'rotation'   => 0,
	'startcolor' => array(
		'rgb' => 'ffffff'
	),
	'endcolor'   => array(
		'argb' => 'EEEEEE'
	)
	
);
$fillIItogo=array(
	'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	'color'   => array(
		'rgb' => 'EEEEEE'  //F3F3F3
	)
);
$fillA=array(
	'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	'rotation'   => 0,
	'startcolor' => array(
		'rgb' => 'FFFFFF'
	),
	'endcolor'   => array(
		'argb' => 'FF0000'
	)
	
);
$fillAItogo=array(
	'type'       => PHPExcel_Style_Fill::FILL_SOLID,
	'color'   => array(
		'rgb' =>'FF0000' 
	)
);

$align=array ('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
              'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'wrap'=> true
        
        );
$alignWR=array ('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
              'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'wrap'=> true
        );
$alignR=array ('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
              'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER
        
        );
?>
<style>
 .dd {   
 background:#ddd;
 }
</style> 
<?php 
$style0 = array(                   //Подзаголовок
	'font' => $font0,
	'alignment' => $align,
        'borders' => $border
);
$styleH = array(                   //Заголовок  
	'font' => $font,
	'alignment' => $align,
        'borders' => $border
);
$styleR = array(                   //Раздел
	'font' => $font,
	'fill' => $fill,
	'alignment' => $alignWR,
        'borders' => $border
);
$styleRBlack = array(                   //Раздел $fillRBlack
	//'font' => $font,
	'fill' => $fillRBlack,           
	//'alignment' => $alignWR,
        'borders' => $border
);
$styleW = array(                  //Работы полужирный
	'font' => $fontNB,
        'numberformat' => array('code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
	'alignment' => $alignWR,
        'borders' => $border
);
$styleWN = array(                   //Работы нормальный   
	'font' => $fontN,
	'alignment' => $align,
        'borders' => $border
);
$styleM = array(                     //Материалы
	'font' => $fontI,
	'alignment' => array ('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
        'borders' => $border
);
$styleI = array(                      //ИТОГО
	'font' => $font,
	'fill' => $fillI,
        'numberformat' => array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00),
	'alignment' => array ('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
        'borders' => $border
);
$styleNItogo = array(                        //Число
	'font' => $fontNB,
        'fill' => $fillIItogo,
        'numberformat' => array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00),
	'alignment' => array ('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
        'borders' => $border
);
$styleN = array(                        //Число
	'font' => $fontN,
        'numberformat' => array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00),
	'alignment' => array ('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
        'borders' => $border
);
$styleIText = array(                      //ИТОГО
	'font' => $font,
	'fill' => $fillIItogo,
	'alignment' => $alignWR,
        'borders' => $border
);
        
$styleA = array(                          //Всего число
	'font' => $fontA,
	'fill' => $fillAItogo,
        'numberformat' => array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1),
	'alignment' => $alignR,
        'borders' => $border
); 
$styleAText = array(                          //Всего число
	'font' => $fontA,
	'fill' => $fillAItogo,
	'alignment' => $align,
        'borders' => $border
);
$styleAS = array(                          //Всего строка
	'font' => $fontA,
	'fill' => $fillA,
        'numberformat' => array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1),
	'alignment' => $alignR,
        'borders' => $border
);

$styleHi1 = array(                   //============================Заголовок      
	'font' => $fontHi1,
	'alignment' => $align
);
$styleHiR = array(                   //Подписи       
	'font' => $fontHi2I,
	'alignment' => $alignR
);
        
$styleHiL = array(                    //текст   
	'font' => $fontHi3B,
	'alignment' => $alignWR
);
$styleHiRN = array(                   //Цифры    
	'font' => $fontHi3B,
        'numberformat' => array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1),
	'alignment' => $alignR
);       
//$style_r2 = array('style' =>PHPExcel_Style_Border::BORDER_DOUBLE,
//                  'color' => array('rgb' => '0000ff'));

$border2 =  array(
       
	'bottom'     => array(
		'style' => PHPExcel_Style_Border::BORDER_THICK,
		'color' => array('rgb' => 'bbbbbb')
	),
	'top'     => array(
		'style' => PHPExcel_Style_Border::BORDER_THICK,
		'color' => array('rgb' => 'bbbbbb')
	),
       'left'     => array(
		'style' => PHPExcel_Style_Border::BORDER_THICK,
		'color' => array('rgb' => 'bbbbbb')
	),
        'right'     => array(
		'style' => PHPExcel_Style_Border::BORDER_THICK,
		'color' => array('rgb' => 'bbbbbb')
	) 
    
);
$style_r2 = array('borders' => $border2);