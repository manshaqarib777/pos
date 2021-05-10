@extends('layouts.master')
@section('title')
 {{__('group.groupsManagment')}}
@endsection
@push('breadcrumbs')
@include('partials.breadcrumbs',['group'=>__('group.groups'),'links'=> [
['url' =>'','name' => __('group.manageGroup')],
]])
@endpush
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <a href="{{route('group.create')}}" class="btn btn-sm btn-info float-right mb-3">{{__('group.newGroup')}}</a>
      <div class="table-responsive">
        <table class="table table-striped">
          <caption>User Auth group</caption>
          <thead>
            <tr>
              <th scope="row" class="th-width-10">
                {{__('group.createdOn')}}
              </th>
              <th scope="row">
                {{__('group.groupName')}}
              </th>
              <th scope="row" >
                 {{__('group.description')}}
              </th>
              <th scope="row">
                 {{__('group.users')}}
              </th>
              <th scope="row">
                 {{__('group.action')}}
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($groups as $key => $group)
            <tr>
              <td>{{$group->created_at}}</td>
              <td>{{$group->name}}</td>
              <td>{{$group->details}}</td>
              <td>{{$group->users->count()}}</td>
              <td>
                <div class="btn-group">
                  <a class="btn btn-sm p-0" title="{{__('group.editGroupInfo')}}" href="{{route('group.edit',$group->id)}}" >
                    <i class="fa fa-edit fa-fw" aria-hidden="true"></i>
                  </a>
                  <a class="btn btn-sm text-success p-0" title="{{__('group.changePermissions')}}" href="{{route('permission.edit',$group->permissions->id)}}" >
                    <i class="fa fa-lock fa-fw" aria-hidden="true"></i>
                  </a>
                  <div class="btn btn-sm text-danger p-0" title="{{__('common.remove')}}}" onclick="deleteUser('{{$group->id}}')" >
                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="groupDeleteModal" tabindex="-1" role="dialog" aria-labelledby="groupDeleteModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content text-danger">
      <div class="modal-header">
        <h4 class="modal-title">{{__('group.groupDeleteWarning')}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  method="post" id="delete_form">
          {{csrf_field()}}
          <p>{{__('group.delWarning')}}</p>
          {{ method_field('DELETE') }}
          <button type="button" class="btn btn-sm pull-left" data-dismiss="modal">{{__('common.cancel')}}</button>
          <button class="float-right btn btn-sm btn-danger" type="submit">{{__('common.yes.delete')}}</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@push('script')
<script>
function deleteUser(id)
{
var from = document.getElementById('delete_form');
from.action = '/group/'+id;
$('#groupDeleteModal').modal('show');
console.log(form);
}
</script>
@endpush
