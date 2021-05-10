@extends('layouts.master')
@section('title')
 {{__('group.dedicatedPermissionsRequests')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['group'=>__('group.groups'),'links'=> [
['url' =>'','name' =>__('group.manageGroupRequests')],
]])
@endpush
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <caption>Dedicated Permissions</caption>
          <thead class="bg-warning">
            <tr>
              <th scope="row" class="th-width-15">
                {{__('group.createdOn')}}
              </th>
              <th scope="row" class="th-width-20">
                {{__('group.temporaryGroupName')}}
              </th>
              <th scope="row" class="th-width-50" >
                  {{__('group.requestReason')}}
              </th>
              <th scope="row" class="th=th-width-5">
                {{__('group.action')}}
              </th>
            </tr>
          </thead>
          <tbody>
          @if(count($requests))
            @foreach($requests as $key => $group)
            <tr>
              <td>{{$group->created_at}}</td>
              <td>{{$group->name}}</td>
              <td>{{$group->note}}</td>
              <td>
                <div class="btn-group">
                  <a class="btn text-success p-0" title="Change Permissions" href="{{route('permission.edit',$group->permissions->id)}}" >
                    <i class="fa fa-lock fa-fw" aria-hidden="true"></i>
                  </a>
                  <a class="btn text-info p-0" title="Request from" href="{{route('user.edit',$group->requestBy)}}" >
                    <i class="fa fa-user fa-fw" aria-hidden="true"></i>
                  </a>
                  <div class="btn p-0" title="Remove" onclick="dGroup('{{$group->id}}')" >
                    <i class="fa fa-cogs fa-fw" aria-hidden="true"></i>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
            @else
              <tr>
                <td colspan="4" class="text-center">{{__('common.notFound')}}</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">{{__('group.manageRequest')}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  method="post" id="request_form">
          {{csrf_field()}}
          {{ method_field('PATCH') }}
          <div class="m-2 custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="email"  name="email" value="1">
            <label class="custom-control-label" for="email">{{__('group.dontSendEmailNotification')}}</label>
          </div>
          <div class="form-group">
            <label>{{__('group.choseAction')}}</label>
            <select class="form-control"  name="act" id="acts">
              <option selected="" disabled="" value="">{{__('group.selectAction')}}</option>
              <option value="1">{{__('group.approveRequest')}}</option>
              <option value="0">{{__('group.declineAndDeleteRequest')}}</option>
            </select>
          </div>
         <div id="groupData" class="display-none bg-warning m-2">
            <div class="form-group">
            <label>{{__('group.nameForDedicatedGroup')}}</label>
            <input type="text" name="name" class="form-control" placeholder="{{__('group.nameForDedicatedGroup')}}">
          </div>
           <div class="form-group">
            <label>{{__('group.description')}}</label>
            <textarea class="form-control" name="details" rows="5"></textarea>
          </div>
         </div>
          <button type="button" class="btn btn-sm pull-left" data-dismiss="modal">{{__('common.cancel')}}</button>
          <button class="float-right btn btn-sm btn-info" type="submit">{{__('common.update')}}</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@push('script')
<script>
  $("#acts").change(function(){
   let val = $(this).val();
   if(val > 0){
    $("#groupData").show();
   }else{
    $("#groupData").hide();
  }
  });

function dGroup(id)
{
var from = document.getElementById('request_form');
from.action = '/group/request/'+id;
$('#requestModal').modal('show');
console.log(form);
}
</script>
@endpush
