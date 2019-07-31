@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- {{dd(Auth::user()->approvalStatusPending)}} --}}
                @if(Auth::user()->role==0)
                {{-- {{dd(Auth::user()->approvalStatusPending)}} --}}
                        <div class="card-header">Chào {{Auth::user()->name}}! Bạn là một khác hàng của Chiến Đẹp Zai.</div>
                    @if(count(Auth::user()->approvalStatusPending)) 
                        <center class="text-warning">Yêu cầu của bạn đang được chờ xét duyệt <button data-toggle="modal" data-target="#myModal" class="btn btn-warning">Xem đơn đã đăng ký</button></center>
                        <center><button type="button" class="btn btn-primary"><a style="color: white;" href="{{url('/home')}}">Làm mới</a></button></center>
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                              <div class="modal-content">
                              
                                <!-- Modal Header -->
                                <div class="modal-header">
                                  <h4 class="modal-title">Đơn của bạn</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>                  
                                <!-- Modal body -->
                                <div class="modal-body">
                                  <table class="table">
                                      <tbody>
                                        @foreach(Auth::user()->approvalStatusPending as $pending)
                                        <thead>
                                            <tr>
                                              <th scope="col">Thời gian</th>
                                              <th scope="col">Mặt hàng</th>
                                              <th scope="col">SĐT</th>
                                              <th scope="col">Địa chỉ</th>
                                            </tr>
                                          </thead>
                                        <tr>
                                          <th>{{$pending->created_at}}</th>
                                          <td>{{$pending->item}}</td>
                                          <td>{{$pending->phone}}</td>
                                          <td>{{$pending->address}}</td>
                                        </tr>
                                        @endforeach
                                      </tbody>
                                    </table>   
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                                
                              </div>
                            </div>
                          </div>
                    @elseif(count(Auth::user()->approvalStatusReject))                  
                        <center class="text-danger">Xin lỗi {{Auth::user()->name}}! Có vẻ bạn không đủ điều kiện để đi bán hàng rong. <button data-toggle="modal" data-target="#myModal" type="button" class="btn btn-danger">Xem phản hồi</button></center>
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                              <div class="modal-content">
                              
                                <!-- Modal Header -->
                                <div class="modal-header">
                                  <h4 class="modal-title">Phản Hồi</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                    <table class="table">
                                      <tbody>
                                        @foreach(Auth::user()->approvalStatusReject as $reject)
                                        <tr>
                                          <th>{{$reject->created_at}}</th>
                                          <td>{{$reject->response}}</td>
                                        </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                <!-- Modal body -->
                                <div class="modal-body">
                                    
                                </div>
                                    
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                                
                              </div>
                            </div>
                          </div>
                        <div class="card-body">
                            <form class="register-form" method="POST" action="home">
                                    <input type="hidden" name="_token" id="" value="{{csrf_token()}}">
                                    <center class="text-primary">Tiếp tục đăng ký vào hội bán hàng rong</center>
                                  <div class="form-group">
                                    <label for="">Loại mặt hàng</label>
                                    <input type="text" name="item" value="{{ old('item') }}" class="form-control" placeholder="Mặt hàng" >
                                    @if ($errors->has('item'))
                                        <p class="text-danger">
                                          {{ $errors->first('item') }}
                                         </p>
                                    @endif
                                  </div>
                                  <div class="form-group">
                                    <label for="">Địa chỉ</label>
                                    <input type="text" name="address"  value="{{ old('address') }}" class="form-control" id="" placeholder="Địa chỉ">
                                    @if ($errors->has('address'))
                                        <p class="text-danger">
                                          {{ $errors->first('address') }}
                                         </p>
                                    @endif
                                  </div>
                                  <div class="form-group">
                                    <label for="">Số điện thoại</label>
                                    <input type="number" name="phone" value="{{ old('phone') }}" class="form-control" id="" placeholder="Số điện thoại">
                                    @if ($errors->has('phone'))
                                        <p class="text-danger">
                                          {{ $errors->first('phone') }}
                                         </p>
                                    @endif
                                  </div>              
                                  <button type="submit" class="btn btn-primary register">Đăng ký</button>
                                </form>
                            </div>    
                    @else
                        <div class="card-body">
                           {{--  @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif --}}
                            <form class="register-form" method="POST" action="home">
                                <input type="hidden" name="_token" id="" value="{{csrf_token()}}">
                                <center class="text-primary">Đăng ký ngay để đi bán hàng rong cùng CDZ</center>
                              <div class="form-group">
                                <label for="">Loại mặt hàng</label>
                                <input type="text" name="item" class="form-control" value="{{ old('item') }}" placeholder="Mặt hàng">
                                @if ($errors->has('item'))
                                        <p class="text-danger">
                                          {{ $errors->first('item') }}
                                        </p>
                                @endif
                              </div>
                              <div class="form-group">
                                <label for="">Địa chỉ</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Địa chỉ">
                                @if ($errors->has('address'))
                                        <p class="text-danger">
                                          {{ $errors->first('address') }}
                                        </p>
                                @endif
                              </div>
                              <div class="form-group">
                                <label for="">Số điện thoại</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" id="" placeholder="Số điện thoại">
                                @if ($errors->has('phone'))
                                        <p class="text-danger">
                                          {{ $errors->first('phone') }}
                                        </p>
                                @endif
                              </div>              
                              <button type="submit" class="btn btn-primary register">Đăng ký</button>
                            </form>
                        </div>
                    @endif    
                    
                @endif
                @if(Auth::user()->role==1)
                    <div class="card-header">Chào {{Auth::user()->name}} ! Mau lấy đồ ra phố bán hàng đi nào. </div>
                    @if(count(Auth::user()->approvalStatusAccept))
                            <center class="text-success">Chúc mừng! Đội bán hàng rong của CDZ đã có thêm bạn.</center>
                    @endif        
                @endif
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous">
</script>
@endsection
