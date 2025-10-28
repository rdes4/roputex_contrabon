<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContrabonFakturModel;
use App\Models\ContrabonModel;
use App\Models\MasterData\BankModel;
use App\Models\MasterData\CustomerModel;
use App\Models\MasterData\SalesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContrabonController extends Controller
{
    public function ajax_data(Request $request){
        // dd($request);
        $limit = $request->input('length');
        $start = $request->input('start');

        $menu_count    = ContrabonModel::get();
        $totalData     = $menu_count->count();
        $totalFiltered = $totalData;

        if (empty($request->input('search')['value'])) {
            $posts = ContrabonModel::orderby('id', 'desc')->offset($start)->limit($limit)->get();
        } else {
            $search        = $request->input('search')['value'];
            $posts = ContrabonModel::where('nomor', 'like', '%' . $search . '%')->orderby('id', 'desc')->offset($start)->limit($limit)->get();
            $totalFiltered = ContrabonModel::where('nomor', 'like', '%' . $search . '%')->get()->count();
        }
        // dd($posts);

        $data = [];
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $bank = BankModel::where('id', $post->id_bank)->first();

                $data[] = [
                    'id' => $post->id,
                    'nomor' => $post->nomor,
                    'tempo' => $post->tempo,
                    'tgl_jatuh_tempo' => Carbon::parse($post->tgl_jatuh_tempo)->format('d-m-Y'),
                    'id_customer' => CustomerModel::where('id', $post->id_customer)->first()->nama,
                    'id_sales' => SalesModel::where('id', $post->id_sales)->first()->nama,
                    'id_bank' => $bank->bank.' - '.$bank->nomor_rekening,
                    'total_faktur' => ContrabonFakturModel::where('id_contrabon', $post->id)->count(),
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

    public function save(Request $request){
        // dd($request);
        try {
            $data = [
                'nomor' => $request->nomor,
                'tgl_contrabon' => Carbon::createFromFormat('d-m-Y', $request->tgl_contrabon)->format('Y-m-d'),
                'tgl_jatuh_tempo' => Carbon::createFromFormat('d-m-Y', $request->tgl_jatuh_tempo)->format('Y-m-d'),
                'tempo' => $request->tempo,
                'id_customer' => $request->id_customer,
                'id_sales' => $request->id_sales,
                'id_bank' => $request->id_bank,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $qry = ContrabonModel::create($data);

            if ($qry) {
                foreach ($request->arr_faktur as $key => $value) {
                    $data2 = [
                        'id_contrabon' => $qry->id,
                        'nomor_faktur' => $value['nomor_faktur'],
                        'tgl_faktur' =>  Carbon::createFromFormat('d-m-Y', $value['tgl_faktur'])->format('Y-m-d'),
                        'sales_order' => $value['sales_order'],
                        'jumlah_faktur' => $value['jumlah_faktur'],
                        'jumlah_retur' => $value['jumlah_retur'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];

                    $qry2 = ContrabonFakturModel::create($data2);
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Contrabon berhasil dibuat",
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
        // dd($request);
        $contrabon = ContrabonModel::where('id', $request->id_contrabon)->first();
        $contrabon_faktur = ContrabonFakturModel::where('id_contrabon', $request->id_contrabon)->get();

        $arr_cust = [];
        $get_cust = CustomerModel::get();
        foreach ($get_cust as $key => $value) {
            $arr_cust[$value->id] = $value->customer_code.' - '.$value->nama;
        }

        $arr_sales = [];
        $get_sales = SalesModel::get();
        foreach ($get_sales as $key => $value) {
            $arr_sales[$value->id] = $value->sales_code.' - '.$value->nama;
        }

        $arr_bank = [];
        $get_bank = BankModel::get();
        foreach ($get_bank as $key => $value) {
            $arr_bank[$value->id] = $value->bank.' - '.$value->nomor_rekening;
        }
        return view('pages.contrabon.edit_contrabon',[
            'arr_cust' => $arr_cust,
            'arr_sales' => $arr_sales,
            'arr_bank' => $arr_bank,
            'contrabon' => $contrabon,
            'contrabon_faktur' => $contrabon_faktur,
        ]);
    }

    public function update(Request $request){
        // dd($request);
        try {
            $data = [
                'nomor' => $request->nomor,
                'tempo' => $request->tempo,
                'tgl_contrabon' => Carbon::createFromFormat('d-m-Y', $request->tgl_contrabon)->format('Y-m-d'),
                'tgl_jatuh_tempo' => Carbon::createFromFormat('d-m-Y', $request->tgl_jatuh_tempo)->format('Y-m-d'),
                'id_customer' => $request->id_customer,
                'id_sales' => $request->id_sales,
                'id_bank' => $request->id_bank,
                'updated_at' => Carbon::now(),
            ];

            $qry = ContrabonModel::where('id', $request->id_contrabon)->update($data);

            if (isset($request->arr_faktur)) {
                foreach ($request->arr_faktur as $key => $value) {
                    $data2 = [
                        'nomor_faktur' => $value['nomor_faktur'],
                        'tgl_faktur' => Carbon::createFromFormat('d-m-Y', $value['tgl_faktur'])->format('Y-m-d'),
                        'sales_order' => $value['sales_order'],
                        'jumlah_faktur' => $value['jumlah_faktur'],
                        'jumlah_retur' => $value['jumlah_retur'],
                        'updated_at' => Carbon::now(),
                    ];

                    $qry2 = ContrabonFakturModel::where('id', $value['id_contrabon_faktur'])->update($data2);
                }
            }

            if (isset($request->arr_new_faktur)) {
                foreach ($request->arr_new_faktur as $key => $value) {
                    $data2 = [
                        'id_contrabon' => $request->id_contrabon,
                        'nomor_faktur' => $value['nomor_faktur'],
                        'tgl_faktur' => Carbon::createFromFormat('d-m-Y', $value['tgl_faktur'])->format('Y-m-d'),
                        'sales_order' => $value['sales_order'],
                        'jumlah_faktur' => $value['jumlah_faktur'],
                        'jumlah_retur' => $value['jumlah_retur'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];

                    $qry2 = ContrabonFakturModel::create($data2);
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Contrabon berhasil dirubah",
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
        try {
            $qry1 = ContrabonModel::where('id', $request->id_contrabon)->delete();
            $qry2 = ContrabonFakturModel::where('id_contrabon', $request->id_contrabon)->delete();

            return response()->json([
                'success' => true,
                'message' => "Contrabon berhasil dihapus",
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function delete_contrabon_faktur(Request $request){
        // dd($request);
        try {
            //code...
            $qry2 = ContrabonFakturModel::where('id', $request->id_contrabon_faktur)->delete();

            return response()->json([
                'success' => true,
                'message' => "Faktur berhasil dirubah",
            ]);
        } catch (\Exception $e) {
            // Tangkap semua jenis error umum
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function print_selection(Request $request){
        $id_contrabon = $request->id_contrabon;
        return view('pages.contrabon.print_selection',[
            'id_contrabon' => $id_contrabon
        ]);
    }

    public function print(Request $request){
        $id_contrabon = $_GET['id_contrabon'];
        $paper_type = $_GET['paper_type'];
        $contrabon = ContrabonModel::selectRaw("contrabon.*, customer.nama as nama_customer, sales.nama as nama_sales, bank.*")
        ->join('customer', 'customer.id', '=', 'contrabon.id_customer')
        ->join('sales', 'sales.id', '=', 'contrabon.id_sales')
        ->join('bank', 'bank.id', '=', 'contrabon.id_bank')
        ->where('contrabon.id', $id_contrabon)
        ->first();
        $contrabon_faktur = ContrabonFakturModel::where('id_contrabon', $id_contrabon)->get();
        // dd($contrabon);
        if ($paper_type == 'continuous_form') {
            return view('print_dot_matrix.contrabon', [
                'contrabon' => $contrabon,
                'contrabon_faktur' => $contrabon_faktur,
            ]);
        } else {
            return view('print_dot_matrix.contrabon_old_form', [
                'contrabon' => $contrabon,
                'contrabon_faktur' => $contrabon_faktur,
            ]);
        }


    }
}
