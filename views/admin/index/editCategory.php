<?php
$category = $this->get('category');
?>

<h1>
    <?php echo $this->getTrans('add'); ?>
</h1>
<form class="form" method="POST" action="<?php echo $this->getURL(['controller' => 'index', 'action' => 'saveCategory', 'id' => $category->getID()]) ?>">
    <?=$this->getTokenField() ?>
    <div class="form-group <?=$this->validation()->hasError('answer') ? 'has-error' : '' ?>">
        <label class=" control-label">
            Category-Name:
        </label>
        <div>
            <input type="text" name="name" class="form-control" value="<?php echo $category->getName() ?>" />
        </div>
    </div>
    <?php
    echo $this->getSaveBar('saveButton');
    ?>
</form>