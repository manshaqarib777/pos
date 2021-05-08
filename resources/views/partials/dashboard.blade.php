<div class="col-sm-6 {{$class?? 'col-md-3'}}" >
    <div class="card card-stats card-round">
        <div class="card-body ">
            <div class="row">
                <div class="col col-stats">
                    <div class="numbers">
                        <p class="card-category">
                           <strong> {{$heading}}</strong>
                        </p>
                        <h4 class="card-title">
                        @if(isset($link))
                        <a href="{{$link}}" class="btn-link" data-toggle="tooltip" title="{{__('dash.visittoManage')}} {{$heading}}">
                            {{$title}}
                        </a>
                        @else
                        {{$title}}
                        @endif
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
