<?php

namespace App\Http\Controllers\Student;

use App\Model\StudentModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    /**
     * 展示所有信息
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $studentData = StudentModel::get();
        if(count($studentData)){
            $studentData = StudentModel::get()->toArray();
            return [
                'code' => 200,
                'msg' => 'success',
                'data' => $studentData,
            ];
        }else{
            return [
                'code' => 40002,
                'msg'  => '没有学生',
                'data' => []
            ];
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        echo __METHOD__;
    }

    /**
     * 添加
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input();
        $student_data = StudentModel::where([ 'username' => $data['username'] ])->first();
        if($student_data){
            return [
                'code' => 40000,
                'msg'  => '学生已存在',
                'data' => [],
            ];
        }else{
            $studentId = StudentModel::insertGetId($data);
            if($studentId){
                return [
                    'code' => 200,
                    'msg'  => 'success',
                    'data' => $studentId,
                ];
            }else{
                return [
                    'code' => 40001,
                    'msg'  => '学生添加失败请重新添加',
                    'data' => []
                ];
            }
        }
    }

    /**
     * 单独展示
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $studentCount = StudentModel::where(['id' => $id])->count();
        if($studentCount){
            $studentFirst = StudentModel::where(['id' => $id])->first()->toArray();
            return [
                'code' => 200,
                'msg' => 'success',
                'data' => $studentFirst,
            ];
        }else{
            return [
                'code' => 40003,
                'msg' => '没有找到该学生信息',
                'data' => [],
            ];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        echo __METHOD__;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->input();
        $student_update = StudentModel::where('id',$id)->update($data);
        if($student_update){
            return [
                'code' => 200,
                'msg' => 'success',
                'data' => $student_update
            ];
        }else{
            return [
                'code' => 40004,
                'msg' => '修改失败',
                'data' => [],
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $delete =  StudentModel::where('id',$id)->delete();
        if($delete){
            return [
                'code' => 200,
                'msg' => 'success',
                'data' => $delete,
            ];
        }else{
            return [
                'code' => 40003,
                'msg' => '学生删除失败',
                'data' => [],
            ];
        }
    }
}
