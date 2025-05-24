<div class="modal fade breathing-modal" id="VideoPreviewModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content course-preview-modal">
      <div class="modal-header" style=" background: #4c4c4c;height:50px ">
        {{-- <h5 class="modal-title">Intro video</h5> --}}
        <button type="button" class="close" data-dismiss="modal" onclick="pausePreview()">
          <span aria-hidden="true"><i class="ti-close"></i> </span>
        </button>
      </div>
      <div class="modal-body">
        {{-- <div class="course-preview-video-wrap"> --}}
          {{-- <div class="embed-responsive embed-responsive-16by9"> --}}
            {{-- <link rel="stylesheet" href="{{ asset('frontend/css/plyr.css') }}"> --}}
            <div class=" player_video">
            </div>

          {{-- </div> --}}
        {{-- </div> --}}
      </div>
    </div>
  </div>
</div>
