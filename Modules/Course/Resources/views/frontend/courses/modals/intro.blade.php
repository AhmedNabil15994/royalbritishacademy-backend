<div class="modal fade breathing-modal" id="CoursePreviewModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content course-preview-modal">
            <div class="modal-header">
                <h5 class="modal-title">Intro video</h5>
                <button type="button" class="close" data-dismiss="modal" onclick="pausePreview()">
                    <span aria-hidden="true"><i class="ti-close"></i> </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="course-preview-video-wrap">
                    <div class="embed-responsive embed-responsive-16by9">
                        <link rel="stylesheet" href="/frontend/en/css/plyr.css">
                        <div class="plyr__video-embed player" id="player">
                            <iframe height="600" width="500" src="{{ $course->intro_video }}" allowfullscreen allowtransparency allow="autoplay"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
