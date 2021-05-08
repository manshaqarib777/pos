@extends('layouts.simple')
@section('title')
403 {{__('error.forbidden')}}
@endsection
<style>
    .c{
        color: lightskyblue;
        text-align: center;
        display: block;
        position: relative;
        width:80%;
        margin:25px auto;
    }
    ._403{
        font-size: 200px;
        position: relative;
        display: inline-block;
        z-index: 2;
        height: 250px;
        letter-spacing: 15px;
    }
    ._1{
        text-align:center;
        display:block;
        position:relative;
        letter-spacing: 12px;
        font-size: 4em;
        line-height: 80%;
    }
    ._2{
        text-align:left;
        display:block;
        position: relative;
        font-size: 15px;
    }
    .btn{
        width: 358px;
        padding: 5px;
        z-index: 5;
        font-size: 25px;
    }
</style>
@section('content')
<div class="col-md-12">
    <div class='c'>
        <div class='_403'>403</div>
        <div class='_1'>{{__('error.noAccess')}}</div>

        <br>
        <a class='btn btn-info' href="{{route('home')}}">{{__('common.back')}}</a>
    <div class="_2">
        <ul>
            <li>{{__('error.403Line1')}}</li>
            <li>{{__('error.403Line2')}}</li>
            <li>{{__('error.403Line3')}}</li>
            <li>{{__('error.403Line4')}}</li>
            <li>{{__('error.403Line5')}}</li>
            <li>{{__('error.403Line6')}}</li>
            <li>{{__('error.403Line7')}}</li>

        </ul>
    </div>
    </div>

</div>
@endsection
