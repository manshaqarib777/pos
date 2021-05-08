<form action="{{route('report.store')}}" method="post">
    {{csrf_field()}}
    <div class="form-group pb-0 pt-0">
        <input type="hidden" name="reportData" value="{{$reportData}}">
        <input type="hidden" name="type" value="{{$type}}">
        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
        <button type="submit" class="btn btn-sm btn-success">
            <i class="fa fa-save btn-submint fa-lg" aria-hidden="true"></i> {{__('report.saveReport')}}
        </button>
    </div>
</form>
<form class="form" action="{{$genLink}}" method="post">
    {{csrf_field()}}
    <div class="form-group col-md-12">
        <input type="hidden" name="print" value="yes">
        @if(isset($reportCard['date_s']))
        <input type="hidden" name="date_s" value="{{$reportCard['date_s']}}">
        <input type="hidden" name="date_e" value="{{$reportCard['date_e']}}">
        @elseif(isset($reportCard['frame']))
        <input type="hidden" name="frame" value="{{$reportCard['frame']}}">
        @else
        <input type="hidden" name="year-month" value="{{$reportCard['time']}}">
        @endif

        <a href="{{$backLink}}" class="btn btn-info btn-sm">{{__('common.back')}}</a>
        <button class="btn btn-default btn-sm" type="submit">{{__('common.print')}}</button>
    </div>
</form>
