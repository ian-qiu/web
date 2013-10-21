<?php
define('ROOT_DIR', dirname(__FILE__) . '/');
include_once ROOT_DIR . 'phpexcel/Classes/PHPExcel.php';
include_once ROOT_DIR . 'phpexcel/Classes/PHPExcel/IOFactory.php';

function get_data_from_excel($file,$max_column){
	$objPHPExcel = PHPExcel_IOFactory::load($file);

	$sheet = $objPHPExcel->getSheet(0);
	$rows = $sheet->getRowIterator();

	$row_list = array();
	while ($rows->valid()){
		$row = $rows->current();
		$cells = $row->getCellIterator();
		$row_data = array();
		while ($cells->valid()){
			$cell = $cells->current();
			$cell_value = $cell->getValue();
			if ($cell_value instanceof PHPExcel_RichText_Run){
				$cell_value = $cell_value->getText();
			}else if ($cell_value instanceof PHPExcel_RichText){
				$cell_value = $cell_value->getPlainText();
			}
			$row_data[] = trim($cell_value);
			if ($cell->getColumn() == $max_column) {
				break;
			}
			$cells->next();
		}
		if (empty($row_data[0])) {
			break;
		}
		$rows->next();
		$row_list[] = $row_data;
	}
	$objPHPExcel->__destruct();
	return $row_list;
}

function write_data_to_url($file){
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getActiveSheet()->getCell("A1")->setValue("test");
	$url = new PHPExcel_Cell_Hyperlink('http://www.baidu.com/','baidu');
	$objPHPExcel->getActiveSheet()->getCell('B1')->setHyperlink($url);
	$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
	$color = new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_RED);
	$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setColor($color);
	$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
	$objPHPExcel->getActiveSheet()->getCell("B1")->setValue("http://www.baidu.com");
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
	$objWriter->save($file);
	$objPHPExcel->__destruct();
}

write_data_to_url('C:\Users\IanQiu\Desktop\test.xls');