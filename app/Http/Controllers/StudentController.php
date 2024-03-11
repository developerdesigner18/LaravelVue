<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class StudentController extends BaseController
{
    public function index(){
        $students = Student::all();
        return DataTables::of($students)->make(true);
    }

    public function addStudent(Request $request){
        $validator = Validator::make($request->all(),[
           'username' => 'required',
           'email' => 'required|unique:students'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        try {
            $student = new Student();
            $student->username = $request->username;
            $student->email = $request->email;
            $student->save();

            return $this->sendSuccess('Added');
        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }



    }

    public function deleteStudent($id){

        $student = Student::find($id);

        if(!$student){
            return $this->sendError('Student Not Exist');
        }

        try {
            $student->delete();

            return $this->sendSuccess('Deleted');
        }catch (\Exception $exception){
            return $this->sendError($exception->getMessage());
        }
    }
}
