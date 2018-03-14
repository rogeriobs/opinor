<div class="content-mydata">

    <?= $this->Form->create(null, ['class' => 'form-labels-on-top', "onsubmit" => "showLoading()"]) ?>

    <div class="form-title-row">
        <h1>Alterar Senha</h1>
    </div>

    <div class="form-row">        
        <?php echo $this->Form->input('senha_atual', ['type' => 'password', "label" => "Digite sua senha atual", "value" => "", "required" => true]); ?>
    </div>
    <div class="form-row">        
        <?php echo $this->Form->input('senha_nova', ['type' => 'password', "label" => "Digite uma nova senha", "value" => "", "required" => true, "autocomplete" => "off"]); ?>
    </div>
    <div class="form-row">        
        <?php echo $this->Form->input('senha_nova_reedigitada', ['type' => 'password', "label" => "Digite novamente a nova senha", "value" => "", "required" => true]); ?>
    </div>

    <div class="form-row">
        <button class="btn btn-success" type="submit">Salvar Alteração</button>
    </div>

    <?= $this->Form->end() ?>

</div>

<script type="text/javascript">

   
</script>