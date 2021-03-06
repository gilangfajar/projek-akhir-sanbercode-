@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-9">
            <a href="/pertanyaan" class="btn btn-secondary btn-sm mb-3"><i class="fa fa-arrow-left
                "></i> Kembali</a>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 my-auto">
                            Pertanyaan oleh: <a class="card-text question-title"
                                href="/profile/{{$question->user->id}}">{{$question->user->name}} </a>

                            <br>
                            @if ($question->is_author())
                            <a href="{{$question->id}}/edit" class="btn btn-xs btn-warning">Edit</a>

                            <button data-toggle="modal" data-target="#myModal"
                                class="btn btn-xs btn-danger">Delete</button>

                            @endif
                        </div>
                        <div class="col-sm-12 col-md-6 my-auto text-sm-right">
                            @foreach ($question->tag as
                            $tag_question)
                            <a class="btn btn-info btn-sm" href="/tag/{{$tag_question->id}}">
                                #{{$tag_question->tag_name}} </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- 
                        komentar 
                    --}}
                    <h1>{{$question->title}} </h1>
                    <small style="border-bottom: 1px solid grey" class="text-secondary italic">
                        @if ($question->created_at==$question->updated_at)
                        Dibuat {{$question->created_at->diffForHumans()}}
                        @else
                        Diubah {{$question->updated_at->diffForHumans()}}
                        @endif


                    </small>
                    <p class="mt-2">{!!$question->content!!}</p>
                    <hr>
                    @if ($commentq->isEmpty())
                    <p class="text-center mb-2">
                        <small><em>Belum terdapat komentar</em></small>
                    </p>
                    @else
                    <h6 class="mb-2 font-weight-bold">
                        <i class="fa fa-comments" aria-hidden="true"></i> Komentar ({{count($commentq)}}):
                    </h6>
                    @endif
                    {{-- <p> --}}
                        @foreach ($commentq as $comment)
                        @include('questions.comment.show')
                        @endforeach

                    {{-- </p> --}}
                    @auth
                    <form action="/komentar_pertanyaan" method="post">
                        @csrf
                        <input type="hidden" name="question_id" value="{{$question->id}}">
                        <div class="row">
                            <div class="col-sm-12 comment px-0">
                                <div class="input-group input-group-sm ml-2">
                                    <input type="text" required class="form-control input-sm"
                                        placeholder="Tambahkan komentar ..." name="content">
                                    <button class="btn btn-light btn-sm ml-2" type="submit"><i
                                            class="fa fa-share fa-rotate-180" aria-hidden="true"></i> Enter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endauth

                    {{-- 
                        jawaban 
                    --}}
                    <hr class="my-2">
                    <hr>
                    <h6 class="my-2 font-weight-bold">
                        <i class="fa fa-reply" aria-hidden="true"></i> <span id="jumlah"></span> Jawaban
                        ({{$question->answers_count}}):
                    </h6>
                    @foreach ($answer as $jawaban)
                    @include('answers.index')
                    @endforeach
                    @auth
                    @include('answers.create')
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Attention!</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus pertanyaan ini?</p>
            </div>
            <div class="modal-footer">
                <form class="d-inline-block" action="/pertanyaan/{{$question->id}}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button data-toggle="modal" data-target="#myModal" class="btn btn-danger">
                        Hapus
                    </button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script>
    var konten = document.getElementById("content");
    CKEDITOR.replace(content, {
        language: 'en-gb'
    });
    CKEDITOR.config.allowedContent = true;
    CKEDITOR.instances.editor1.document.getBody().getText();

</script>
<script>
    const jawab = document.getElementById('jumlah');
</script>
@endpush

@if (session('status'))
@push('scripts')
<script>
    Swal.fire({
        text: '{{ session('status') }}',
        icon: 'success',
        toast: true,
        position: 'top-end',
        timer: 3000,
        timerProgressBar: true,
        confirmButtonText: 'close'
    });
</script>
@endpush
@endif