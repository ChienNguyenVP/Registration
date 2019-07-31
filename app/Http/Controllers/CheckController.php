<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Approval;

class CheckController extends Controller
{
    public function check(){
        $approval = Approval::where('status',0)->get();
        $reject = Approval::where('status',1)->get();
        $accept = Approval::where('status',2)->get();
        return view('check',['approval' => $approval,
                            'reject' => $reject,
                            'accept' => $accept]);
    }
    public function accept($id){
        $app = Approval::find($id);
        Approval::where('id', $id)->update(['status' =>2]);
        User::where('id', $app->user_id)->update(['role' =>1]);
    }
    public function reject(Request $request, $id){
        $validator = \Validator::make($request->all(), [
            'response' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        Approval::where('id', $id)->update(['status' =>1,
                                            'response' => $request->response]);
        return response()->json(['success'=>'Record is successfully added']);
        
    }
}
