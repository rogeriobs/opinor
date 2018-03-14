<!-- Modal -->
<div class="modal fade" id="MyModalLogin" tabindex="-1" role="dialog" aria-labelledby="MyModalLoginLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div id="__content-form-login" class="modal-content form-login">

        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {

        $(document).on("click", ".MyModalLoginOpen", function () {

            var ModalPopup = $("#MyModalLogin");

            ModalPopup.off('show.bs.modal').on('show.bs.modal', function (event) {

                var button = $(event.relatedTarget); // Button that triggered the modal

                reqGetCad = $.ajax({
                    url: '<?= $this->Url->build(['controller' => 'Login', 'action' => 'in']) ?>',
                    type: 'GET',
                    data: {},
                    cache: false,
                    global: false,
                    beforeSend: function (xhr) {
                        $('#__content-form-login').html(get_spinner_loading());
                    },
                    success: function (html, textStatus, jqXHR) {
                        $('#__content-form-login').html(html);
                    }
                });
                reqGetCad.always(function () {

                });

                reqGetCad.fail(function (jqXHR, textStatus, errorThrown) {
                    alert(textStatus);
                    window.location.reload();
                });
            });

            ModalPopup.modal("show");
        });
    });
</script>