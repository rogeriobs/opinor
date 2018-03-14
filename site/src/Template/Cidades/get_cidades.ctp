<option value=""> -- selecione sua cidade -- </option>

<?php if(count($cidades)): ?>

    <?php foreach($cidades as $cidade): ?>

        <option value="<?= $cidade->id ?>"><?=$cidade->nome ?></option>

    <?php endforeach; ?>

<?php endif; ?>

