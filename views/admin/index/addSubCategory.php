<?php
    $categories = $this->get('categories');
?>

<h1>
    <?php echo $this->getTrans('add'); ?>
</h1>
<form class="form" method="POST" action="">
    <?=$this->getTokenField() ?>
    <div class="form-group">
        <label>Parent Category:</label>
        <select class="form-control" name="parent-id">
            <?php
            foreach ($categories as $cat)
            {
                echo "<option value='{$cat->getID()}'>{$cat->getName()}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group <?=$this->validation()->hasError('answer') ? 'has-error' : '' ?>">
        <label class=" control-label">
            Category Name:
        </label>
        <div>
            <input type="text" name="name" class="form-control" />
        </div>
    </div>
    <?php
    echo $this->getSaveBar('addButton');
    ?>
</form>