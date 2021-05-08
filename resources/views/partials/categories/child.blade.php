<table class="table mt-3">
  <caption>{{__('manage.child.list')}}</caption>
  <thead>
    <tr class="bg-warning">
      <th scope="row" class="th-width-50">{{__('manage.category.name')}}</th>
      <th scope="row" class="th-width-20">{{__('manage.category.code')}}</th>
      <th scope="row" class="th-width-20">{{__('common.view')}}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($subcategories as $subcategory)
    <tr>
      <td>{{$subcategory->name}}</td>
      <td>{{$subcategory->code}}</td>
      <td>
        <a href="{{route('subcategory.show',$subcategory->id)}}" title="{{__('common.view.info')}}">
          <i class="fa fa-eye" aria-hidden="true"></i>
        </a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
