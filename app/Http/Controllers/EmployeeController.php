<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Exports\ExportEmployee;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index(){
        $employees=Employee::orderBy('id','DESC')->paginate(10);
        return view('employee.list',['employees'=>$employees]);
    }

    public function create(){
     return view('employee.create');
    }

    public function store(Request $request){
    $validator=Validator::make($request->all(),[
        'name'=>'required',
        'email'=>'required',
        'image'=>'sometimes|image:gif,png,jpeg,jpg'
    ]);
     if($validator->passes()){
     //save the data
      $employee=new Employee();
      $employee->name=$request->name;
      $employee->email=$request->email;
      $employee->address=$request->address;
      $employee->save();

      //upload image here
    if($request->image){
      $ext=$request->image->getClientOriginalExtension();
      $file=time().'.'.$ext;
      $request->image->move(public_path().'/uploads/employees/',$file);
      $employee->image=$file;
      $employee->save();
    } 
    $request->session()->flash('success','Employee Added Successfully');
      return redirect()->route('employees.index');

     }
     else{
        return redirect()->route('employees.create')->withErrors($validator)->withInput();
     }
    }

    public function edit($id)
    {
        $employee=Employee::findOrFail($id);
        return view('employee.edit',['employee'=> $employee]);
    }

     public function update($id ,Request $request,)
     {
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'image'=>'sometimes|image:gif,png,jpeg,jpg'
        ]);
         if($validator->passes()){
         //save the data
          $employee=Employee::find($id);
          $employee->name=$request->name;
          $employee->email=$request->email;
          $employee->address=$request->address;
          $employee->save();
    
          //upload image here
        if($request->image){
            $oldImage=$employee->image;
          $ext=$request->image->getClientOriginalExtension();
          $file=time().'.'.$ext;
          $request->image->move(public_path().'/uploads/employees/',$file);
          $employee->image=$file;
          $employee->save();

          File::delete(public_path().'/uploads/employees/'.$oldImage);
        } 
        $request->session()->flash('success','Employee Edited Successfully');
          return redirect()->route('employees.index');
    
         }
         else{
            return redirect()->route('employees.edit',$id)->withErrors($validator)->withInput();
         }
     }

     public function destroy(Employee $employee,Request $request)
     {
      if($employee->trashed()){
        $employee->forceDelete();
        return redirect()->route('employees.index');
      }
      // $employee=Employee::findOrFail($id);
      $employee->delete();
      //File::delete(public_path().'/uploads/employees/'.$employee->image);
      // $request->session()->flash('success','Employee Details Deleted Successfully');
      return redirect()->route('employees.index');
        
     }

     public function restore(Employee $employee,Request $request,$id=null)
     {
        Employee::withTrashed()->find($id)->restore();
        return back()->with('success','Restored data');

     }
     public function archive(){
      $employees=Employee::onlyTrashed()->orderBy('id','DESC')->get();
      return view('employee.archive',['employees'=>$employees]);
  }

     public function exportEmployee(Request $request){
      return Excel::download(new ExportEmployee, 'employee.xlsx');
  }

}
