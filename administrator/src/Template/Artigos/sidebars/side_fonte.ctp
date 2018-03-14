<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->control('fonte', ['class' => 'form-control', 'list' => 'listFontes']); ?>
        <datalist id="listFontes">
            <option value="Wikipédia">
            <option value="Globo.com">
            <option value="Folha">
            <option value="Estadão">
            <option value="Veja">
            <option value="Terra">
            <option value="Uol">
            <option value="R7">
            <option value="Istoé">
            <option value="ESPN">
        </datalist>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->control('fonte_link', ['class' => 'form-control']); ?>
    </div>
</div>