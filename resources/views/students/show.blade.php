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
                    <h1>{{$question->title}}</h1>
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
                            <button type="button" class="prevBtn{{$i}}" onclick="prevQuestion({{$i}})">Zurück</button>
                            <button type="button" class="nextBtn{{$i}}" onclick="nextQuestion({{$i}}, {{count($questions)}})">Weiter</button>
                        </div>
                    </div>
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

        function prevQuestion(i) {
            if(i>0) {
               $(".answer"+i).css('visibility', 'hidden');
                i--;
                $(".answer"+i).css('visibility', 'visible'); 
            }
            
        }

        function addText(event, i) {
            var targ = event.target || event.srcElement;
            document.getElementById("answerBox" + i).value += targ.textContent || targ.innerText;
        }
  </script>

@endsection