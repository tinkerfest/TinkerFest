<!-- Central Modal Medium Info -->
<div class="modal white-text fade" id="publishedModalInfo" tabindex="-1" role="dialog" aria-labelledby="Published" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-success" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="heading lead">Log Has been published</p>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fa fa-check fa-4x mb-1 animated rotateIn"></i>
                    
                </div>
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <a type="button"  href="/{{Auth::user()->g_username}}"  class="btn btn-primary-modal">Goto your logs</a>
                <a type="button" href="/log/new" class="btn btn-outline-secondary-modal waves-effect" data-dismiss="modal">Make another one</a>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#publishedModalInfo').on('hidden.bs.modal', function (e) {
            location.reload();                    
        })

    })

</script>
<!-- Central Modal Medium Info-->
