<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\PositionUser;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $data = Position::where('name', '!=', 'Default')->get();
        //insert default position
        // if ($data->count() == 0) {
        //     Position::create([
        //         'name' => 'Default',
        //         'description' => 'Silahkan Ubah'
        //     ]);
        // }
        return view('admin.position.index', compact('data'));
    }

    public function create()
    {
        return view('admin.position.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $simpan = new Position();
        $simpan->name = $request->name;
        $simpan->description = $request->description;
        $simpan->save();

        if($simpan){
            return redirect()->route('admin.position.index')->with('message',
            [
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }else{
            return redirect()->route('admin.position.index')->with('message',
            [
                'success' => false,
                'message' => 'Data gagal disimpan'
            ]);
        }
    }

    public function show($id)
    {
        $data = Position::find($id);
        return view('admin.position.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Position::find($id);
        return view('admin.position.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $simpan = Position::find($id);
        $simpan->name = $request->name;
        $simpan->description = $request->description;
        $simpan->save();

        if($simpan){
            return redirect()->route('admin.position.index')->with('message',
            [
                'success' => true,
                'message' => 'Data berhasil diubah'
            ]);
        }else{
            return redirect()->route('admin.position.index')->with('message',
            [
                'success' => false,
                'message' => 'Data gagal diubah'
            ]);
        }
    }

    public function destroy($id)
    {
        $data = Position::find($id);
        //pindahkan user ke position default
        $default = Position::where('name', 'Default')->first();
        $user = PositionUser::where('position_id', $id)->update(['position_id' => $default->id]);
        //hapus data
        $data->delete();
        return redirect()->route('admin.position.index')->with('message',
        [
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
