@extends('template')
@section('content')
    @include('blocks.bread')
    <main>
        <div class="page-head">
            <div class="page-head__container container">
                <div class="page-head__content">
                    <div class="page-head__title">{{ $h1 }}</div>
                    <div class="page-head__date">{{ $date }}</div>
                </div>
            </div>
        </div>
        <section class="news text-block">
            <div class="news__container container">
                {!! $text !!}
                <div class="news__action">
                    <a class="button button--primary button--back" href="{{ url()->previous() }}" title="Подробнее">
                        <svg width="20" height="10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 5 13 .959V9.04L20 5ZM0 5.7h13.7V4.3H0v1.4Z" fill="#fff"></path>
                        </svg>
                        <span>Назад</span>
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection