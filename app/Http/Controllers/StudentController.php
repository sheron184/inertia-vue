<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\StudentFacade;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller{
    public function create(Request $request){
        $validate = $request->validate([
            "name"=> "required",
            "age" => "required",
            "image" => "required"
        ]);

        StudentFacade::create($request);
        $response["students"] = StudentFacade::all();

        return response()->json($response);
    }
    public function destroy($id){
        StudentFacade::delete($id);
        $response["students"] = StudentFacade::all();

        return response()->json($response);
    }
    public function update(Request $request){
        $validate = $request->validate([
            "name"=> "required",
            "age" => "required",
            "image" => "required"
        ]);
        StudentFacade::update($request);

        return Redirect::route('dashboard');
    }
    public function edit($id){
        $student = StudentFacade::getStudent($id);
        
        return Inertia::render('EditStudent',["student"=>$student[0]]);
    }

}
