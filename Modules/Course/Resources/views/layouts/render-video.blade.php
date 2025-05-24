@php $id = 'embedBox'.\IlluminateAgnostic\Collection\Support\Str::random(20); @endphp
<script src="https://player.vdocipher.com/playerAssets/1.6.10/vdo.js"></script>
<div id="{{$id}}" style="width:1280px;max-width:100%;height:auto;"></div>
<script>
    var video = new VdoPlayer({
        otp: "{{$otp}}",
        playbackInfo: "{{$playbackInfo}}",
        theme: "9ae8bbe8dd964ddc9bdb932cca1cb59a",
        // the container can be any DOM element on website
        container: document.querySelector("#{{$id}}"),
    });

    video.addEventListener(`load`, () => {
        $('.modal').on('hidden.bs.modal', function () {

            (video.status === 1) ? video.pause() : '';
        });
    });
</script>