<?php

namespace App\Http\Controllers\PhpExcel;

use App\Model\StudentModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhpExcelController extends Controller
{
    //
    public function export(){
        $student = StudentModel::get()->toArray();
        var_dump($student);die;
        $cellData = [
            ['学号','姓名','成绩'],
            ['10001','AAAAA','99'],
            ['10002','BBBBB','92'],
            ['10003','CCCCC','95'],
            ['10004','DDDDD','89'],
            ['10005','EEEEE','96'],
        ];
        Excel::create('学生成绩',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }
}
