<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Approval;

class CheckController extends Controller
{
    protected $approval;
    function __construct(Approval $approval)
    {
        $this->approval = $approval;
    }

    public function check(){
        $approval = $this->approval->where('status',0)->get();
        $reject = $this->approval->where('status',1)->get();
        $accept = $this->approval->where('status',2)->get();
        return view('check',['approval' => $approval,
                            'reject' => $reject,
                            'accept' => $accept]);
    }
    public function accept($id){
        $app = $this->approval->find($id);
        $this->approval->where('id', $id)->update(['status' =>2]);
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
        $this->approval->where('id', $id)->update(['status' =>1,
                                            'response' => $request->response]);
        return response()->json(['success'=>'Record is successfully added']);

    }
}
