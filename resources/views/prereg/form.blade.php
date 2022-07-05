@extends('layouts.prereg_layout')
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
	@if (strlen($msg) > 0)
	<div class="alert alert-info">{{ $msg }}</div>
	@endif
	<div class="row clearfix">
		<div class="col-sm left-panel">

			<div class="col-sm">
				<img src="{{ asset('uploads/15thpnhrs.jpg') }}" class="img-fluid">
			</div>
			<hr>
			<h5>
				<b><center>
				{{ $event->event_title }} Registration Form
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

			{!! Form::model($row, ['id' => 'prereg-form', 'name' => 'prereg-form', 'url' => URL::to('save'), 'class' => 'form', 'role' => 'form', 'autocomplete' => 'off']) !!}
			<div class="row">
				<div class="form-group col">
					{!! Form::label('vis_lname', 'Last Name', array('class' => 'text-nowrap')) !!}
					<span class="text-danger"><small>{{ $errors->first('vis_lname') }}</small></span>
					{!! Form::text('vis_lname', NULL, ['id' => 'vis_lname', 'class'=>'form-control', 'required', 'maxlength'=>255]) !!}
				</div>

				<div class="form-group col">
					{!! Form::label('vis_fname', 'First Name', array('class' => 'text-nowrap')) !!}
					<span class="text-danger"><small>{{ $errors->first('vis_fname') }}</small></span>
					{!! Form::text('vis_fname', NULL, ['id' => 'vis_fname', 'class'=>'form-control', 'required', 'maxlength'=>255]) !!}
				</div>

				<div class="form-group col">
					{!! Form::label('vis_mname', 'Middle Name', array('class' => 'text-nowrap')) !!}
					{!! Form::text('vis_mname', NULL, ['id' => 'vis_mname', 'class'=>'form-control', 'maxlength'=>255]) !!}
				</div>
			</div>

			<div class="row">
				<div class="form-group col">
					{!! Form::label('vis_email', 'Email') !!}
					<span class="text-danger"><small>{{ $errors->first('vis_email') }}</small></span>
					{!! Form::email('vis_email', NULL, ['id' => 'vis_email', 'class'=>'form-control', 'maxlength'=>255]) !!}
					
				</div>
				<div class="form-group col">
					{!! Form::label('vis_gsm', 'Mobile Number') !!}
					<span class="text-danger"><small>{{ $errors->first('vis_gsm') }}</small></span>
					{!! Form::text('vis_gsm', NULL, ['id' => 'vis_gsm', 'class'=>'form-control', 'maxlength'=>255]) !!}
					
				</div>
			</div>

			<div class="row">
				<div class="form-group col">
					{!! Form::label('vis_age', 'Age') !!}
					<span class="text-danger"><small>{{ $errors->first('vis_age') }}</small></span>
					{!! Form::number('vis_age', NULL, ['class'=>'form-control', 'maxlength'=>'3', 'min'=>'1', 'max'=>'200', 'required']) !!}
				</div>

				<div class="form-group col">
					{!! Form::label('gender_id', 'Sex') !!}
					{!! Form::select('gender_id', $genders, NULL, ['class'=>'form-control']) !!}
				</div>
			</div>

			<!-- added by JM -->
			<div class="row">
				<div class="form-group col">
					{!! Form::label('vis_designation', 'Designation') !!}
					<span class="text-danger"><small>{{ $errors->first('vis_designation') }}</small></span>
					{!! Form::text('vis_designation', NULL, ['class'=>'form-control', 'max'=>'200', 'required']) !!}
				</div>

			</div>
			<!-- --------------- -->

			<div class="row">
				<div class="form-group col">
					{!! Form::label('vis_company', 'Company / Institution', array('class' => 'text-nowrap')) !!}
					{!! Form::text('vis_company', NULL, ['id' => 'vis_company', 'class'=>'form-control', 'maxlength'=>255]) !!}
				</div>
				<div class="form-group col">
					{!! Form::label('class_id', 'Classification') !!}
					{!! Form::select('class_id', $classes, NULL, ['class'=>'form-control']) !!}
				</div>
			</div>

			<div class="row">
				<div class="form-group col">
					{!! Form::label('region_id', 'Region') !!}
					{!! Form::select('region_id', $regions, NULL, ['class'=>'form-control']) !!}
				</div>
			</div>
			<div class="row">
				<div class="form-group col">
					{!! Form::label('vis_province', 'Province', array('class' => 'control-label')) !!}
					<select name="vis_province" id="vis_province" class="form-control">
					  <option value="">Please Select</option>	
					  @foreach($province as $prov)
					    <option value="{{ $prov->id }}">{{ $prov->name }}</option>
					  @endforeach
					</select>
				</div>
				<div class="form-group col">
					{!! Form::label('vis_municipality', 'Municipality/City', array('class' => 'control-label')) !!}
					<select name="vis_municipality" id="vis_municipality" class="form-control">
					  <option value="">Please Select</option>	
					  @foreach($municipality as $mun)
					    <option value="{{ $mun->id }}">{{ $mun->name }}</option>
					  @endforeach
					</select>
				</div>		
			</div>

			<div class="row">
				<div class="form-group col">
					{!! Form::label('vis_address', 'Address') !!}
					<span class="text-danger"><small>{{ $errors->first('vis_address') }}</small></span>
					{!! Form::text('vis_address', NULL, ['id' => 'vis_address', 'class'=>'form-control', 'maxlength'=>255]) !!}
					
				</div>
			</div>
			<!--
			<div class="row">
				<div class="form-group col-sm-12">
					{!! Form::label('vis_day', 'I plan to attend on the ') !!}
					{!! Form::select('vis_day', $days, NULL, ['class'=>'form-control']) !!}
				</div>
			</div>
			-->
			{{ csrf_field() }}
			{!! Form::submit('Register' , ['class'=>'btn btn-primary btn-block btn-raised', 'data-confirm' => 'Are you sure you want to register him/her? This will send email-confirmation with barcode.']) !!}
			{!! Form::hidden('vis_batch', NULL) !!}
			{!! Form::hidden('vis_serial', NULL) !!}
			{!! Form::hidden('event_id', NULL) !!}
			{!! Form::close() !!}
		</div>
		<!-- <div class="col-sm text-right">
			<img src="{{ asset('uploads/'.$event->event_image) }}" class="img-fluid">
		</div> -->
	</div>
</div>
@endsection
