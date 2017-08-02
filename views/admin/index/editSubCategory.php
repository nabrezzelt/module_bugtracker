<?php
$subCategory = $this->get('subCategory');
$categories = $this->get('categories');
?>

<h1>
    <?php echo $this->getTrans('add'); ?>
</h1>
<form class="form" method="POST" action="<?php echo $this->getURL(['controller' => 'index', 'action' => 'saveSubCategory', 'id' => $subCategory->getID()]) ?>">
    <?=$this->getTokenField() ?>
    <div class="form-group">
        <label>Parent Category:</label>
        <select class="form-control" name="parent-id">
            <?php
            foreach ($categories as $cat)
            {
                if($subCategory->getCategory()->getID() == $cat->getID())
                {
                    echo "<option value='{$cat->getID()}' selected>{$cat->getName()}</option>";
                }
                else
                {
                	echo "<option value='{$cat->getID()}'>{$cat->getName()}</option>";
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group <?=$this->validation()->hasError('answer') ? 'has-error' : '' ?>">
        <label class=" control-label">
            Category Name:
        </label>
        <div>
            <input type="text" name="name" class="form-control" value="<?php echo $subCategory->getName(); ?>" />
        </div>
    </div>
    <?php
    echo $this->getSaveBar('saveButton');
    ?>
</form>