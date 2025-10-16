<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\MasterData\CustomerModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function ajax_data(Request $request){
        // dd($request);
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = "id";

        $menu_count    = CustomerModel::get();
        $totalData     = $menu_count->count();
        $totalFiltered = $totalData;

        if (empty($request->input('search')['value'])) {
            $posts = CustomerModel::orderby('id', 'desc')->offset($start)->limit($limit)->get();
        } else {
            $search        = $request->input('search')['value'];
            $posts = CustomerModel::where('nama', 'like', '%' . $search . '%')->orWhere('customer_code', 'like', '%' . $search . '%')->orderby('id', 'desc')->offset($start)->limit($limit)->get();
            $totalFiltered = CustomerModel::where('nama', 'like', '%' . $search . '%')->orWhere('customer_code', 'like', '%' . $search . '%')->get()->count();
        }
        // dd($posts);

        $data = [];
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $data[] = [
                    'id' => $post->id,
                    'nama' => $post->nama,
                    'customer_code' => $post->customer_code,
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
        return view('pages.master_data.customer.create');
    }

    public function save(Request $request){
        // dd($request);
        try {
            $name = trim($request->nama); // hapus spasi di awal/akhir
            $words = explode(' ', $name);
            $inisial = strtoupper(substr($words[0], 0, 1));

            $get_last_customer = CustomerModel::where('customer_code', 'like', '%CUS'.$inisial.'%')->orderBy('id', 'desc')->first();
            if ($get_last_customer == NULL) {
                $customer_code = 'CUS'.$inisial.'001';
            } else {
                $customer_code = $get_last_customer->customer_code;
                $customer_code++;
            }

            $qry = CustomerModel::create([
                'customer_code' => $customer_code,
                'nama' => $request->nama,
                'created_at' => Carbon::now(),
                'updated_at' =>  Carbon::now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => "Customer berhasil dibuat",
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
        $customer = CustomerModel::where('id', $request->id_customer)->first();
        return view('pages.master_data.customer.edit', [
            'customer' => $customer
        ]);
    }

    public function update(Request $request){
        // dd($request);
        try {

            $qry = CustomerModel::where('id', $request->id_customer)->update([
                'nama' => $request->nama,
                'updated_at' =>  Carbon::now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => "Customer berhasil dirubah",
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

            $qry = CustomerModel::where('id', $request->id_customer)->delete();

            return response()->json([
                'success' => true,
                'message' => "Customer berhasil dihapus",
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
