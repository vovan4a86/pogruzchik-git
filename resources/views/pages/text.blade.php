@php $innerPage = true; @endphp
@extends('template')
@section('content')
    @include('blocks.bread')
    <main>
        <div class="_container container">
            <div class="text-block">
                {!! $text !!}
            </div>
        </div>
    </main>
@stop
