<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;

class DiagnosisController extends Controller
{
    public function index()
    {
        // eager‑load penanganan untuk menghindari N+1
        $diagnoses = Diagnosis::with('penanganan')->get();

        return view('admin.pages.diagnosa.diagnosis', compact('diagnoses'));
    }
}
