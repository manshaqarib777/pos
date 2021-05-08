@extends('layouts.master')
@section('title')
{{__('manage.expense.detail')}}
@endsection
@push('breadcrumbs')
@include('./partials.breadcrumbs',['links'=> [
['url' =>route('expense.index'),'name' => __('manage.manage')],
['url' =>'','name' => __('manage.expense')],
]])
@endpush
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <table class="table table-bordered">
                        <caption>Expense Details</caption>
                        <tr>
                            <th scope="row" class="th-width-50">{{__('common.reference')}}</th>
                            <td>{{$expense->reference}}</td>
                        </tr>
                        <tr>
                            <th scope="row" >{{__('common.date')}}</th>
                            <td>{{$expense->created_at}}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                @section('buttons')
                                <a class="btn btn-sm btn-default" title="{{__('common.print')}}" href="{{route('expense.print',$expense->id)}}" ><i class="fa fa-print fa-fw" aria-hidden="true"></i>{{__('common.print')}}</a>
                                @endsection
                                @include('./partials.buttons',[
                                'allLink'=>route('expense.index'),
                                'editLink'=>route('expense.edit',$expense->id),
                                'destroyLink' =>route('expense.destroy',$expense->id)
                                ])
                            </td>
                        </tr>
                        <tr class="bg-warning text-white">
                            <th scope="row" colspan="2">{{__('manage.by')}}</th>
                        </tr>
                        <tr>
                            <th scope="row">{{__('manage.name')}}</th>
                            <td>{{$expense->by}}</td>
                        </tr>
                    </table>
                    <form action="{{route('expense.image')}}" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        <input type="file" class="mt-3 form-control @error('attachment') is-invalid @enderror" name="attachment" >
                        @error('attachment')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <input type="hidden" name="expense_id" value="{{$expense->id}}">
                        <button type="submit" class="btn btn-sm btn-block mt-1">{{__('common.upload')}}</button>
                    </form>
                </div>
                <div class="col-md-8">
                    <h1 class="text-center">{{__('manage.details')}}</h1>
                    <table class="table table-bordered">
                        <caption>Expense Amount details</caption>
                        <tr>
                            <th scope="row" class="th-width-20">{{__('manage.amount')}}</th>
                            <td>{{$expense->amount}}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{__('manage.type')}}</th>
                            <td>{{$expense->type}}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center bg-info text-white">{{__('manage.attachment')}}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                <img src="{{asset('storage/'.$expense->attachment)}}" alt="attachment" class="attach-expense">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('./partials.pageUrl',['pageLink'=>route('expense.index')])
@endsection
