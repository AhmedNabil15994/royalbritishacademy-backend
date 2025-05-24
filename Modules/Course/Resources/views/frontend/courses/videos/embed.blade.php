@php $id = 'embedBox'.\IlluminateAgnostic\Collection\Support\Str::random(20); @endphp
<div id="{{$id}}" style="width:1280px;max-width:100%;height:500px;"></div>
<script>
  var video = new VdoPlayer({
        otp: "{{$video->otp}}",
        playbackInfo: "{{$video->playbackInfo}}",
        theme: "9ae8bbe8dd964ddc9bdb932cca1cb59a",
        // the container can be any DOM element on website
        container: document.querySelector("#{{$id}}"),
    });


    if(!lesson_content_id){
    var lesson_content_id='{{ $lessonContentId }}'
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    video.addEventListener(`load`, () => {

        $('.modal').on('hidden.bs.modal', function () {
            if(lesson_content_id){
              const totalPlayed=video.totalPlayed;


              handeLessonContentView(totalPlayed,lesson_content_id)
            }
            (video.status === 1) ? video.pause() : '';
        });
    });


    function handeLessonContentView(totalPlayed,lesson_content_id){
        $.ajax({
            type: "post",
            url: "{{ route('course.make.view') }}",
            data: {totalPlayed,lesson_content_id},
            dataType: "json",
            success: function (response) {}

            });
    }

    }
</script>
