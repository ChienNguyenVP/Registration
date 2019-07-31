<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Approval;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $approval = Approval::where('status', '=', 0);
        return view('home', ['approval' => $approval]);
    }
    public function register(Request $request){
        $this->validate($request,
        [
            'item' => 'required',
            'address' => 'required',
            'phone' => 'required|digits:10',
        ],
        [
            'item.required' => 'Bạn chưa nhập này!',
            'address.required' => 'Bạn chưa nhập này!',
            'phone.required' => 'Bạn chưa nhập này!',
            'phone.digits' => 'SĐT phải là số và đủ 10 số bạn ơi!',

        ]);

        $app = array();
        $app['user_id'] = $request->user()->id;
        $app['item'] = $request['item'];
        $app['address'] = $request['address'];
        $app['phone'] = $request['phone'];
        $app['status'] = 0;
        Approval::create($app);
        return redirect(route('home'));    
    }
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
