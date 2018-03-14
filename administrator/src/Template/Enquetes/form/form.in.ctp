<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->control('shutoff', ["label" => "Desativado"]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->control('titulo', array("class" => "form-control")); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group datecake">
            <?php

            echo $this->Form->label('Validade da enquete');
            echo $this->Form->date('expiration_date', [
                'empty' => true,
                'minYear' => 2017,
                'maxYear' => date('Y') + 100,
                "label" => "Validade da enquete",
                'year' => [
                    'class' => 'form-control',
                ],
                'month' => [
                    'class' => 'form-control marR20 marL20',
                ],
                'day' => [
                    'class' => 'form-control',
                ],
            ]);

            ?>
        </div>
    </div>
</div>