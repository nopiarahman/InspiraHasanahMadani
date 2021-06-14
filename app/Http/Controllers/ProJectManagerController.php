<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\proyek;
use App\detailUser;

use Illuminate\Support\Facades\Hash;
class ProJectManagerController extends Controller
{
    public function kelolaUser(){
        $semuaUser = user::all()->whereNotIn('role',['projectmanager','pelanggan']);
        $semuaProyek = proyek::all();
        return view('user/userIndex',compact('semuaUser','semuaProyek'));
    }
    public function userTambah(){
        $semuaProyek = proyek::all();
        return view('user/userTambah',compact('semuaProyek'));
    }
    public function userSimpan(Request $request){
        // dd($request);
        $parts = explode("@",$request->email);
        $username = $parts[0];
        // dd($username);
        $requestData = $request->all();
        $requestData['username'] = $username;
        $requestData['password']=Hash::make($request->sandi);
        $requestData['role'] = $request->jabatan;
        $requestData['proyek_id']=$request->proyek;
        $user = user::create($requestData);
        $user->save();
        $cekUser = user::where('email',$request->email)->first();
        $detail = detailUser::create([
            'user_id'=>$cekUser->id
        ]);
        $detail->save();
        return redirect()->route('kelolaUser')->with('status','User berhasil ditambahkan');
    }
    public function userEdit(User $id, Request $request){
        // dd($request);
        $parts = explode("@",$request->email);
        $username = $parts[0];
        // dd($username);
        $requestData = $request->all();
        $requestData['username'] = $username;
        $requestData['password']=Hash::make($request->sandi);
        $requestData['role'] = $request->jabatan;
        $requestData['proyek_id']=$request->proyek;

        $id->update($requestData);
        return redirect()->route('kelolaUser')->with('status','User berhasil diedit');
    }
    public function hapusUser(User $id){
        user::destroy($id->id);
        $hapusDetail = detailUser::where('user_id',$id->id)->delete();
        return redirect()->route('kelolaUser')->with('status','User berhasil dihapus');
    }
}
