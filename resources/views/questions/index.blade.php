@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="title my-3">
                Selamat datang di forum Laravel!
            </h1>
            <hr>

            <div class="row">
                <div class="col-sm-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 my-auto">

                                    @if (empty($title))
                                    <h5 class="text-light-blue mb">
                                        Kumpulan Pertanyaan
                                    </h5>
                                    @else
                                    <h6 class="text-light-blue mb-0">
                                        Menampilkan pertanyaan terkait: {{$title}}
                                    </h6>
                                    @endif


                                </div>

                                <div class="col-sm-12 col-md-6 my-1">
                                    <p class="text-light-blue d-inline-block mb-0">
                                        Ingin membuat pertanyaan baru?
                                    </p>
                                    @auth
                                    <a href="/pertanyaan/create" class="btn btn-sm btn-success ml-lg-2">
                                        <i class="fa fa-edit"></i> Buat
                                    </a>
                                    @endauth
                                    @guest
                                    <a href="/login" class="btn btn-sm btn-success ml-lg-2">
                                        <i class="fa fa-login"></i> Login
                                    </a>
                                    @endguest
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @foreach ($questions as $key => $item)
                            {{-- start of 1 question  --}}
                            <div id="question" href="" class="col-sm-12 row">
                                <div class="col-sm-12 col-md-9">
                                    <h5 class="card-subtitle">
                                        <a class="question-title" href="/pertanyaan/{{$item->id}}">{{$item->title}}</a>
                                    </h5><br>
                                    <p class="card-text font-weight-light text-muted">Pembuat: <a class="question-title"
                                            href="/profile/{{$item->user->id}}">{{$item->user->name}}</a>
                                        {{-- {{$item->answers_count}} --}}<br>
                                        <small><i class="fa fa-clock-o"></i> {{$item->updated_at->diffForHumans()}} </small>
                                    </p>
                                    <div class="tags">
                                        @foreach ($item->tag as $tag_question)
                                        <a href="/tag/{{$tag_question->id}}" class="btn btn-info btn-sm my-1">
                                            #{{$tag_question->tag_name}}
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                @include('questions.partials._vote-button')
                            </div>
                            <hr>
                            @endforeach
                            {{-- end of 1 question --}}
                            {{ $questions->links() }}

                        </div>

                    </div>
                </div>

                @include('questions.partials.sidebar')
            </div>
        </div>
    </div>
</div>
@endsection

@if (session('status'))
@push('scripts')
<script>
    Swal.fire({
        text: '{{ session('status') }}',
        icon: 'error',
        confirmButtonText: 'close'
    });
</script>
@endpush
@endif