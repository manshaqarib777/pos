@extends('layouts.simple')
@section('title')
404 {{__('error.error')}}
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
    ._404{
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
        text-align:justify;
        font-size: 15px;
        margin-top: 2%;
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
        <div class='_404'>404</div>
        <div class='_1'>{{__('error.pageNotFound')}}</div>

        <br>
        <a class='btn btn-info' href="{{route('home')}}">{{__('common.back')}}</a>
           <div class='_2'>

               <ul>
                <li>{{__('error.404Line1')}}</li>
                <li>{{__('error.404Line2')}}</li>
                <li>{{__('error.404Line3')}}</li>
                <li>{{__('error.404Line4')}}</li>
                <li>{{__('error.404Line5p1')}} <a href="https://codecanyon.net/item/small-business-point-of-sale/25352332/support"> {{__('error.here')}} </a> {{__('error.404Line5p2')}} <a href="mailto:info.codehas@gmail.com">info.codehas@gmail.com</a>{{__('error.404Line5p3')}} </li>
               </ul>
           </div>
    </div>
</div>
@endsection
