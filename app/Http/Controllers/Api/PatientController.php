<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PatientResource;
use Illuminate\Http\Request;
use App\Http\Requests\PatientRequest;
use App\Models\Patient;

class PatientController extends Controller
{

    public function index()
    {
        $patients = Patient::latest()->paginate(5);

        //return collection of posts as a resource
        return new PatientResource(true, 'List Data Pasien', $patients);
    }

    public function store(Request $request)
    {
        $patient = Patient::create($request->all());
        return response()->json($patient);
    }

    public function show($id)
    {
        $patients = Patient::find($id);

        //return single post as a resource
        return new PatientResource(true, 'Detail Data Pasien', $patients);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        // Validasi request jika diperlukan
        $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        // Update data pasien
        $patient->update($request->all());

        return response()->json($patient);
    }
}
