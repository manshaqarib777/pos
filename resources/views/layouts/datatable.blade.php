@extends('layouts.master')
@push('style')
<link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">
@endpush

@section('title')
 Resource Management
@endsection

@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        {{$dataTable->table()}}
      </div>
    </div>
  </div>
</div>
@endsection
@push('script')
<script src="{{asset('js/plugin/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/plugin/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('js/plugin/datatables/dataTables.buttons.min.js')}}"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
{{$dataTable->scripts()}}
@endpush
