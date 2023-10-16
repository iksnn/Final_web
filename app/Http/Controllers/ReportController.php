<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['index']);
        $this->middleware('auth:api')->only(['get_reports']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_reports(Request $request)
{
    $dari = $request->input('dari'); // Assuming 'dari' is a key in the request
    $sampai = $request->input('sampai'); // Assuming 'sampai' is a key in the request

    $report = DB::table('order_details')
        ->join('products', 'products.id', '=', 'order_details.id_produk')
        ->select(
            'nama_barang',
            DB::raw('COUNT(*) as jumlah_dibeli'),
            'harga',
            DB::raw('SUM(total) as pendapatan'),
            DB::raw('SUM(jumlah) as total_qty')
        )
        ->whereRaw("DATE(order_details.created_at) >= ?", [$dari])
        ->whereRaw("DATE(order_details.created_at) <= ?", [$sampai])
        ->groupBy('id_produk', 'nama_barang', 'harga')
        ->get();

    return response()->json([
        'data' => $report
    ]);
}

public function index()
{
    return view('report.index');
}


}
