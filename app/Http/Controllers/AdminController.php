<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Pemilik;
use App\Models\Lahan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $lahan = Lahan::all();
        $kecamatan = Kecamatan::all();
        $pemilik = Pemilik::all();
        return view('admin.dashboard', compact('lahan','kecamatan','pemilik'));
    }

    public function mapFilter(Request $request)
    {
        return response($request->all);
    }

    public function profile()
    {
        $user = User::find(Auth::id());
        return view('admin.profile',compact('user'));
    }

    public function lahan()
    {
        $data = Lahan::all();
        return view('admin.lahan',compact('data'));
    }

    public function user()
    {
        return view('admin.user');
    }

    public function data()
    {
        $kecamatan = Kecamatan::all()->sortByDesc('created_at');
        $pemilik = Pemilik::all()->sortByDesc('created_at');
        $kecamatanCount = array();
        $pemilikCount = array();
        foreach ($kecamatan as $item ) {
            $a = Lahan::where('kecamatan',$item->id)->count();
            array_push($kecamatanCount,$a);
        }
        foreach ($pemilik as $item ) {
            $a = Lahan::where('pemilik',$item->id)->count();
            array_push($pemilikCount,$a);
        }
        return view('admin.data', compact('kecamatan','pemilik','kecamatanCount','pemilikCount'));
    }

}
