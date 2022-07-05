@extends('layouts.app')
@section('content')
<?php

$genders = \App\Gender::pluck('gender_name', 'gender_id');
$classes = \App\Classification::pluck('class_name', 'class_id');
$regions = \App\Region::pluck('region_name', 'region_id');
$province = \App\Province::where('regionId',5)->orderBy('name','ASC')->get();
$municipality = \App\Municipality::orderBy('name','ASC')->get();
$days = ['1st Day' => '1st Day', '2nd Day' => '2nd Day', '3rd Day' => '3rd Day'];
// var_dump($province);
// die();
//$msg = realpath(public_path('uploads/barcodes/')).DIRECTORY_SEPARATOR.'barcode.jpg';
?>


<div class="container reg-form">
	
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
	
	<script type="text/javascript" src=""></script>
	<div class="row clearfix">
		<div class="col-sm left-panel">
			<h5>
				<b><center>
				{{ $event->event_title }} Attendee List
				<?php
				$desc = trim($event->event_desc.'');
				if (strlen($desc) > 0){
				 ?>
				<small><br>{{ nl2br($event->event_desc.'') }}</small>
				<?php 
				}
				?>
				</center></b>
			</h5>

             <div class="col-md-12" id="verifyuser">
                @if(session('success'))
                <div class="alert alert-warning">
                    {{session('success')}}
                    <button class="close" onclick="document.getElementById('verifyuser').style.display='none'">x</button>
                </div>
                @endif
            </div>

		<table id="example" class="table table-striped table-bordered table-condensed table-hover small" width="100%" style="width:100%">
        <thead>
            <tr><th>Barcode ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Company </th>
                <th>Designation</th>
                <th>Region</th>
                <th>Date Added</th>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
        	@foreach($attendees as $id => $attendee)
        		<tr>
        			<td>{{$attendee->vis_code}}</td>
        			<td>{{$attendee->vis_fname}} {{$attendee->vis_lname}}</td>
        			<td>{{$attendee->vis_email}}</td>
        			<td>{{$attendee->vis_gsm ?? '---'}}</td>
        			<td>{{$attendee->vis_company ?? '---'}}</td>
        			<td>{{$attendee->vis_designation ?? '---'}}</td>
        			<td>{{$attendee->regions->region_name}}</td>

        			<td><span class="badge badge-secondary">{{Carbon\Carbon::CreateFromFormat('Y-m-d H:i:s', $attendee->created_at)->format('F j, Y | G:i:A')}}</span></td>
                    <td>
                        <div class="btn btn-group ">
                            <a href="#" class="btn btn-success btn-sm" title="Edit Details" data-target="#editvisitor{{$attendee->vis_id}}" data-toggle="modal"><span class="fa fa-edit"></span></a>
                            <a href="{{route('sendconfirmation', ['id' => $attendee->vis_id])}}" class="btn btn-warning btn-sm" title="Send Email" onclick="return confirm('Are you sure you want to send email confirmation to {{$attendee->vis_fname}} {{$attendee->vis_lname}}?')"><span class="fa fa-envelope"></span></a>
                             <a href="#" class="btn btn-danger btn-sm" title="Remove from List"><span class="fa fa-trash"></span></a>
                        </div></td>
        		</tr>
        	@endforeach
         </tbody>
    </table>
			
		</div>
		
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
    $('#example').DataTable();
});
</script>

@foreach($attendees as $id => $attendee)
    <!-- Modal -->
    <div class="modal fade" id="editvisitor{{$attendee->vis_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Registrants</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          
           <form action="{{route('updateregistrant', ['id' => $attendee->vis_id])}}" method="POST" enctype="multipart/form-data">

              {{ csrf_field() }}

              <div class="form-group">
                <label for="exampleInputPassword1">Barcode:</label>
               <input type="text" name="barcode" class="form-control" required value="{{$attendee->vis_code}}">
            </div>

              <div class="form-group">
                <label for="exampleInputPassword1">First Name:</label>
               <input type="text" name="fname" class="form-control" required value="{{$attendee->vis_fname}}">
            </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Middle Initial:</label>
               <input type="text" name="mname" class="form-control" required value="{{$attendee->vis_mname}}">
            </div>
        
              <div class="form-group">
                <label for="exampleInputPassword1">Last Name:</label>
               <input type="text" name="lname" class="form-control" required value="{{$attendee->vis_lname}}">
            </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Email:</label>
               <input type="text" name="email" class="form-control" required value="{{$attendee->vis_email}}">
            </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Designation:</label>
               <input type="text" name="designation" class="form-control" required value="{{$attendee->vis_designation}}">
            </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Company:</label>
               <input type="text" name="company" class="form-control" required value="{{$attendee->vis_company}}">
            </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Region:</label>
                <select class="form-control" required="" name="region">
                    <option value="{{$attendee->region_id}}">{{$attendee->regions->region_name}}</option>

                    @foreach($regions as $id => $region)
                        <option value="{{$id}}">{{$region}}</option>
                    @endforeach

                </select>
            </div>


        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Save Changes</button>
        </div>

    </form>

          </div>
        
        </div>
      </div>
    </div>
@endforeach

@endsection
