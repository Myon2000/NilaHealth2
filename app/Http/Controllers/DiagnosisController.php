<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Diagnosis;

class DiagnosisController extends Controller
{
    public function form()
    {
        return view('frontend.pages.diagnose.diagnose');
    }

    public function predict(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $file     = $request->file('image');
        $filename = time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
        
        $path     = $file->storeAs('uploads/original', $filename, 'public');

        try {
            $resp = Http::timeout(30)
                ->attach('image', file_get_contents($file->getRealPath()), $filename)
                ->post(env('FLASK_API_URL'));

            if (!$resp->successful()) {
                throw new \Exception("Flask API error ({$resp->status()})");
            }

            $r = $resp->json();
            $flaskBase = rtrim(env('FLASK_BASE_URL'), '/');
            
            // Handle the original image URL - check if it comes from Laravel or Flask
            $originalUrl = isset($r['original_image_url']) ? 
                $flaskBase . $r['original_image_url'] : asset('storage/'.$path);
                
            // Handle the predicted image URL
            $predictedUrl = isset($r['predicted_image_url']) ? 
                $flaskBase . $r['predicted_image_url'] : null;

            $payload = array_merge($r, [
                'original_image_url'  => $originalUrl,
                'predicted_image_url' => $predictedUrl,
            ]);

            return redirect()
                   ->route('diagnosis.result')
                   ->with('result', $payload);

        } catch (\Exception $e) {
            return back()
                   ->with('error', 'Gagal memproses prediksi: '.$e->getMessage())
                   ->withInput();
        }
    }

    public function result()
    {
        if (! session()->has('result')) {
            return redirect()
                   ->route('diagnosis.form')
                   ->with('error', 'Silakan upload gambar terlebih dahulu.');
        }

        return view('frontend.pages.diagnose.result', [
            'result' => session('result'),
        ]);
    }

    public function recommendation($disease)
    {
        $penyakit = Str::title(str_replace('-', ' ', $disease)); 

        $diagnosis = Diagnosis::where('hasil_diagnosis', $penyakit)->first();

        if (! $diagnosis) {
            return view('frontend.pages.diagnose.penanganan', [
                'disease'        => $penyakit,
                'recommendation' => 'Maaf, data diagnosis atau rekomendasi tidak ditemukan di database.',
            ]);
        }

        $saran = optional($diagnosis->penanganan)->deskripsi
                ?? 'Maaf, rekomendasi penanganan belum tersedia untuk penyakit ini.';

        return view('frontend.pages.diagnose.penanganan', [
            'disease'        => $penyakit,
            'recommendation' => $saran,
        ]);
    }

    public function getClasses()
    {
        $classes = Diagnosis::select('hasil_diagnosis')->distinct()->get()->pluck('hasil_diagnosis');
        return response()->json($classes);
    }
}
