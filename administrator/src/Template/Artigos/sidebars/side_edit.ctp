<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->control('shutoff'); ?>
    </div>
</div>
<br>

<div class="row">
    <div class="col-md-6">
        <?php echo $this->Form->control('format_article', ['class' => 'sumo_select', 'options' => $format_article]); ?>
    </div>
</div>
<br>      
<div class="row">
    <div class="col-md-12">
        <div class="form-group datetimecake">
            <?php

            echo $this->Form->label('Data de publicação');
            echo $this->Form->date('data_de_publicacao', [
                'empty' => true,
                'minYear' => 2000,
                'maxYear' => date('Y') + 100,
                'year' => [
                    'class' => 'form-control',
                ],
                'month' => [
                    'class' => 'form-control',
                ],
                'day' => [
                    'class' => 'form-control',
                ],
            ]);

            echo $this->Form->time('data_de_publicacao', [
                'interval' => 1,
                'hour' => [
                    'class' => 'form-control'
                ],
                'minute' => [
                    'class' => 'form-control'
                ],
                'second' => [
                    'class' => 'form-control'
                ],
            ]);

            ?>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="form-group datetimecake">
            <?php

            echo $this->Form->label('Data da fonte');
            echo $this->Form->date('data_da_fonte', [
                'empty' => true,
                'minYear' => 2000,
                'maxYear' => date('Y') + 100,
                'year' => [
                    'class' => 'form-control',
                ],
                'month' => [
                    'class' => 'form-control',
                ],
                'day' => [
                    'class' => 'form-control',
                ],
            ]);

            echo $this->Form->time('data_da_fonte', [
                'interval' => 1,
                'hour' => [
                    'class' => 'form-control',
                    'title' => 'Registration Year'
                ],
                'minute' => [
                    'class' => 'form-control'
                ],
                'second' => [
                    'class' => 'form-control'
                ],
            ]);

            ?>
        </div>
    </div>
</div>