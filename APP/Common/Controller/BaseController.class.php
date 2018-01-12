<?php namespace Common\Controller;

use Think\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/29
 * Time: 11:55
 */
class BaseController extends Controller {
    public function __construct() {
        parent::__construct();
        if (method_exists($this, '__init')) {
            $this->__init();
        }
    }

    //保存数据
    public function store(Model $model, $data, \Closure $callback = null) {
        $res = $model->store($data);
        if ($res['status'] == 'success' && $callback instanceof \Closure) {
            $callback($res);
        } else {
            $this->message($res);
        }

    }

    //响应信息
    protected function message(array $data) {
        if ($data['status'] == 'success') {
            $this->success($data['message']);
        } else {
            $this->error($data['message']);
        }
        exit;
    }

    //分配菜单
    public function assignModuelMenu() {
        $nav_data=D('Nav')->getTree('level','order_number,id');
        $this->assign('nav_data',$nav_data);
    }

    /**
     * 导入excel方法
     * @param $file_name 导入的文件
     *
     * @return array
     */
    public function import_exl($file_name){
        Vendor("PHPExcel.PHPExcel");   // 这里不能漏掉
        Vendor("PHPExcel.PHPExcel.IOFactory");
        Vendor("PHPExcel.PHPExcel.Reader.Excel2007");
        $objReader =\PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumn = $sheet->getHighestColumn(); // 取得总列数

        $data=array();
        //从第二行开始读取数据
        for($j=2;$j<=$highestRow;$j++){
            //从A列读取数据
            for($k='A';$k<$highestColumn;$k++){
                // 读取单元格
                $data[$j][]=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
            }
        }
        return $data;
    }
    /**
     * 导出excel方法
     * @param array $data 需要导出的数据
     * @param array $title excel表头
     * @param string $excelFileName 导出后的文件名
     */
    public function export_exl ($data,$excelFileName,$title) {
        Vendor("PHPExcel.PHPExcel");
        $this->__construct();
        /* 实例化类 */
        $objPHPExcel = new \PHPExcel();
        /* 设置输出的excel文件为2007兼容格式 */
        //$objWriter=new PHPExcel_Writer_Excel5($objPHPExcel);//非2007格式
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);

        /* 设置当前的sheet */
        $objPHPExcel->setActiveSheetIndex(0);
        $objActSheet = $objPHPExcel->getActiveSheet();

        /* 设置表头 */
        $j = 'A';
        foreach($title as $v){
            $objActSheet->setCellValue($j.'1',$v);
            $j++;
        }

        /* excel文件内容 */
        $i = 2;
        foreach($data as $value){
            $j = 'A';
            foreach($value as $value2){
                //            $value2=iconv("gbk","utf-8",$value2);
                $objActSheet->setCellValue($j.$i,$value2);
                $j++;
            }
            $i++;
        }
        /* 生成到浏览器，提供下载 */
        ob_end_clean();  //清空缓存
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="'.$excelFileName.'.xlsx"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }

    /*
     * 二维码生成
     */
    public function qrcode($name,$url){
        Vendor("phpqrcode.phpqrcode");
        // 二维码数据
        $data = $url;
        // 生成的文件名
        $filename =$name;
        // 纠错级别：L、M、Q、H
        $errorCorrectionLevel = 'L';
        // 点的大小：1到10
        $matrixPointSize = 4;
        //创建一个二维码文件
        \QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    }

}