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
    protected $approval;
    public function __construct(Approval $approval)
    {
        $this->middleware('auth');
        $this->approval = $approval;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $approval = $this->approval->where('status', '=', 0);
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
        $this->approval->create($app);
        return redirect(route('home'));
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
