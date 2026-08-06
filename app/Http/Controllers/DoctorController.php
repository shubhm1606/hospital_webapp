<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('admin.doctor', compact('doctors'));
    }

    public function doctorylist()
    {
        
        $doctors = Doctor::all();
        return response()->json([
            'status' => true,
            'data' => $doctors
        ]);
    }


    public function show($id)
    {
        $doctor = Doctor::find($id);

        return response()->json($doctor);
    }
   

    public function store(Request $request)
    {
       
        $data = Doctor::create([
            'name_en' => $request->doctor_name_english,
            'name_hi' => $request->doctor_name_hindi,
        
            'mobile' => $request->doctor_mobile,
            'is_active' => $request->is_active // 1 or 0
        ]);
        
        return redirect()->back()->with('success', 'Doctor added successfully!');
    }


    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctors.edit', compact('doctor'));
    }

    public function doctor_update(Request $request, $id)
    {
        
        $request->validate([
            'doctor_name_english' => 'required|string|max:255',
            // 'doctor_mobile' => 'required|digits:10',
            'is_active' => 'required',
        ]);

        $doctor = Doctor::findOrFail($id);
        $doctor->update(['name_en'=>$request->doctor_name_english,'mobile'=>$request->doctor_mobile,'is_active'=>$request->is_active]);

        return response()->json([
            'status' => true,
            'message' => 'Doctor updated successfully!'
        ]);

    }

    public function destroy($id)
    {
        Doctor::destroy($id);

        return response()->json([
            'status' => true,
            'message' => 'Doctor deleted successfully!'
        ]);
    }

}
