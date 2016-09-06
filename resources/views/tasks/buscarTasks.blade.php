@extends('layouts.app')

@section('content')
    <div class="container">
        @if (count($tasks) > 0)
            <section class="tasks">
               @include('tasks.buscarTareas')
            </section>
        @endif
    </div>
@endsection