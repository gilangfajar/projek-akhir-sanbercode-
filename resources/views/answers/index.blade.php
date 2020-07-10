<div class="card mt-2">
    <div class="card-header {{$jawaban->is_right_answer ? 'bg-info' : ''}}">
        <div class="row">
            <div class="col-sm-12 col-lg-4 my-1">
                {{$jawaban->user->name}}
            </div>

            <div class="col-sm-12 col-lg-8 text-lg-right">
                @if ($jawaban->is_author() != True)
                @auth
                    <form class="d-inline-block" action="/jawaban/{{$jawaban->id}}/{{$jawaban->vote_status() ? 'unvote/upvote' : 'upvote'}}"
                    method="POST">
                    @csrf
                    @endauth
                    <button class="btn btn-sm btn-vote {{$jawaban->vote_status() ? 'bg-success' : ''}}" @guest onclick="alert('Login terlebih dahulu!')" @endguest>
                        {{$jawaban->upvote_count()}}
                        <i class="fa fa-arrow-up"></i>
                    </button>
                    @auth</form>
                @endauth

                    @auth
                    
                    <form class="d-inline-block" action="/jawaban/{{$jawaban->id}}/{{$jawaban->vote_status() === 0 ? 'unvote/downvote ' : 'downvote'}}"
                        method="POST">
                        
                        @csrf

                        @endauth
                        <button class="btn btn-sm btn-vote {{$jawaban->vote_status() === 0 ? 'bg-danger' : ''}}" @guest onclick="alert('Login terlebih dahulu!')" @endguest>
                            {{$jawaban->downvote_count()}}
                            <i class="fa fa-arrow-down"></i>
                        </button>
                        @auth
                    </form>
                    @endauth
                </div>
                @else
                @endif
                
                @if ($jawaban->is_author())
                <a href="/jawaban/{{$jawaban->id}}/edit" class="btn btn-sm btn-warning">Edit</a>
                <form class="d-inline-block" action="/jawaban/{{$jawaban->id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="question_id" value="{{$question->id}}">
                    <button class="btn btn-danger btn-sm">
                        Delete
                    </button>
                </form>
                @endif
                @auth
                @if ($question->user_id==Auth::user()->id)
                <form class="d-inline-block" action="/jawaban/{{$jawaban->id}}/right" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="question_id" value="{{$question->id}}">
                    <input type="hidden" name="is_right_answer" value="{{$jawaban->is_right_answer ? 0 : 1}}">
                    <button class="btn {{$jawaban->is_right_answer ? 'btn-dark' : 'btn-success'}} btn-sm">
                        {{$jawaban->is_right_answer ? 'Not Right Answer?' : 'Mark as Right Answer?'}}
                    </button>
                </form>
                @endif
                @endauth
            </div>
        </div>
    </div>

    <div class="card-body">
        {!!$jawaban->content!!}
        <footer>{{$jawaban->created_at}}</footer>
        @auth
        <a href="/komentar_jawaban/create/{{$jawaban->id}}" class="btn btn-sm btn-primary mt-3">Post A Reply</a>
        @endauth

                    <p class="mt-2 border p-2">
                        Komentar: <br>
                        @foreach ($jawaban->comment as $komentar)
                            
                        
                        <button type="button" class="btn btn-sm btn-light">
                            <span class="badge badge-dark">{{$komentar->user->name}}</span> :{{$komentar->content}}
                      </button><br>
                      @endforeach
                    </p>
    </div>
</div>