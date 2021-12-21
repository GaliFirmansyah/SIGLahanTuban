<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Pemilik;
use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


class LahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Lahan::all()->sortByDesc('created_at');
        return view('admin.lahan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kecamatan = Kecamatan::all();
        $pemilik = Pemilik::all();
        return view('admin.lahan.create',compact('kecamatan','pemilik'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'alamat' => 'required',
            'pemilik' => 'required',
            'kecamatan' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        Lahan::create($request->all());
        Alert::success('Towers Created', 'Success Message');
        return redirect()->route('lahan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function show(Lahan $lahan)
    {
        $lahanDataKecamatan = DB::table('lahans')->select('kecamatan')->groupBy('kecamatan')->get();
        $lahanDataPemilik = DB::table('lahans')->select('pemilik')->groupBy('pemilik')->get();
        $kecamatan = array();
        $pemilik = array();
        foreach ($lahanDataKecamatan as $item ) {
            array_push($kecamatan,$item->kecamatan);
        }
        foreach ($lahanDataPemilik as $item ) {
            array_push($pemilik,$item->pemilik);
        }
        return view('admin.lahan.show',compact('lahan','kecamatan','pemilik'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function edit(Lahan $lahan)
    {
        $kecamatan = Kecamatan::all();
        $pemilik = Pemilik::all();
        return view('admin.lahan.edit',compact('lahan','kecamatan','pemilik'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lahan $lahan)
    {
        $request->validate([
            'alamat' => 'required',
            'pemilik' => 'required',
            'kecamatan' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        Lahan::find($lahan->id)->update($request->all());
        Alert::success('Towers Updated', 'Success Message');
        return redirect()->route('lahan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lahan $lahan)
    {
        Lahan::destroy($lahan->id);
        Alert::success('Towers Deleted', 'Success Message');
        return redirect()->route('lahan.index');
    }
}
