@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pertanyaan #{{$question->user->name}} @foreach ($question->tag as $tag_question)
                    <button class="btn btn-primary btn-sm float-right mr-1">#{{$tag_question->tag_name}}</button>
                        @endforeach</div>

                <div class="card-body">
                    <h1>{{$question->title}} </h1>
                    <p>{{$question->content}}</p>
                    <small >{{$question->created_at}}</small>
                    
                    <div class="card-footer text-muted">
                    <p class='mt-2'>Komentar:
                        @foreach ($commentq as $comment)
                <footer class="blockquote-footer">{{$comment->user->name}}: <cite title="Source Title">{{$comment->content}}</cite></footer>
                @endforeach
                
                    </p>
                </div>
                <a href="/komentar_pertanyaan/create/{{$question->id}}" class="btn btn-sm btn-success">Reply</a>
                </div>
            </div>
            

            @foreach ($answer as $jawaban)
                        
                    
            <div class="card mt-2 ">
                <div class="card-header 
                @if ($jawaban->is_right_answer==1)
                bg-success
                @endif">Jawaban #{{$jawaban->user->name}} 

                
                    @if ($jawaban->user_id==Auth::user()->id)
                    <a href="/jawaban/{{$jawaban->id}}/edit" class="btn btn-sm btn-warning">Edit</a>
                    <form action="/jawaban/{{$jawaban->id}}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="question_id" value="{{$question->id}}">
                    <button class="btn btn-danger btn-sm">
                        Delete
                    </button>
                </form>
                                    
                @endif
                @if ($question->user_id==Auth::user()->id)
                @if ($jawaban->is_right_answer==0)
                <form action="/jawaban/{{$jawaban->id}}/right" method="POST" style="display:inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="question_id" value="{{$question->id}}">
                    <input type="hidden" name="is_right_answer" value="1">
                    <button class="btn btn-success btn-sm">
                        Mark as Right Answer?
                    </button>
                </form>
                @else
                <form action="/jawaban/{{$jawaban->id}}/right" method="POST" style="display:inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="question_id" value="{{$question->id}}">
                    <input type="hidden" name="is_right_answer" value="0">
                    <button class="btn btn-dark btn-sm">
                        Not Right Answer?
                    </button>
                </form>
                @endif
                @endif
            </div>

                <div class="card-body">
                    {{$jawaban->content}}
                    <footer >{{$jawaban->created_at}}</footer>
                </div>
            </div>
            @endforeach
            <div class="card mt-2 ">
                <div class="card-header ">Jawaban Anda </div>
            <div class="card-body">
            <form action="/jawaban" method="POST">
                    @csrf
                    <input type="hidden" name="question_id" value="{{$question->id}}">
                    <div class="form-group">
                        <label for="content">Jawaban</label>
                        <textarea name="content" class="form-control" id="content" cols="5" rows="5"></textarea>
                    </div>

                    <button type="submit" class="btn btn-secondary mt-2">Submit</button>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection