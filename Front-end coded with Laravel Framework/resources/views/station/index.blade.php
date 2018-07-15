@extends('layouts.app')

@section("style")
<style media="screen">
	body {
		background-color: #1b2d4e;
	}
	.col-md-4{
		margin-top:20px;
	}
</style>
@endsection

@section("content")
	<div class="container">

		<div class="row">
			@foreach ($stations as $station)
				<div class="col-md-4">
					<div class="card" style="width: 18rem;">
					<img class="card-img-top" src="{{asset("$station->image")}}" alt="Card image cap">
					<div class="card-body">
						<h5 class="card-title">{{$station->station}} Station</h5>
						<select id="{{$station->id}}" class="form-control bg-info text-white">

							<option selected>5 Minutes</option>
							<option>10 Minutes</option>
							<option>15 Minutes</option>
							<option>20 Minutes</option>
							<option>25 Minutes</option>
							<option>30 Minutes</option>
							<option>35 Minutes</option>
							<option>40 Minutes</option>
							<option>45 Minutes</option>
						</select>
					</div>
				</div>
				</div>
			@endforeach

		</div>

@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function(){
				$("select").on("change",function(){
				var id =	$(this).attr('id');
				var val = $("#" + id + " option:selected").text();
				val = val.split(" ");
				var new_val = val[0];
				alert(new_val);
					$.get('../station/status/update?id=' + id + '&minutes=' + new_val, function(data){
						if(data == "true") {
							console.log("Hello");
						}
					});
		});
});
</script>

@endsection
