<div class="modal-body success-signup-modal">
    <div class="row">
        <div class="col-md-12">
            <div class="success-signup">
                <i class="fa fa-check"></i>
                <h2>Cadastro realizado com sucesso!</h2>
                <p>Para poder finalizar o cadastro, é preciso confirmar seu e-mail.</p>
                <p>Um e-mail foi enviado para: <span class="strongemail"><?=$email?></span></p>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .success-signup-modal{
        background-color: #648B38;
    }
    .success-signup{
        text-align: center;
        color: #FFF;
    }
    .success-signup .fa{
        font-size: 40px;
        margin: 5px auto 20px;
    }
    .success-signup h2{
        font-size: 1.2rem;
        font-weight: bold;
    }
    .success-signup p{
        margin: 20px 0;
    }
    .success-signup p .strongemail{
        font-weight: 500;
        font-size: .9rem;
        display: block;
    }
</style>
