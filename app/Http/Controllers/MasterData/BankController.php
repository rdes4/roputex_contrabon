<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\BankModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function ajax_data(Request $request){
        // dd($request);
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = "id";

        $menu_count    = BankModel::get();
        $totalData     = $menu_count->count();
        $totalFiltered = $totalData;

        if (empty($request->input('search')['value'])) {
            $posts = BankModel::orderby('id', 'desc')->offset($start)->limit($limit)->get();
        } else {
            $search        = $request->input('search')['value'];
            $posts = BankModel::where('nama_pemilik', 'like', '%' . $search . '%')->orWhere('nomor_rekening', 'like', '%' . $search . '%')->orderby('id', 'desc')->offset($start)->limit($limit)->get();
            $totalFiltered = BankModel::where('nama_pemilik', 'like', '%' . $search . '%')->orWhere('nomor_rekening', 'like', '%' . $search . '%')->get()->count();
        }
        // dd($posts);

        $data = [];
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $data[] = [
                    'id' => $post->id,
                    'bank' => $post->bank,
                    'nomor_rekening' => $post->nomor_rekening,
                    'nama_pemilik' => $post->nama_pemilik,
                ];
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function create(Request $request){
        return view('pages.master_data.bank.create');
    }

    public function save(Request $request){
        // dd($request);
        try {

            $qry = BankModel::create([
                'bank' => $request->bank,
                'nomor_rekening' => $request->nomor_rekening,
                'nama_pemilik' => $request->nama_pemilik,
                'created_at' => Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => "bank berhasil dibuat",
            ]);
        } catch (\Exception $e) {
            // Tangkap semua jenis error umum
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

    }

    public function edit(Request $request){
        $bank = BankModel::where('id', $request->id_bank)->first();
        return view('pages.master_data.bank.edit', [
            'bank' => $bank
        ]);
    }

    public function update(Request $request){
        // dd($request);
        try {

            $qry = BankModel::where('id', $request->id_bank)->update([
                'bank' => $request->bank,
                'nomor_rekening' => $request->nomor_rekening,
                'nama_pemilik' => $request->nama_pemilik,
                'updated_at' =>  Carbon::now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => "bank berhasil dirubah",
            ]);
        } catch (\Exception $e) {
            // Tangkap semua jenis error umum
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

    }

    public function delete(Request $request){
        // dd($request);
        try {

            $qry = BankModel::where('id', $request->id_bank)->delete();

            return response()->json([
                'success' => true,
                'message' => "bank berhasil dihapus",
            ]);
        } catch (\Exception $e) {
            // Tangkap semua jenis error umum
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }

    }
}
