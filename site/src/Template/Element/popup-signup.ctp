<!-- Modal -->
<div class="modal fade" id="MyModalSignup" tabindex="-1" role="dialog" aria-labelledby="MyModalSignupLabel">
    <div class="modal-dialog" role="document">
        <div id="__content-form-signup" class="modal-content form-login">

        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {

        $(document).on("click", "#MyModalSignupOpen", function (e) {

            $('#MyModalLogin').on('hidden.bs.modal', function (e) {

                var ModalPopup = $("#MyModalSignup");

                ModalPopup.off('show.bs.modal').on('show.bs.modal', function (event) {

                    reqGetCad = $.ajax({
                        url: '<?= $this->Url->build(['controller' => 'Login', 'action' => 'signup']) ?>',
                        type: 'GET',
                        data: {},
                        cache: false,
                        global: false,
                        beforeSend: function (xhr) {
                            $('#__content-form-signup').html(get_spinner_loading());
                        },
                        success: function (html, textStatus, jqXHR) {
                            $('#__content-form-signup').html(html);
                        }
                    });
                    reqGetCad.always(function () {

                    });

                    reqGetCad.fail(function (jqXHR, textStatus, errorThrown) {
                        alert(textStatus);
                        window.location.reload();
                    });

                });
                
                $('#MyModalLogin').off("hidden.bs.modal");

                ModalPopup.modal("show");

            });

            $("#MyModalLogin").modal("hide");

        });
    });
</script>
