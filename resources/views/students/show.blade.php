@extends('layouts.app')

@section('content')

    <?php
    use App\Question;
    $questions = Question::where('test_id', $test->id)->get();
    $i = 0;
    ?>

<div class="container">
        <div class="row">
                <div class="col-12">
    @if ($i < count($questions))
    <form method="POST" action="{{ url('students/' . $test->id) }}">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        @foreach ($questions as $question)
                <div class="answer answer{{$i}}">
                    <div class="row">
                        <div class="col-6"><h3>{{$question->title}}</h3></div>
                        <div class="col-6" style="text-align: right"><h3>Frage {{$i+1}}/{{count($questions)}}</h3></div>
                    </div>
                    <div class="row"><div class="col-12">
                        @for ($x = 0; $x < $question->difficulty; $x++)
                            <span class="fa fa-star checked"></span>
                        @endfor
                    </div></div>
                    <div class="row"><div class="col-12"><p>{{$question->text}}</p></div></div>
                    <div class="form-group">
                        <textarea name="solution{{$question->id}}" id="answerBox{{$i}}" rows="5" class="form-control" placeholder=""></textarea>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <ul class="textButtons" onclick="addText(event, {{$i}})">
                                <li>SELECT</li>
                                <li>FROM</li>
                                <li>WHERE</li>
                            </ul>
                        </div>
                        <div class="col-6" style="text-align: right">
                            <button type="button" class="prevBtn{{$i}}" onclick="prevQuestion({{$i}}, {{count($questions)}})">Zurück</button>
                            <button type="button" class="nextBtn{{$i}}" onclick="nextQuestion({{$i}}, {{count($questions)}})">Weiter</button>
                        </div>
                    </div>
                        @if ($question->img != null)
                            <div class="row justify-content-center" style="margin-top: 30px">
                                <a href="#img{{$i}}" style="text-align: center">
                                    <img src="/sqlquiz/public/storage/images/{{$question->img}}" class="thumbnail">
                                </a>
                                <a href="#_" class="lightbox" id="img{{$i}}">
                                    <img src="/sqlquiz/public/storage/images/{{$question->img}}">
                                </a>
                            </div>
                        @endif
                </div>
            
            <?php $i++; ?>
        @endforeach
        <button type="submit" class="btn btn-primary" id="finish" style="visibility: hidden">Abgeben</button>
    </form>
</div>
</div>
    </div>

    @else
        <h1>Keine Fragen!</h1>
    @endif
</div>

  <script>
        $('document').ready(function(){
            var questions = <?php echo $questions ?>;
            var index = 0;
            setQuestion(index, questions.length);
        });

        function setQuestion(i, count) {
            $(".answer"+i).css('visibility', 'visible');
            if (count == 1) {
                $(".nextBtn"+i).css('visibility', 'hidden');
                $(".prevBtn"+i).css('visibility', 'hidden');
                $("#finish").css('visibility', 'visible');
            }
        }

        function nextQuestion(i, count) {
            $(".answer"+i).css('visibility', 'hidden');
            i++;
            $(".answer"+i).css('visibility', 'visible');
            if (i == (count - 1)) {
                $(".nextBtn"+i).css('visibility', 'hidden');
                $("#finish").css('visibility', 'visible');
            }
        }

        function prevQuestion(i, count) {
            if(i > 0) {
                $(".answer"+i).css('visibility', 'hidden');
                i--;
                $(".answer"+i).css('visibility', 'visible'); 
            }
            if (i < count) {
                $("#finish").css('visibility', 'hidden');
            }
        }

        function addText(event, i) {
            var targ = event.target || event.srcElement;
            document.getElementById("answerBox" + i).value += targ.textContent || targ.innerText;
        }
  </script>

@endsection