<div class="btn-group float-right mb-1 mt-1">
  <a class="btn btn-sm btn-success" title="{{__('common.view.all')}}" href="{{$allLink}}" ><i class="fa fa-eye fa-fw" aria-hidden="true"></i>{{__('common.view.all')}}</a>
 @if(isset($editLink))
  <a class="btn btn-sm btn-info" title="{{__('common.edit')}}" href="{{$editLink}}" ><i class="fa fa-edit fa-fw" aria-hidden="true"></i>{{__('common.edit')}}</a>
 @endif
  @yield('buttons')
  <button class="btn btn-sm btn-danger" title="{{__('common.remove')}}" data-toggle="modal" data-target="#removeModel" ><i class="fa fa-trash fa-fw" aria-hidden="true"></i>{{__('common.remove')}}</button>
  <!-- Modal -->
  <div class="modal fade" id="removeModel" tabindex="-1" role="dialog" aria-labelledby="removeModel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content text-danger">
        <div class="modal-header p-2">
          <h2 class="modal-title pl-2">{{__('common.warning')}}</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{$destroyLink}}" method="post" >
            {{csrf_field()}}
            {{ method_field('DELETE') }}
            <p>{{__('common.are.you.sure.to.delete')}}</p>
            <button type="button" class="btn btn-sm btn-secondary pull-left" data-dismiss="modal">{{__('common.cancel')}}</button>
            <button class="float-right btn btn-sm btn-danger" type="submit"> {{__('common.yes.delete')}}</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
