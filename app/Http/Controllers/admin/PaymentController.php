<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Cashflow;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Residence;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $bulan = date('m');
        $tahun = date('Y');
        $category_id = 2;
        $category = Category::find($category_id);
        $categories = Category::where('id', '!=', 1)->get();
        $data = Residence::orderBy('block', 'asc')->orderByRaw('CAST(home_number AS SIGNED)')->get();

        // Initialize variables
        $totalPaid = 0;
        $totalUnpaid = 0;

        // Iterate through each residence
        foreach ($data as $residence) {
            // Query payments for the current residence based on category and month
            $payments = Payment::where('residence_id', $residence->id)
                            ->where('category_id', $category_id)
                            ->where('month', $bulan)
                            ->where('year', $tahun)
                            ->get();

            // Calculate total amount paid by the current residence
            $totalAmountPaid = $payments->sum('amount');

            // Calculate total amount to be paid (assuming monthly payments)
            $totalAmountToBePaid = $category->amount;

            // Update totalPaid and totalUnpaid
            $totalPaid += $totalAmountPaid;
            $totalUnpaid += $totalAmountToBePaid - $totalAmountPaid;
        }

        // Calculate totalAll (total of all residences)
        $total = $totalPaid + $totalUnpaid;

        // Return data to the view
        return view('admin.payment.index', compact('categories', 'data', 'totalPaid', 'totalUnpaid', 'total','bulan','tahun','category','category_id'));
    }


    public function filter(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $category_id = $request->category_id;
        $category = Category::find($request->category_id);
        $categories = Category::where('id', '!=', 1)->get();
        $data = Residence::orderBy('block', 'asc')->orderBy('home_number', 'asc')->get();

        // Initialize variables
        $totalPaid = 0;
        $totalUnpaid = 0;

        // Iterate through each residence
        foreach ($data as $residence) {
            // Query payments for the current residence based on category and month
            $payments = Payment::where('residence_id', $residence->id)
                            ->where('category_id', $category_id)
                            ->where('month', $bulan)
                            ->where('year', $tahun)
                            ->get();

            // Calculate total amount paid by the current residence
            $totalAmountPaid = $payments->sum('amount');

            // Calculate total amount to be paid (assuming monthly payments)
            $totalAmountToBePaid = $category->amount;

            // Update totalPaid and totalUnpaid
            $totalPaid += $totalAmountPaid;
            $totalUnpaid += $totalAmountToBePaid - $totalAmountPaid;
        }

        // Calculate totalAll (total of all residences)
        $total = $totalPaid + $totalUnpaid;

        // Return data to the view
        return view('admin.payment.index', compact('categories', 'data', 'totalPaid', 'totalUnpaid', 'total','bulan','tahun','category','category_id'));
    }
    // gakepake
    public function show($id)
    {
        $data = Invoice::find($id);
        return view('admin.payment.show', compact('data'));
    }

    // gakepake
    public function create()
    {
        $categories = Category::where('id', '!=', 1)->get();
        $residences = Residence::all();
        return view('admin.payment.create', compact('categories', 'residences'));
    }

    //// gakepake
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'residence_id' => 'required',
            'description' => 'required',
            'type' => 'required',
            'amount' => 'required',
        ]);

        $simpan = new Invoice();
        $simpan->category_id = $request->category_id;
        $simpan->residence_id = $request->residence_id;
        $simpan->description = $request->description;
        $simpan->type = $request->type;
        $simpan->amount = $request->amount;
        $simpan->status = 'unpaid';
        $simpan->save();

        if ($simpan->id) {
            return redirect()->route('admin.payment.index')->with('message', [
                'success' => true,
                'message' => 'Invoice berhasil ditambahkan'
            ]);
        } else {
            return redirect()->route('admin.payment.index')->with('message', [
                'success' => false,
                'message' => 'Invoice gagal ditambahkan'
            ]);
        }
    }
    // gakepake
    public function edit($id)
    {
        $data = Invoice::find($id);
        $categories = Category::where('id', '!=', 1)->get();
        $residences = Residence::all();
        return view('admin.payment.edit', compact('data', 'categories', 'residences'));
    }

    // gakepake
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'residence_id' => 'required',
            'description' => 'required',
            'type' => 'required',
            'amount' => 'required',
        ]);

        $simpan = Invoice::find($id);
        $simpan->category_id = $request->category_id;
        $simpan->residence_id = $request->residence_id;
        $simpan->description = $request->description;
        $simpan->type = $request->type;
        $simpan->amount = $request->amount;
        $simpan->save();

        if ($simpan->id) {
            return redirect()->route('admin.payment.index')->with('message', [
                'success' => true,
                'message' => 'Invoice berhasil diubah'
            ]);
        } else {
            return redirect()->route('admin.payment.index')->with('message', [
                'success' => false,
                'message' => 'Invoice gagal diubah'
            ]);
        }
    }


    public function destroy($id)
    {
        $hapus = Payment::find($id);
        $hapus->delete();

        if ($hapus) {
            return redirect()->route('admin.payment.index')->with('message', [
                'success' => true,
                'message' => 'Pembayaran berhasil dihapus'
            ]);
        } else {
            return redirect()->route('admin.payment.index')->with('message', [
                'success' => false,
                'message' => 'Pembayaran gagal dihapus'
            ]);
        }
    }

    public function pay($bulan, $tahun, $category_id, $residence_id)
    {
        $data = Category::where('id', $category_id)->first();
        if(!$data){
            return redirect()->route('admin.payment.index')->with('message', [
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        $residence = Residence::find($residence_id);
        if(!$residence){
            return redirect()->route('admin.payment.index')->with('message', [
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return view('admin.payment.pay', compact('data', 'bulan', 'tahun', 'category_id', 'residence_id', 'residence'));
    }

    public function storePay(Request $request, $bulan, $tahun, $category_id, $residence_id)
    {
        $request->validate([
            'amount' => 'required',
            // 'description' => 'required',
            'month' => 'required',
            'date' => 'required',
            'year' => 'required'
        ]);

        foreach($request->month as $key => $value){
            $cek = Payment::where('residence_id', $residence_id)->where('category_id', $category_id)->where('month', $value)->where('year', $request->year)->first();
            if($cek){
                return redirect()->back()->with('message', [
                    'success' => false,
                    'message' => 'Pembayaran bulan '.$value.' sudah dilakukan'
                ]);
            }else{
                $simpan = new Payment();
                $simpan->category_id = $category_id;
                $simpan->residence_id = $residence_id;
                $simpan->description = $request->description;
                $simpan->month = $value;
                $simpan->year = $request->year;
                $simpan->amount = $request->amount;
                $simpan->date = $request->date;
                $simpan->user_id = auth()->user()->id;

                //ambil dari table cashflow tipe iuran pada bulan date('m')
                $cashflow = Cashflow::where('type', 'iuran')->whereMonth('date', date('m'))->first();
                if(!$cashflow){
                    $last = CashFlow::latest()->first();
                    if($last){
                        $balance = $last->amount;
                    }else{
                        $balance = 0;
                    }
                        //buat baru
                        $cashflow = new Cashflow();
                        $cashflow->user_id = auth()->user()->id;
                        $bulan_indo = getIndonesiaMonth(date('m'));
                        $cashflow->description = 'Iuran warga bulan '.$bulan_indo.' '.$request->year;
                        $cashflow->amount = $balance + $request->amount;
                        $cashflow->in = $request->amount;
                        $cashflow->out = 0;
                        $cashflow->date = date('Y-m-d');
                        $cashflow->type = 'iuran';
                        $cashflow->save();
                    }else{
                        $cashflow->amount = $cashflow->amount + $request->amount;
                        $cashflow->in = $cashflow->in + $request->amount;
                        $cashflow->save();
                    }
                $simpan->save();
            }
        }

        if ($simpan->id) {
            $text_bulan = '';
            foreach($request->month as $key => $value){
                $text_bulan .= getIndonesiaMonth($value).', ';
            }
            return redirect()->route('admin.payment.index')->with('message', [
                'success' => true,
                'message' => 'Pembayaran berhasil dibuat untuk bulan '.$text_bulan.' tahun '.$request->year
            ]);
        } else {
            return redirect()->route('admin.payment.index')->with('message', [
                'success' => false,
                'message' => 'Pembayaran gagal'
            ]);
        }
    }

    public function showPayment($id)
    {
        $data = Invoice::find($id);
        return view('admin.payment.showPayment', compact('data'));
    }

    public function print($bulan, $tahun, $category_id)
    {
        $category = Category::find($category_id);
        $categories = Category::where('id', '!=', 1)->get();
        $data = Residence::orderBy('block', 'asc')->orderBy('home_number', 'asc')->get();

        // Initialize variables
        $totalPaid = 0;
        $totalUnpaid = 0;

        // Iterate through each residence
        foreach ($data as $residence) {
            // Query payments for the current residence based on category and month
            $payments = Payment::where('residence_id', $residence->id)
                            ->where('category_id', $category_id)
                            ->where('month', $bulan)
                            ->where('year', $tahun)
                            ->get();

            // Calculate total amount paid by the current residence
            $totalAmountPaid = $payments->sum('amount');

            // Calculate total amount to be paid (assuming monthly payments)
            $totalAmountToBePaid = $category->amount;

            // Update totalPaid and totalUnpaid
            $totalPaid += $totalAmountPaid;
            $totalUnpaid += $totalAmountToBePaid - $totalAmountPaid;
        }

        // Calculate totalAll (total of all residences)
        $total = $totalPaid + $totalUnpaid;

        // Return data to the view
        return view('admin.payment.print', compact('categories', 'data', 'totalPaid', 'totalUnpaid', 'total','bulan','tahun','category','category_id'));
    }
    public function download($bulan, $tahun, $category_id)
    {
        $category = Category::find($category_id);
        $categories = Category::where('id', '!=', 1)->get();
        $data = Residence::orderBy('block', 'asc')->orderBy('home_number', 'asc')->get();

        // Initialize variables
        $totalPaid = 0;
        $totalUnpaid = 0;

        // Iterate through each residence
        foreach ($data as $residence) {
            // Query payments for the current residence based on category and month
            $payments = Payment::where('residence_id', $residence->id)
                            ->where('category_id', $category_id)
                            ->where('month', $bulan)
                            ->where('year', $tahun)
                            ->get();

            // Calculate total amount paid by the current residence
            $totalAmountPaid = $payments->sum('amount');

            // Calculate total amount to be paid (assuming monthly payments)
            $totalAmountToBePaid = $category->amount;

            // Update totalPaid and totalUnpaid
            $totalPaid += $totalAmountPaid;
            $totalUnpaid += $totalAmountToBePaid - $totalAmountPaid;
        }

        // Calculate totalAll (total of all residences)
        $total = $totalPaid + $totalUnpaid;

        $pdf = Pdf::loadView('admin.payment.download', compact('categories', 'data', 'totalPaid', 'totalUnpaid', 'total','bulan','tahun','category','category_id'));
        return $pdf->download('laporan-pembayaran-'.$category->name.'-'.$bulan.'-'.$tahun.'.pdf');
    }
}
