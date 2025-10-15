<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MasterData\BankModel;
use App\Models\MasterData\CustomerModel;
use App\Models\MasterData\SalesModel;
use Illuminate\Http\Request;

class HtmlController extends Controller
{
    //
    public function get_tab_html(Request $request){
        // dd($request);
        switch ($request->id_tab) {
            case "MD_1":
                // kode jika $variable == '1' => List Contrabon
                return view('pages.master_data.customer.index');
                break;

            case "MD_2":
                // kode jika $variable == '1' => List Contrabon
                return view('pages.master_data.bank.index');
                break;

            case "MD_3":
                // kode jika $variable == '1' => List Contrabon
                return view('pages.master_data.sales.index');
                break;

            case "T_1":
                // kode jika $variable == '1' => List Contrabon
                return view('pages.contrabon.list_contrabon');
                break;

            case "T_2":
               // kode jika $variable == '2' => Buat Contrabon
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

                return view('pages.contrabon.create_contrabon', [
                    'arr_cust' => $arr_cust,
                    'arr_sales' => $arr_sales,
                    'arr_bank' => $arr_bank,
                ]);
                break;

            default:
                // kode jika tidak ada case yang cocok
                break;
        }

    }
}
