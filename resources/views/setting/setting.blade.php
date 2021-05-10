@extends('layouts.master')
@section('title')
{{__('settings.systemConfiguration')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>'','name' => __('settings.systemConfiguration')],
]])
@endpush
@section('content')
<div class="col-md-12">
	<div class="card">
		<div class="card-body">
			<div>
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="setting-general-tab" data-toggle="tab" href="#setting-general" role="tab" aria-controls="setting-general" aria-selected="true">{{__('settings.general')}}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="setting-logo-tab" data-toggle="tab" href="#setting-logo" role="tab" aria-controls="setting-logo" aria-selected="false"> {{__('settings.logo')}}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="setting-mail-tab" data-toggle="tab" href="#setting-mail" role="tab" aria-controls="setting-mail" aria-selected="false"> {{__('settings.mail')}}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="Product-conf-tab" data-toggle="tab" href="#Product-conf" role="tab" aria-controls="Product-conf" aria-selected="false"> {{__('settings.productDefaults')}}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="Impects-conf-tab" data-toggle="tab" href="#Impects-conf" role="tab" aria-controls="Impects-conf" aria-selected="false"> {{__('settings.inventoryImpacts')}}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="pos-conf-tab" data-toggle="tab" href="#pos-conf" role="tab" aria-controls="pos-conf" aria-selected="false">{{__('settings.pos')}}
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="logs-tab" data-toggle="tab" href="#logs" role="tab" aria-controls="logs" aria-selected="false">
						 {{__('settings.activityLogs')}}
					</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active p-2" id="setting-general" role="tabpanel" aria-labelledby="setting-general-tab">
						<setting-tab v-bind:setting="{{$setting}}" v-bind:groups="{{$groups}}"></setting-tab>
					</div>
					<div class="tab-pane fade p-2" id="setting-logo" role="tabpanel" aria-labelledby="setting-logo-tab">
						<div class="card-body">
							@include('partials.upload',['item'=>$setting,'routeLink'=>route('setting.image')])
						</div>
					</div>
					<div class="tab-pane fade p-2" id="setting-mail" role="tabpanel" aria-labelledby="setting-mail-tab">
						@if($setting->demo === 'active')
						<div class="text-center p-5">
							<strong><i class="fa fa-lock fa-lg" aria-hidden="true"></i>  Demo Mode</strong>
							<p>Protecting Mail Credentials Publicly ! </p>
						</div>
						@else
						<mail-conf v-bind:setting="{{$setting}}"></mail-conf>
						@endif
					</div>
					<div class="tab-pane fade p-2" id="Product-conf" role="tabpanel" aria-labelledby="Product-conf-tab">
						<div class="card-body">
						<product-config v-bind:taxes="{{$taxes}}" v-bind:setting="{{$setting}}"></product-config>
					</div>
				</div>
				<div class="tab-pane fade p-2" id="Impects-conf" role="tabpanel" aria-labelledby="Impects-conf-tab">
					<div class="card-body">
						<impact-config v-bind:taxes="{{$taxes}}" v-bind:setting="{{$setting}}"></impact-config>
					</div>
				</div>
				<div class="tab-pane fade p-2" id="pos-conf" role="tabpanel" aria-labelledby="pos-conf-tab">
					<div class="card-body">
					<pos-config v-bind:categories="{{$categories}}" v-bind:payments="{{$gateways}}" v-bind:customers="{{$customers}}" v-bind:taxes="{{$taxes}}" v-bind:setting="{{$setting}}"></pos-config>
				</div>
			</div>
			<div class="tab-pane fade p-2" id="logs" role="tabpanel" aria-labelledby="logs-tab">
				<div class="card-body">
					<form class="form" action="{{route('logs.update')}}" method="post">
						{{csrf_field()}}
						<div class="form-group">
							<label>{{__('settings.users')}}</label>
							<select class="form-control selectpicker" data-live-search="true" data-style="form-control" name="user">
								@foreach($users as $user)
								<option value="{{$user->id}}">Mr. {{$user->name}}  ({{$user->email}})  ------- {{$user->group->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>{{__('settings.actions')}}</label>
							<select class="form-control selectpicker" data-live-search="true" data-style="form-control" name="log_action">
								<option value="" disabled="" selected="">{{__('settings.selectAction')}}</option>
								<option value="0"> {{__('settings.startRecoding')}}</option>
								<option value="1"> {{__('settings.stopRecoding')}}</option>
							</select>
						</div>
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="clear_log"  name="clear_log" value="1">
								<label class="custom-control-label" for="clear_log">{{__('settings.clearLogActivity')}}</label>
							</div>
						</div>
						<button class="btn btn-info m-3">{{__('common.save')}}</button>
					</form>
				</div>
				<div class="card-body bg-warning p-3">
					<form class="form" action="{{route('logs.clear')}}" method="post">
						{{csrf_field()}}
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="agree"  name="agree" value="1" required>
								<label class="custom-control-label" for="agree">{{__('settings.clearAgree')}}</label>
							</div>
						</div>
						<button class="btn btn-info m-3">{{__('settings.clearAllActivityLogs')}}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
@endsection
