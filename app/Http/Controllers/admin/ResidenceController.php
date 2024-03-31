<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\Residence;
use Illuminate\Http\Request;

class ResidenceController extends Controller
{
    public function index()
    {
        $data = Residence::orderBy('block')
                 ->orderByRaw('CAST(home_number AS SIGNED)')
                    ->get();


        $position = Position::all();
        return view('admin.residence.index', compact('data', 'position'));
    }

    public function create()
    {
        return view('admin.residence.create');
    }

    public function store(Request $request)
    {
        //'name', 'address', 'phone', 'sex','birth', 'ktp', 'status', 'block', 'home_number', 'rt', 'rw'
        $request->validate([
            'name' => 'required',
            // 'phone' => 'required',
            'sex' => 'required',
            'block' => 'required',
            'home_number' => 'required',
        ]);

        $simpan = new Residence();
        $simpan->name = $request->name;
        $simpan->phone = $request->phone;
        $simpan->sex = $request->sex;
        $simpan->block = $request->block;
        $simpan->home_number = $request->home_number;
        $simpan->save();

        if ($simpan->id) {
            return redirect()->route('admin.residence.index')->with('message', [
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        } else {
            return redirect()->route('admin.residence.index')->with('message', [
                'success' => false,
                'message' => 'Data gagal disimpan'
            ]);
        }
    }

    public function show($id)
    {
        $data = Residence::find($id);
        return view('admin.residence.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Residence::find($id);
        return view('admin.residence.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            // 'phone' => 'required',
            'sex' => 'required',
            'block' => 'required',
            'home_number' => 'required',
        ]);

        $simpan = Residence::find($id);
        $simpan->name = $request->name;
        $simpan->phone = $request->phone;
        $simpan->sex = $request->sex;
        $simpan->block = $request->block;
        $simpan->home_number = $request->home_number;
        $simpan->save();

        if ($simpan->id) {
            return redirect()->route('admin.residence.index')->with('message', [
                'success' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } else {
            return redirect()->route('admin.residence.edit', $id)->with('message', [
                'success' => false,
                'message' => 'Data gagal diupdate'
            ]);
        }

    }

    public function destroy($id)
    {
        $data = Residence::find($id);
        // //hapus data invoice dan payment
        // $invoice = $data->invoices;
        // foreach ($invoice as $key => $value) {
        //     //delete payment
        //     $value->payments()->delete();
        //     //delete invoice
        //     $value->delete();
        // }
        $data->delete();
        return redirect()->route('admin.residence.index')->with('message', [
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

}
