<script src="{{ asset('frontend') }}/assets/js/jquery.min.js"></script>
<script src="{{ asset('frontend') }}/assets/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend') }}/assets/js/owl.carousel.min.js"></script>
<script src="{{ asset('frontend') }}/assets/js/waypoints.min.js"></script>
<script src="{{ asset('frontend') }}/assets/js/jquery.counterup.min.js"></script>
<script src="{{ asset('frontend') }}/assets/js/TweenMax.min.js"></script>
<script src="{{ asset('frontend') }}/assets/js/wow.js"></script>
<script src="{{ asset('frontend') }}/assets/js/jquery.magnific-popup.min.js"></script>
<script src="{{ asset('frontend') }}/assets/js/countdown.min.js"></script>
<script src="{{ asset('frontend') }}/assets/js/vegas.min.js"></script>
<script src="{{ asset('frontend') }}/assets/js/jquery.validate.min.js"></script>
<script src="{{ asset('frontend') }}/assets/js/jquery.ajaxchimp.min.js"></script>

<script>


function downloadFile(url) {
    fetch(url).then(res => res.blob()).then(file => {
        let tempUrl = URL.createObjectURL(file);
        const aTag = document.createElement("a");
        aTag.href = tempUrl;
        aTag.download = url.replace(/^.*[\\\/]/, '');
        document.body.appendChild(aTag);
        aTag.click();
        downloadBtn.innerText = "Download File";
        URL.revokeObjectURL(tempUrl);
        aTag.remove();
    }).catch(() => {
    });
}
  function openVideo(event, videoId) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(videoId).style.display = "block";
            event.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
</script>
<!-- template scripts -->

@stack('js')
@stack('scripts')

<!-- template scripts -->
<script src="{{ asset('frontend') }}/assets/js/theme.js"></script>
</body>


</html>
