<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Position;
use App\Models\PositionUser;
use App\Models\Residence;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    public function index()
    {
        $data = User::where('role', 'pengurus')->get();

        return view('admin.pengurus.index', compact('data'));
    }

    public function create()
    {
        $residences = Residence::all();
        $positions = Position::where('id', '!=',1)->get();
        return view('admin.pengurus.create', compact('residences', 'positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'residence_id' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'position_id' => 'required',
        ]);

        $nama_residence = Residence::find($request->residence_id)->name;

        $simpan = new User();
        $simpan->name = $nama_residence;
        $simpan->email = $request->email;
        $simpan->password = bcrypt($request->password);
        $simpan->role = "pengurus";
        $simpan->save();

        $position = new PositionUser();
        $position->user_id = $simpan->id;
        $position->position_id = $request->position_id;
        $position->save();

        //update residence
        $residence = Residence::find($request->residence_id);
        $residence->user_id = $simpan->id;

        if($simpan){
            return redirect()->route('admin.pengurus.index')->with('message', [
                'success' => true,
                'message' => 'Petugas berhasil ditambahkan'
            ]);
        }else{
            return redirect()->route('admin.pengurus.index')->with('message', [
                'success' => false,
                'message' => 'Petugas gagal ditambahkan'
            ]);
        }
    }

    public function show($id)
    {
        $data = User::find($id);
        return view('admin.pengurus.show', compact('data'));
    }

    public function edit($id)
    {
        $data = User::find($id);
        $positions = Position::where('id', '!=',1)->get();
        return view('admin.pengurus.edit', compact('data', 'positions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'residence_id' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'position_id' => 'required',
        ]);
        $nama_residence = Residence::find($request->residence_id)->name;
        $simpan = User::find($id);
        if($request->password){
            $request->validate([
                'password' => 'required',
            ]);
            $simpan->password = bcrypt($request->password);
        }
        //cek email duplikat
        // dd($id);
        $cek_email = User::where('email', $request->email)->where('id', '!=', $id)->count();
        if($cek_email > 0){
            return redirect()->route('admin.pengurus.index')->with('message', [
                'success' => false,
                'message' => 'Email sudah digunakan'
            ]);
        }

        $simpan->name = $nama_residence;
        $simpan->email = $request->email;
        $simpan->save();

        $position = PositionUser::where('user_id', $id)->first();
        $position->position_id = $request->position_id;
        $position->save();

        if($simpan){
            return redirect()->route('admin.pengurus.index')->with('message', [
                'success' => true,
                'message' => 'User berhasil diubah'
            ]);
        }else{
            return redirect()->route('admin.pengurus.index')->with('message', [
                'success' => false,
                'message' => 'User gagal diubah'
            ]);
        }
    }

    public function destroy($id)
    {
        $hapus = User::find($id);
        //pindahkan payment (user_id) ke user_id manager
        $petugas = User::where('role', 'admin')->first();
        $sales = Payment::where('user_id', $id)->update(['user_id' => $petugas->id]);
        $cashflow = Payment::where('user_id', $id)->update(['user_id' => $petugas->id]);
        //hapus data
        $hapus = $hapus->delete();
        if($hapus){
            return redirect()->route('admin.pengurus.index')->with('message', [
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
        }else{
            return redirect()->route('admin.pengurus.index')->with('message', [
                'success' => false,
                'message' => 'User gagal dihapus'
            ]);
        }
    }
}
