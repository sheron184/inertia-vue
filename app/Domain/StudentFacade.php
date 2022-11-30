<?php
   namespace App\Domain;
   use illuminate\Support\Facades\Facade;
   use App\Models\Student;
   use Illuminate\Support\Facades\Auth;
   use Illuminate\Support\Facades\File;
   
   class StudentFacade extends Facade{
      
      public static function create($request) {
         $imageName = "".uniqid().".".$request->image->extension()."";
         $request->image->move(public_path('uploads'),$imageName);

         $student = new Student();
         $student->user_id = Auth::id();
         $student->name = $request->name;
         $student->age = $request->age;
         $student->image = $imageName;
         $student->status = $request->status;
         
         $student->save();
      }
      public static function update($req){
         if(isset($req->image)){
            $student = Student::where('id',$req->id)->get();
            $filePath = public_path('uploads/'.$student[0]->image.'');

            $imageName = "".uniqid().".".$req->image->extension()."";

            if(File::exists($filePath)){
                File::delete($filePath);
            }

            $imageName = "".uniqid().".".$req->image->extension()."";
            $req->image->move(public_path('uploads'),$imageName);

            $data = [
                "name" => $req->name,
                "age" => $req->age,
                "status" => $req->status,
                "image" => $imageName
            ];
        }else{
            $data = [
                "name" => $req->name,
                "age" => $req->age,
                "status" => $req->status
            ];
        }
         Student::where("id",$req->id)->update($data);
      }
      public static function delete($id){
         Student::where("id",$id)->delete();
      } 
      public static function all(){
         return Student::all();
      }
      public static function getStudent($id){
         return Student::where("id",$id)->get();
      }
   }
?>