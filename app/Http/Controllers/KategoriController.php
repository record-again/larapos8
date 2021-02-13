<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori; //Model

class KategoriController extends Controller
{
    public function __construct()
    {
        //
    }
    public function list()
    {
        $data = Kategori::all()->sortByDesc('created_at');
        return view('admin/listkategori', ['kategori' => $data]);
    }

    public function form()
    {
        return view('admin/formkategori');
    }

    public function insert(Request $request)
    {
        $messages = [
            'nama_kategori.required' => 'Nama Kategori Harus Di Isi',
            'nama_kategori.unique' => 'Nama Kategori Sudah Tersedia',
        ];

        $validated = $request->validate([
            'nama_kategori' => 'required|unique:kategori|max:255'
        ], $messages);

        $kategori = new Kategori;
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return redirect('/kategori')->with('pesaninput', $request->nama_kategori.' Berhasil Ditambah');
    }

    public function edit($id)
    {
        $data = Kategori::find($id);
        if(!$data)
            abort(404);
        return view('admin/editkategori', ['kategori' => $data]);
    }

    public function update(Request $request, $id)
    {
        // $messages = [
        //     'nm_cat.required' => 'Nama Kategori Harus Di Isi',
        // ];

        // $validated = $request->validate([
        //     'nm_cat' => 'required|unique:posts|max:255'
        // ], $messages);

        $kategori = Kategori::find($id);
        if(!$kategori)
            abort(404);
        $kategori->nama_kategori = $request->nm_cat;
        $kategori->save();

        return redirect('/kategori')->with('pesanupdate', $request->nm_cat.' Berhasil Di Update');
        
    }

    public function delete($id)
    {
        $kategori = Kategori::find($id);
        if(!$kategori)
            abort(404);
        $kategori->delete();

        return redirect('/kategori')->with('pesandelete', $kategori->nama_kategori.' Berhasil Di Hapus');
    }
}
