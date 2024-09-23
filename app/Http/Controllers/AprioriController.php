<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Http\Services\AprioriService;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class AprioriController extends Controller
{
    private $apriori;
    public function __construct()
    {
        $this->apriori =  new AprioriService();
    }
    public function index()
    {   
        // mengurutkan buku
        $data = Peminjaman::with("book")->orderBy("pinjam", "asc")->get();
        // mengelompokkan buku berdasarkan tanggal
        $groupedData = $data->groupBy(function ($item) {
            return Carbon::parse($item->pinjam)->format('Y-m-d');
        });

        $dataItem = $groupedData->map(function ($group) {
            // Mengambil data dari setiap grup
            $groupedItems = $group->map(function ($item) {
                return $item->book->judul; // Gantilah 'data' dengan atribut yang sesuai pada model Transaksi
                // return $item->id; // Gantilah 'data' dengan atribut yang sesuai pada model Transaksi
            })->toArray();
        
            // Menggabungkan data dari setiap grup
            return $groupedItems;
        })->values()->toArray();
        $url = "https://service.firmaniphone.cloud/";
        $datas = [
            'data' => $dataItem,
        ];
        // Kirim permintaan POST dengan data JSON
        $response = Http::asJson()->post($url, $datas);
        // Cek respons dari permintaan
        if ($response->successful()) {
            // Respons berhasil
            $responseData = $response->json(); // Mendapatkan respons dalam bentuk array/JSON
            return response()->json($responseData);
        } else {
            // Respons gagal
            // Handle kesalahan jika terjadi
            return response()->json($response->status());
        }
    }
    
    public function show()
    {
        return response()->view("apriori.index");
    }
}
