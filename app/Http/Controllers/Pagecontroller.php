<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Pemilik;
use App\Models\Lahan;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class Pagecontroller extends Controller
{
    public function index()
    {

        $kecamatan = Kecamatan::all();
        $pemilik = Pemilik::all();
        $lahan = Lahan::all();
        $kecamatanCount = array();
        $kecamatanName = array();
        foreach ($kecamatan as $item ) {
            $a = Lahan::where('kecamatan',$item->id)->count();
            array_push($kecamatanCount,$a);
            array_push($kecamatanName,$item->name);
        }
        return view('user.index', compact('kecamatan','pemilik','lahan','kecamatanCount','kecamatanName'));
    }

    public function filter(Request $request)
    {
        if(!empty($request->kecamatan) && !empty($request->tahun)){
            $data = Lahan
            ::join('pemilik', 'pemilik.id','=','lahans.pemilik')
            ->select('lahans.*','pemilik.name as pemilik')->whereIn('kecamatan',$request->kecamatan)->
            whereYear('lahans.created_at',$request->tahun)->get();
        }
        else if(!empty($request->kecamatan) && empty($request->tahun)){
            $data = Lahan::join('pemilik', 'pemilik.id','=','lahans.pemilik')
            ->select('lahans.*','pemilik.name as pemilik')->
            whereIn('kecamatan',$request->kecamatan)->get();
        }
        else if(empty($request->kecamatan) && !empty($request->tahun)){
            $data = Lahan::join('pemilik', 'pemilik.id','=','lahans.pemilik')
            ->select('lahans.*','pemilik.name as pemilik')->
            whereYear('lahans.created_at',$request->tahun)->get();
        }
        if(empty($request->kecamatan) && empty($request->pemilik) && empty($request->tahun)){
            $data = '';
        }
        return response($data);
    }
}
