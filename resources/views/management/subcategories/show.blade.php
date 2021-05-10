@extends('layouts.master')

@section('title')
 {{__('manage.subcategory.detail')}}
@endsection

@push('breadcrumbs')
@include('partials.breadcrumbs',['links'=> [
['url' =>route('subcategory.index'),'name' => __('manage.manage')],
['url' =>'','name' => __('manage.subcategory')],
]])
@endpush
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-body text-default">
      <div class="row mb-3">
        <div class="col-md-12">
          <h1>
         {{__('manage.name')}} {{$subcategory->name}}
          </h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 text-center">
           @include('partials.upload',[
         'routeLink'=>route('subcategory.image'),
         'nameId'=>'subcategory_id',
         'item'=> $subcategory]
         )
          <h3>{{__('manage.subcategory.description')}}:</h3>
          <div class="text-justify p-2">
            {{$subcategory->detail}}
          </div>
        </div>
        <div class="col-md-8">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="subcategory-info-tab" data-toggle="tab" href="#subcategory-info" role="tab" aria-controls="subcategory-info" aria-selected="true">{{__('manage.information')}}</a>
              <a class="nav-item nav-link" id="subcategory-product-tab" data-toggle="tab" href="#subcategory-product" role="tab" aria-controls="subcategory-product" aria-selected="false">{{__('manage.products')}}</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="subcategory-info" role="tabpanel" aria-labelledby="subcategory-info-tab">
               @include('partials.buttons',[
                  'allLink'=>route('subcategory.index'),
                  'editLink'=>route('subcategory.edit',$subcategory->id),
                  'destroyLink' =>route('subcategory.destroy',$subcategory->id)
              ])
              <table class="table table-bordered table-striped">
                <caption> {{__('manage.added.on')}}</caption>
                <tr>
                  <th scope="row" class="th-width-20">{{__('manage.created.on')}}</th>
                  <td>{{$subcategory->created_at}}</td>
                </tr>
                <tr>
                  <th scope="row">{{__('manage.code')}}</th>
                  <td>{{$subcategory->code}}</td>
                </tr>
              </table>
              <table class="table table-bordered table-striped">
                <caption>Category parent info</caption>
                <tr>
                  <th scope="row" class="th-width-20">{{__('manage.parent.category')}}</th>
                  <td>{{$subcategory->category->name}}
                    <a title="{{__('common.view.info')}}" href="{{route('category.show',$subcategory->category->id)}}">
                      <i class="fa fa-link" aria-hidden="true"></i>
                    </a>
                  </td>
                </tr>
                <tr>
                  <th scope="row"> {{__('manage.contains.products')}}</th>
                  <td>{{$subcategory->products->count()}}</td>
                </tr>
              </table>
            </div>
            <div class="tab-pane fade" id="subcategory-product" role="tabpanel" aria-labelledby="subcategory-product-tab">
             @include('partials.products.list',['products'=>$subcategory->products])
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@include('partials.pageUrl',['pageLink'=>route('subcategory.index')])

