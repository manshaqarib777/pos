@extends('layouts.master')
@section('title')
{{__('logs.systemActivityLog')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>'','name' => __('logs.logs')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <table class="table table-striped mt-1">
                <caption>logs table</caption>
                <thead>
                    <tr>
                        <th scope="row" class="th-width-15">
                           {{__('logs.time')}}
                        </th>
                        <th scope="row" class="th-width-15">
                            {{__('logs.by')}}
                        </th>
                        <th scope="row" class="th-width-10">
                             {{__('logs.module')}}
                        </th>
                        <th scope="row" class="th-width-20">
                            {{__('logs.reference')}}
                        </th>
                        <th scope="row" class="th-width-50">
                            {{__('logs.description')}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $activity)
                    <tr>
                        <td>
                            <strong><i class="fa fa-history" aria-hidden="true"></i>
                            {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</strong>
                        </td>
                        <td>{{$activity->user->name}}</td>
                        <td>
                            {{$activity->type}}
                        </td>
                        <td>
                            {{$activity->reference}}
                        </td>
                        <td>{{$activity->description}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-right"> {{$logs->links()}}</div>
        </div>
    </div>
</div>
@endsection
