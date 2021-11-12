<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\proyek;
use App\detailUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class ProjectManagerController extends Controller
{
    public function kelolaUser(){
        $semuaUser = User::all()->whereNotIn('role',['projectmanager','pelanggan']);
        $semuaProyek = proyek::all();
        return view('user/userIndex',compact('semuaUser','semuaProyek'));
    }
    public function userTambah(){
        $semuaProyek = proyek::all();
        return view('user/userTambah',compact('semuaProyek'));
    }
    public function userSimpan(Request $request){
        DB::beginTransaction();
        try {
            // dd($request);
            $parts = explode("@",$request->email);
            $username = $parts[0];
            // dd($username);
            $requestData = $request->all();
            $requestData['username'] = $username;
            $requestData['password']=Hash::make($request->sandi);
            $requestData['role'] = $request->jabatan;
            $requestData['proyek_id']=$request->proyek;
            $user = User::create($requestData);
            $user->save();
            $cekUser = User::where('email',$request->email)->first();
            $detail = detailUser::create([
                'user_id'=>$cekUser->id
            ]);
            $detail->save();
            DB::commit();
            return redirect()->route('kelolaUser')->with('status','User berhasil ditambahkan');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Gagal. Pesan Error: '.$ex->getMessage());
        }
        
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
        DB::beginTransaction();
        try {
            User::destroy($id->id);
            $hapusDetail = detailUser::where('user_id',$id->id)->delete();
            DB::commit();
            return redirect()->route('kelolaUser')->with('status','User berhasil dihapus');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Gagal. Pesan Error: '.$ex->getMessage());
        }
    }
}
