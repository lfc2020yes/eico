<?php

$font0=array(
	'name'      	=> 'Arial',
	'size'     	=> 8,
	'bold'      	=> true,
	'italic'    	=> false,
	'underline' 	=> PHPExcel_Style_Font::UNDERLINE_NONE,
	'strike'    	=> false,
	'superScript' 	=> false,
	'subScript' 	=> true,
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
	'subScript' 	=> true,
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
	'subScript' 	=> true,
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
	'subScript' 	=> true,
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
	'subScript' 	=> true,
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
	'subScript' 	=> true,
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
	'subScript' 	=> true,
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
	'subScript' 	=> true,
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
	'subScript' 	=> true,
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

$align=array (
    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    'wrap'=> true,
    'indent'	=> 0,
    'shrinkToFit'	=> false,
        );
$alignWR=array (
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    'wrap'=> true,
    'indent'	=> 0,
    'shrinkToFit'	=> false,
        );
$alignR=array (
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    'indent'	=> 0,
    'shrinkToFit'	=> false,
        );
?>
<style>
 .dd {   
 background:#ddd;
 }
</style> 
<?php 
$style0 = array(                   //????????????????????????
	'font' => $font0,
	'alignment' => $align,
        'borders' => $border
);
$styleH = array(                   //??????????????????  
	'font' => $font,
	'alignment' => $align,
        'borders' => $border
);
$styleR = array(                   //????????????
	'font' => $font,
	'fill' => $fill,
	'alignment' => $alignWR,
        'borders' => $border
);
$styleRBlack = array(                   //???????????? $fillRBlack
	//'font' => $font,
	'fill' => $fillRBlack,           
	//'alignment' => $alignWR,
        'borders' => $border
);
$styleW = array(                  //???????????? ????????????????????
	'font' => $fontNB,
        'numberformat' => array('code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT),
	'alignment' => $alignWR,
        'borders' => $border
);
$styleWN = array(                   //???????????? ????????????????????   
	'font' => $fontN,
	'alignment' => $align,
        'borders' => $border
);
$styleM = array(                     //??????????????????
	'font' => $fontI,
	'alignment' => array ('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
        'borders' => $border
);
$styleI = array(                      //??????????
	'font' => $font,
	'fill' => $fillI,
        'numberformat' => array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00),
	'alignment' => array ('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
        'borders' => $border
);
$styleNItogo = array(                        //??????????
	'font' => $fontNB,
        'fill' => $fillIItogo,
        'numberformat' => array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00),
	'alignment' => array ('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
        'borders' => $border
);
$styleN = array(                        //??????????
	'font' => $fontN,
        'numberformat' => array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00),
	'alignment' => array ('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT),
        'borders' => $border
);
$styleIText = array(                      //??????????
	'font' => $font,
	'fill' => $fillIItogo,
	'alignment' => $alignWR,
        'borders' => $border
);
        
$styleA = array(                          //?????????? ??????????
	'font' => $fontA,
	'fill' => $fillAItogo,
        'numberformat' => array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1),
	'alignment' => $alignR,
        'borders' => $border
); 
$styleAText = array(                          //?????????? ??????????
	'font' => $fontA,
	'fill' => $fillAItogo,
	'alignment' => $align,
        'borders' => $border
);
$styleAS = array(                          //?????????? ????????????
	'font' => $fontA,
	'fill' => $fillA,
        'numberformat' => array('code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1),
	'alignment' => $alignR,
        'borders' => $border
);

$styleHi1 = array(                   //============================??????????????????      
	'font' => $fontHi1,
	'alignment' => $align
);
$styleHiR = array(                   //??????????????       
	'font' => $fontHi2I,
	'alignment' => $alignR
);
        
$styleHiL = array(                    //??????????   
	'font' => $fontHi3B,
	'alignment' => $alignWR
);
$styleHiRN = array(                   //??????????    
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