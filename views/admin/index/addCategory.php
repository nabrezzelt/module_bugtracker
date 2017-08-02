<?php

?>

<h1>
    <?php echo $this->getTrans('add'); ?>
</h1>
<form class="form" method="POST" action="">
    <?=$this->getTokenField() ?>
    <div class="form-group <?=$this->validation()->hasError('answer') ? 'has-error' : '' ?>">
        <label for="ck_1" class=" control-label">
            Category-Name:
        </label>
        <div>
            <input type="text" name="name" class="form-control" />
        </div>
    </div>
    <?php
    echo $this->getSaveBar('addButton');
    ?>
</form>