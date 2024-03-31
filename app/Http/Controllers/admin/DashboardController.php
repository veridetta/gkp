<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dataset;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\ProductStock;
use App\Models\Residence;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $bulan = date('m');
        $tahun = date('Y');
        if($tahun=='2024'){
            $start_month = 3;
        }else{
            $start_month = 1;
        }
        // $category_id = 2;
        // $category = Category::find($category_id);
        $categories = Category::where('id', '!=', 1)->get();
        $data = Residence::all();

        // Initialize variables
        $totalPaid = 0;
        $totalUnpaid = 0;

        $last_month = 0;
        $this_month = 0;

        // Iterate through each residence
        foreach($categories as $category){
            $category_id = $category->id;
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

                $payments_last_month = Payment::where('residence_id', $residence->id)
                                ->where('category_id', $category_id)
                                ->where('month', $bulan - 1)
                                ->where('year', $tahun)
                                ->get();
                $totalAmountPaid_last_month = $payments_last_month->sum('amount');
                $totalAmountToBePaid_last_month = $category->amount;
                $last_month += $totalAmountPaid_last_month;
                $this_month += $totalAmountPaid;
            }
        }
        // Calculate totalAll (total of all residences)
        $total = $totalPaid + $totalUnpaid;
        $total_pendapatan = $totalPaid;
        $paid = $totalPaid;
        $unpaid = $totalUnpaid;

        if ($last_month == 0) {
            $percentage = 100;
            $tipe = 'success';
        } else {
            $percentage = (($this_month - $last_month) / $last_month) * 100;
            if ($percentage > 0) {
                $tipe = 'success';
            } else {
                $tipe = 'danger';
            }
        }
        //data untuk chartjs
        $chart['data'] = [];
        $chart['data']['total_paid'] = [];
        $chart['data']['total_unpaid'] = [];
        $chart['labels'] = [];
        for ($i = $start_month; $i <= $bulan; $i++) {
            $chart['labels'][] = Carbon::create()->month($i)->format('F');
            // $chart['data']['total_paid'][] = Payment::
            // where('category_id', $category_id)->whereMonth('created_at', $i)->whereYear('created_at', $tahun)->sum('amount');
            // $chart['data']['total_unpaid'][] = $category->amount * count(Residence::all()) - Payment::where('category_id', $category_id)->whereMonth('created_at', $i)->whereYear('created_at', $tahun)->sum('amount');
            $totalPaid = 0;
            $totalUnpaid = 0;
            foreach($categories as $category){
                $category_id = $category->id;
                foreach ($data as $residence) {
                    $payments = Payment::where('residence_id', $residence->id)
                                    ->where('category_id', $category_id)
                                    ->where('month', $i)
                                    ->where('year', $tahun)
                                    ->get();
                    $totalAmountPaid = $payments->sum('amount');
                    $totalAmountToBePaid = $category->amount;
                    $totalPaid += $totalAmountPaid;
                    $totalUnpaid += $totalAmountToBePaid - $totalAmountPaid;
                }
            }
            $chart['data']['total_paid'][] = $totalPaid;
            $chart['data']['total_unpaid'][] = $totalUnpaid;


        }
        // dd($chart);

        return view('admin.dashboard', compact('data', 'total_pendapatan', 'percentage', 'tipe', 'chart', 'total', 'unpaid', 'paid', 'categories', 'category_id','category','bulan','tahun'));
    }
}
