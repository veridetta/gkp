<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Invoice;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        //insert data category default
        $data = Category::where('id', '!=', 1)->get();
        // if (count($data) == 0) {
        //     $simpan = new Category();
        //     $simpan->name = 'Default';
        //     $simpan->description = 'Silahkan ubah data ini';
        //     $simpan->save();
        // }
        return view('admin.category.index', compact('data'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'type' => 'required',
            'amount' => 'required'
        ]);

        $simpan = new Category();
        $simpan->name = $request->name;
        $simpan->type = $request->type;
        $simpan->amount = $request->amount;
        $simpan->description = $request->description;
        $simpan->save();

        if($simpan){
            return redirect()->route('admin.category.index')->with('message', [
                'success' => true,
                'message' => 'Category berhasil ditambahkan'
            ]);
        }else{
            return redirect()->route('admin.category.index')->with('message', [
                'success' => false,
                'message' => 'Category gagal ditambahkan'
            ]);
        }
    }

    public function edit($id)
    {
        $data = Category::find($id);
        return view('admin.category.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'type' => 'required',
            'amount' => 'required'
        ]);

        $simpan = Category::find($id);
        $simpan->name = $request->name;
        $simpan->type = $request->type;
        $simpan->amount = $request->amount;
        $simpan->description = $request->description;
        $simpan->save();

        if($simpan){
            return redirect()->route('admin.category.index')->with('message', [
                'success' => true,
                'message' => 'Category berhasil diubah'
            ]);
        }else{
            return redirect()->route('admin.category.edit', $id)->with('message', [
                'success' => false,
                'message' => 'Category gagal diubah'
            ]);
        }
    }

    public function destroy($id)
    {
        $hapus = Category::find($id);
        $invoice = Invoice::where('category_id', $id)->get();
        foreach ($invoice as $key => $value) {
            $value->category_id = 1;
            $value->save();
        }
        $hapus->delete();

        if($hapus){
            return redirect()->route('admin.category.index')->with('message', [
                'success' => true,
                'message' => 'Category berhasil dihapus'
            ]);
        }else{
            return redirect()->route('admin.category.index')->with('message', [
                'success' => false,
                'message' => 'Category gagal dihapus'
            ]);
        }
    }
}
