 <div class="bg-default p-3">
  <img title="{{$item->name}}" src="{{asset('storage/'.$item->image)}}" class="img img-thumbnail logo-img-150wh" alt="image">
  <form action="{{$routeLink}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <input type="file" name="image" class="mt-3 form-control @if($errors->has('image')) is-invalid @endif">
    @if($errors->has('image'))
    <span class="invalid-feedback" role="alert">
      <strong>{{ $$errors->first('image') }}</strong>
    </span>
    @endif
    @if(isset($nameId))
    <input type="hidden" name="{{$nameId}}" value="{{$item->id}}">
    @endif
    <button type="submit" class="btn btn-sm btn-block mt-1 btn-warning">{{__('common.upload')}}</button>
  </form>
</div>
<hr>
