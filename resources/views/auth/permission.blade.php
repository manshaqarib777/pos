@extends('layouts.master')

@section('title')
{{__('group.permissions')}}
@endsection

@push('breadcrumbs')
@include('./partials.breadcrumbs',['group'=>__('user.users'),'links'=> [
['url' =>route('group.index'),'name' => __('group.manageGroup')],
['url' =>'','name' => __('group.groupPermissions')],
]])
@endpush

@section('content')
<div class="col-md-12">
    <div class="card card-round">
        <div class="card-body">
            <form action="{{route('permission.update',$per->id)}}" method="post">
                {{csrf_field()}}
                {{ method_field('PATCH') }}
               @include('./partials/permission',['per'=>$per])
                <a href="{{url()->previous()}}" class="no-print pos btn btn-info">{{__('common.back')}}</a>
                <input type="submit" value="{{__('common.update')}}" class="btn btn-success">
            </form>
        </div>
    </div>
</div>
@include('./partials.pageUrl',['pageLink'=>route('group.index')])
@endsection
