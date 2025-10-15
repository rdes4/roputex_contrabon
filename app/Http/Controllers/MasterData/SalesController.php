<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\SalesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function ajax_data(Request $request){
        // dd($request);
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = "id";

        $menu_count    = SalesModel::get();
        $totalData     = $menu_count->count();
        $totalFiltered = $totalData;

        if (empty($request->input('search')['value'])) {
            $posts = SalesModel::orderby('id', 'desc')->offset($start)->limit($limit)->get();
        } else {
            $search        = $request->input('search')['value'];
            $posts = SalesModel::where('nama', 'like', '%' . $search . '%')->orWhere('sales_code', 'like', '%' . $search . '%')->orderby('id', 'desc')->offset($start)->limit($limit)->get();
            $totalFiltered = SalesModel::where('nama', 'like', '%' . $search . '%')->orWhere('sales_code', 'like', '%' . $search . '%')->get()->count();
        }
        // dd($posts);

        $data = [];
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $data[] = [
                    'id' => $post->id,
                    'nama' => $post->nama,
                    'sales_code' => $post->sales_code,
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
        return view('pages.master_data.sales.create');
    }

    public function save(Request $request){
        // dd($request);
        try {
            $get_last_sales = SalesModel::orderBy('id', 'desc')->first();
            if ($get_last_sales == NULL) {
                $sales_code = 'SLS0001';
            } else {
                $sales_code = $get_last_sales->sales_code;
                $sales_code++;
            }

            $qry = SalesModel::create([
                'sales_code' => $sales_code,
                'nama' => $request->nama,
                'created_at' => Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => "sales berhasil dibuat",
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
        $sales = SalesModel::where('id', $request->id_sales)->first();
        return view('pages.master_data.sales.edit', [
            'sales' => $sales
        ]);
    }

    public function update(Request $request){
        // dd($request);
        try {

            $qry = SalesModel::where('id', $request->id_sales)->update([
                'nama' => $request->nama,
                'updated_at' =>  Carbon::now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => "sales berhasil dirubah",
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

            $qry = SalesModel::where('id', $request->id_sales)->delete();

            return response()->json([
                'success' => true,
                'message' => "sales berhasil dihapus",
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
