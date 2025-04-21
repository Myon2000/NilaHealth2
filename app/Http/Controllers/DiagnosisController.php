<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Diagnosis;

class DiagnosisController extends Controller
{
    // Menampilkan form untuk upload gambar
    public function form()
    {
        return view('frontend.pages.diagnose.diagnose');
    }

    // Proses untuk melakukan prediksi penyakit berdasarkan gambar
    public function predict(Request $request)
    {
        // Validasi file gambar yang di-upload
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $file     = $request->file('image');
        $filename = time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
        
        // Simpan gambar asli ke storage
        $path     = $file->storeAs('uploads/original', $filename, 'public');

        try {
            // Mengirim gambar ke Flask API untuk prediksi
            $resp = Http::timeout(30)
                ->attach('image', file_get_contents($file->getRealPath()), $filename)
                ->post(env('FLASK_API_URL'));

            if (!$resp->successful()) {
                throw new \Exception("Flask API error ({$resp->status()})");
            }

            $r = $resp->json();

            // Membuat URL untuk gambar asli dan gambar prediksi
            $originalUrl   = asset('storage/'.$path);
            $flaskBase     = rtrim(env('FLASK_BASE_URL'), '/');
            $predictedUrl  = $flaskBase . ($r['predicted_image_url'] ?? '');

            // Gabungkan hasil prediksi dan URL gambar ke dalam satu payload
            $payload = array_merge($r, [
                'original_image_url'  => $originalUrl,
                'predicted_image_url' => $predictedUrl,
            ]);

            // Redirect ke halaman hasil prediksi
            return redirect()
                   ->route('diagnosis.result')
                   ->with('result', $payload);

        } catch (\Exception $e) {
            // Tangani error jika ada masalah dengan API Flask
            return back()
                   ->with('error', 'Gagal memproses prediksi: '.$e->getMessage())
                   ->withInput();
        }
    }

    // Menampilkan halaman hasil prediksi
    public function result()
    {
        // Cek apakah ada hasil prediksi dalam session
        if (! session()->has('result')) {
            return redirect()
                   ->route('diagnosis.form')
                   ->with('error', 'Silakan upload gambar terlebih dahulu.');
        }

        // Menampilkan halaman hasil prediksi
        return view('frontend.pages.diagnose.result', [
            'result' => session('result'),
        ]);
    }

    // Menampilkan rekomendasi penanganan berdasarkan penyakit
    public function recommendation($disease)
    {
        // 1) Ubah slug ➡️ nama normal dan title‑case tiap kata
        $penyakit = Str::title(str_replace('-', ' ', $disease)); 
        //    “columnaris-disease” ➡ “Columnaris Disease”

        // 2) Cari berdasarkan nama yang sudah dinormalisasi
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

    // Tambahkan method untuk mendapatkan daftar penyakit dari database untuk Flask
    public function getClasses()
    {
        $classes = Diagnosis::select('hasil_diagnosis')->distinct()->get()->pluck('hasil_diagnosis');
        return response()->json($classes);
    }
}
