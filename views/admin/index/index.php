
<?php
$categories = $this->get('categories');
$subCategories = $this->get('subCategories');
?>

<h1>Bugtracker - Settings</h1>

<table class="table table-striped">
    <tr>
        <th>Category</th>
        <th>Sub-Category</th>
        <th>Action</th>
    </tr>
    <?php

    foreach ($categories as $cat)
    {
        echo "<tr>
                <td>{$cat->getName()}</td>
                <td></td>
                <td>
                    <a class='btn btn-default btn-xs' href='{$this->getUrl(['controller' => 'index', 'action' => 'editCategory', 'id' => $cat->getID()])}'>Edit</a>
                    <a class='btn btn-danger btn-xs' href='{$this->getUrl(['controller' => 'index', 'action' => 'deleteCategory', 'id' => $cat->getID()])}'>Delete <span class='small'>- SubCategories and Bugs will be deleted!</span></a>
                </td>
              </tr>";

        foreach ($subCategories as $subCat)
        {
            if($subCat->getCategory()->getID() == $cat->getID())
            {
                echo "<tr>
                        <td></td>
                        <td>{$subCat->getName()}</td>
                        <td>
                            <a class='btn btn-default btn-xs' href='{$this->getUrl(['controller' => 'index', 'action' => 'editSubCategory', 'id' => $subCat->getID()])}'>Edit</a>
                            <a class='btn btn-danger btn-xs' href='{$this->getUrl(['controller' => 'index', 'action' => 'deleteSubCategory', 'id' => $subCat->getID()])}'>Delete <span class='small'>- Bugs will be deleted!</span></a>
                        </td>
                      </tr>";
            }
        }
    }
    ?>

</table>