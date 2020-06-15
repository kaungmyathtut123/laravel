<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Student;
use Datatables;

class AjaxdataController extends Controller
{
    public function index(){
        return view('student.ajaxdata');
    }

    public function getdata(){
    	$students=Student::select('id','first_name','last_name');
    	return Datatables::of($students)
        ->addColumn('action',function($student){
            return "<a style='margin-right:5px;' href='#' class='edit btn  btn-primary' id=".$student->id."> <i class='glyphicon glyphicon-edit'></i></a><a href='#' class='delete btn btn-danger' id=".$student->id." ><i class='glyphicon glyphicon-remove'></i></a>";
        })
        ->make(true);
    }

    public function insertdata(Request $request){
    	if($request->get('button_action')=="insert"){
    		$student=new Student([
    			'first_name'=>$request->get('first_name'),
    			'last_name'=>$request->get('last_name')
    		]);
    		$student->save();
    		$success_output="<div style='display:block;width:50%;margin-left:auto;margin-right:auto;'><div style='text-align:center;' class='alert alert-success'>Data Inserted<button type='button' class='success_close close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>&times;</span> </button></div><center>";
    }

     if ($request->get('button_action')=='update') {
          $student=Student::find($request->get('student_id'));
          $student->first_name=$request->get('first_name');
          $student->last_name=$request->get('last_name');
          $student->active=$request->get('active');
          $student->save();
          $success_output="<div style='display:block;width:50%;margin-left:auto;margin-right:auto;'><div style='text-align:center;' class='alert alert-success'>Data Updated<button type='button' class='success_close close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>&times;</span> </button></div><center>";
     }

    $output=array(
    		'success'=>$success_output
    );
    echo json_encode($output);

   // return Response::json($student);
}

   public function fetchdata(Request $request){
    $id=$request->input('id');
    $student=Student::find($id);
    $output=array('first_name'=>$student->first_name,'last_name'=>$student->last_name,'active'=>$student->active);
    echo json_encode($output);
   }

   public function removedata(Request $request){
     $student=Student::find($request->input('id'));
     if($student->delete()){
          echo "Data Deleted";
     }
   }
}
