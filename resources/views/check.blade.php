@extends('layout')

@section('content')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
              <div class="card-header"><button class="btn btn-primary" id="list_pending">Danh sách duyệt</button> <button class="btn"id="list_reject">Danh sách từ chối</button> <button class="btn" id="list_accept">Danh sách chấp thuận</button></div> 
              <div class="card-body"> 
              	<div id="display_pending">
	              	@if(count($approval)>0)
		              	<table class="table">
		              	    	<thead>
		              	    		<tr>
		              	    			<th></th>
		              	    			<th>Tên Khách Hàng</th>
		              	    			<th>Số điện thoại</th>
		              	    			<th>Mặt hàng</th>
		              	    			<th>Địa chỉ</th>
		              	    			<th>Thời gian</th>
		              	    			<th>Xét duyệt</th>
		              	    		</tr>
		              	    	</thead>
		              	    	<tbody>	
		              	    		@foreach($approval as $key => $app)
			              	    		<tr>
			              	    			<td>{{$loop->iteration}}</td>
			              	    			<td>{{$app->user->name}}</td>
			              	    			<td>{{$app->item}}</td>
			              	    			<td>{{$app->phone}}</td>
			              	    			<td>{{$app->address}}</td>
			              	    			<td>{{$app->created_at}}</td>
			              	    			<td style="display:inline-table;"><button id="accept" data-id={{$app->id}} class="btn accept btn-success"><i class="fa fa-check-circle" aria-hidden="true"></i></button><button style="margin-left: 4px;" id="reject"  data-toggle="modal" data-target="#myModal" data-id={{$app->id}} class="btn btn-danger"><i class="fa fa-times-circle" aria-hidden="true"></i></button></td>
			              	    		</tr>
		              	    		@endforeach
		              	    	</tbody>
		              	    </table>
		              	    <div class="modal fade" id="myModal">
						    <div class="modal-dialog">
						      <div class="modal-content">
						      
						        <div class="modal-header">
						          <h4 class="modal-title">Lý do từ chối</h4>
						          <button type="button" class="close" data-dismiss="modal">&times;</button>
						        </div>
						        <div class="modal-body">
						          <form id="form-response">
									<div class="form-group">
									    <input type="text" class="form-control" id="response">
						        	</div>
									<div class="alert alert-danger" style="display:none"></div>
						        <div class="modal-footer">
						          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						          <button type="submit" class="btn btn-primary"  id="submit" data-id={{$app->id}}>Submit</button>
						        </div>
						        </form>
						        {{-- {{dd('123')}}  --}}
						      </div>
						    </div>
						  </div>	  
              			</div>
	              	    @else
	              	    	<center class="text-warning">Không có đơn đăng ký</center>
	              	    @endif
              	    </div>
              	    <div id="display_accept" style="display: none;">
              	    	@if(count($accept)>0)
	              	     <table class="table">
			              	   <thead>
			              	    	<tr>
			              	    		<th></th>
			              	    		<th>Tên Khách Hàng</th>
			              	    		<th>Số điện thoại</th>
			              	    		<th>Mặt hàng</th>
			              	    		<th>Địa chỉ</th>
			              	    		<th>Thời gian</th>
			              	    		</tr>
			              	    	</thead>
			              	    	<tbody>	
			              	    		@foreach($accept as $key => $acc)
				              	    		<tr>
				              	    			<td>{{$loop->iteration}}</td>
				              	    			<td>{{$acc->user->name}}</td>
				              	    			<td>{{$acc->item}}</td>
				              	    			<td>{{$acc->phone}}</td>
				              	    			<td>{{$acc->address}}</td>
				              	    			<td>{{$acc->created_at}}</td>
				              	    		</tr>
			              	    		@endforeach
			              	    	</tbody>
			              	</table>  
			            @else
			            	<center class="text-warning">Danh sách trống</center> 	
			            @endif  	
		            </div> 
		            <div id="display_reject" style="display: none;"> 	
		            	@if(count($reject)>0)      
	              	      <table class="table">
		              	    	<thead>
		              	    		<tr>
		              	    			<th></th>
		              	    			<th>Tên Khách Hàng</th>
		              	    			<th>Số điện thoại</th>
		              	    			<th>Mặt hàng</th>
		              	    			<th>Địa chỉ</th>
		              	    			<th>Thời gian</th>
		              	    		</tr>
		              	    	</thead>
		              	    	<tbody>	
		              	    		@foreach($reject as $key => $rej)
			              	    		<tr>
			              	    			<td>{{$loop->iteration}}</td>
			              	    			<td>{{$rej->user->name}}</td>
			              	    			<td>{{$rej->item}}</td>
			              	    			<td>{{$rej->phone}}</td>
			              	    			<td>{{$rej->address}}</td>
			              	    			<td>{{$rej->created_at}}</td>
			              	    		</tr>
		              	    		@endforeach
		              	    	</tbody>
		              	    </table> 
						@else
							<center class="text-warning">Danh sách trống</center>
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
      <script>
        	$(document).ready(function(){
            $('.accept').click(function(e){
            	var id = $(this).data("id");
            	var remove = $(this);
               e.preventDefault();
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
               $.ajax({
                  url: "{{ url('/home/accept') }}"+"/"+id,
                  method: 'post',
                  success: function(result){
                  	console.log(result);
                  	remove.closest("tr").remove();
                  }});
               });

            $('#submit').click(function(e){

            	var id = $(this).data("id");
            	var remove = $('#reject');
               e.preventDefault();
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
               $.ajax({
                  url: "{{ url('/home/reject') }}"+"/"+id,
                  method: 'post',
                   data: {
                     response: jQuery('#response').val(),
                  },
                  success: function(data){
                  	if(data.errors){
	                  			$('.alert-danger').show();
	                  			$('.alert-danger').append('<p>'+data.errors+'</p>');
                  	}else{
                  		$('#myModal').modal('toggle');
                  		remove.closest("tr").remove();}                  	
                  }});
               });
            $('#list_reject').click(function(e){
               e.preventDefault();
               		$(this).addClass("btn-primary");
               		$('#list_pending').removeClass("btn-primary");
               		$('#list_accept').removeClass("btn-primary");
              		$('#display_reject').css("display","block");
              		$('#display_pending').css("display","none");
              		$('#display_accept').css("display","none");
               });	
            $('#list_accept').click(function(e){
               e.preventDefault();
               		$(this).addClass("btn-primary");
               		$('#list_reject').removeClass("btn-primary");
               		$('#list_pending').removeClass("btn-primary");
              		$('#display_reject').css("display","none");
              		$('#display_pending').css("display","none");
              		$('#display_accept').css("display","block");
            });  
            $('#list_pending').click(function(e){
               e.preventDefault();
               		$(this).addClass("btn-primary");
               		$('#list_accept').removeClass("btn-primary");
               		$('#list_reject').removeClass("btn-primary");
              		$('#display_pending').css("display","block");
              		$('#display_reject').css("display","none");
              		$('#display_accept').css("display","none");
            });    	
         });	
      </script>
@endsection
