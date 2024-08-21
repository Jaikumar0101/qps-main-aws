<div
    x-data="{
        videoUrl: @entangle('videoUrl'),
        videoPlayer: $refs.videoPlayer,
        videoModal: $refs.videoModal
    }"
    x-init="
        if (videoModal) {
            videoModal.addEventListener('show.bs.modal', () => {
                if (videoPlayer)
                {
                    videoPlayer.load();
                    videoPlayer.play();
                }
            });

            videoModal.addEventListener('hide.bs.modal', () => {
                if (videoPlayer) {
                    videoPlayer.pause();
                }
            });
        }
        this.addEventListener('showVideoModal', () => {
            if (videoModal) {
                $(videoModal).modal('show');
            }
        });
    "
>
    <div class="modal fade modal-close-out" x-ref="videoModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabelCloseOut" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelCloseOut">Uploaded Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <video controls x-ref="videoPlayer" class="w-100 rounded">
                        <source :src="videoUrl" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
