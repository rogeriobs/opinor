<?= $this->Form->create(null, ["class" => "form-signin", "id" => "frmLogin"]) ?>
    
    <input name="username" autocomplete="off" type="text" id="inputEmail" class="form-control" placeholder="Username" required="true" autofocus="">
    <input name="password" autocomplete="off" type="password" id="inputPassword" class="form-control" placeholder="Password" required="true">

    <button class="btn btn-lg btn-success btn-block" type="submit">Sign in</button>
    
<?= $this->Form->end() ?>

