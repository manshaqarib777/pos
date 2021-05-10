@extends('layouts.master')
@section('title')
{{ __('manage.country.detail')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>route('country.index'),'name' => __('manage.manage')],
['url' =>'','name' => __('manage.country')],
]])
@endpush
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-body text-default">
      <div class="row mb-3">
        <div class="col-md-12">
          <h1>
          {{__('manage.name')}} {{$country->name}}
          </h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{__('manage.information')}}</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
              @include('partials.buttons',[
              'allLink'=>route('country.index'),
              'editLink'=>route('country.edit',$country->id),
              'destroyLink' =>route('country.destroy',$country->id)
              ])
              <table class="table table-bordered table-striped">
                <caption>Country Information</caption>
                <tr>
                  <th scope="row" class="th-width-20">{{__('manage.created.on')}}</th>
                  <td>{{$country->created_at}}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('partials.pageUrl',['pageLink'=>route('country.index')])
@endsection
