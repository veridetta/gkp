<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Cashflow;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;

class CashflowController extends Controller
{
    public function index()
    {
        //data where month and year
        $data = Cashflow::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->get();
            $month = date('m');
            $year = date('Y');
        $saldo = Cashflow::sum('in') - Cashflow::sum('out');
        return view('admin.cashflow.index', compact('data', 'month', 'year', 'saldo'));
    }

    public function filter(Request $request)
    {
        //data where month and year
        $month = $request->month;
        $year = $request->year;
        $data = Cashflow::whereMonth('created_at', $request->month)
            ->whereYear('created_at', $request->year)
            ->get();
        $saldo = Cashflow::sum('in') - Cashflow::sum('out');
        return view('admin.cashflow.index', compact('data', 'month', 'year', 'saldo'));
    }

    public function create()
    {
        return view('admin.cashflow.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'date' => 'required',
        ]);
        //jika requst image maka validate
        if($request->hasFile('image')){
            $request->validate([
                'image' => 'mimes:jpg,jpeg,png|max:2048'
            ]);
        }
        // dd($request->all());
        //ambil amount terakhir
        $last = Cashflow::latest()->first();
        if($last){
            $balance = $last->amount;
        }else{
            $balance = 0;
        }
        //upload image

        $simpan = new Cashflow();
        if($request->type == 'in'){
            $simpan->in = $request->amount;
            $simpan->out = 0;
        }else{
            $simpan->in = 0;
            $simpan->out = $request->amount;
        }
        $simpan->description = $request->description;
        $simpan->date = $request->date;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image->storeAs('public/cashflow', $image->hashName());
            $simpan->image = $image->hashName();
        }
        $simpan->amount = $balance + $request->amount;
        $simpan->user_id = auth()->user()->id;
        $simpan->save();

        if($simpan){
            return redirect()->route('admin.cashflow.index')->with('message', [
                'success' => true,
                'message' => 'Transaksi berhasil ditambahkan'
            ]);
        }else{
            return redirect()->route('admin.cashflow.index')->with('message', [
                'success' => false,
                'message' => 'Transaksi gagal ditambahkan'
            ]);
        }
    }

    public function show($id)
    {
        $data = Cashflow::find($id);
        return view('admin.cashflow.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Cashflow::find($id);
        //set amount
        if($data->in > 0){
            $data->amount = $data->in;
        }else{
            $data->amount = $data->out;
        }
        return view('admin.cashflow.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'date' => 'required'
        ]);

        $simpan = Cashflow::find($id);
        // dd($request->all());
        if($request->hasFile('image')){
            $request->validate([
                'image' => 'mimes:jpg,jpeg,png|max:2048'
            ]);
            //hapus old image
            $image = $request->file('image');
            $image->storeAs('public/cashflow', $image->hashName());
            $simpan->image = $image->hashName();
        }
        $balance = $simpan->amount - $simpan->in + $simpan->out;
        if($request->type == 'in'){
            $simpan->in = $request->amount;
            $simpan->out = 0;
        }else{
            $simpan->in = 0;
            $simpan->out = $request->amount;
        }
        $simpan->description = $request->description;
        $simpan->date = $request->date;
        $simpan->amount = $balance + $request->amount;

        $simpan->save();

        if($simpan){
            return redirect()->route('admin.cashflow.index')->with('message', [
                'success' => true,
                'message' => 'Transaksi berhasil diubah'
            ]);
        }else{
            return redirect()->route('admin.cashflow.index')->with('message', [
                'success' => false,
                'message' => 'Transaksi gagal diubah'
            ]);
        }
    }

    public function destroy($id)
    {
        $hapus = Cashflow::find($id);
        if(!$hapus){
            return redirect()->route('admin.cashflow.index')->with('message', [
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ]);
        }
        $hapus->delete();

        if($hapus){
            return redirect()->route('admin.cashflow.index')->with('message', [
                'success' => true,
                'message' => 'Transaksi berhasil dihapus'
            ]);
        }else{
            return redirect()->route('admin.cashflow.index')->with('message', [
                'success' => false,
                'message' => 'Transaksi gagal dihapus'
            ]);
        }
    }

    public function print($month, $year)
    {
        $data = Cashflow::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        $saldo = Cashflow::sum('in') - Cashflow::sum('out');
        $total_in = Cashflow::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('in');
        $total_out = Cashflow::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('out');
        $sisa = $total_in - $total_out;
        $total_saldo_sebelumnya = Cashflow::whereMonth('created_at' , '<', $month)->whereYear('created_at', $year)->sum('in') - Cashflow::whereMonth('created_at' , '<', $month)->whereYear('created_at', $year)->sum('out');
        return view('admin.cashflow.print', compact('data', 'month', 'year', 'saldo', 'total_in', 'total_out', 'sisa', 'total_saldo_sebelumnya'));
    }

    public function download($month, $year)
    {
        $data = Cashflow::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        $saldo = Cashflow::sum('in') - Cashflow::sum('out');
        $total_in = Cashflow::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('in');
        $total_out = Cashflow::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('out');
        $sisa = $total_in - $total_out;
        $total_saldo_sebelumnya = Cashflow::whereMonth('created_at' , '<', $month)->whereYear('created_at', $year)->sum('in') - Cashflow::whereMonth('created_at' , '<', $month)->whereYear('created_at', $year)->sum('out');
        // return view('admin.cashflow.download', compact('data', 'month', 'year', 'saldo', 'total_in', 'total_out', 'sisa', 'total_saldo_sebelumnya'));

        $pdf = FacadePdf::loadView('admin.cashflow.download', compact('data', 'month', 'year', 'saldo', 'total_in', 'total_out', 'sisa', 'total_saldo_sebelumnya'));

        // Set paper orientation to landscape
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan_pengeluaran_pemasukan_'.$month.'_'.$year.'.pdf');

    }
}
