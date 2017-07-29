<?php
/**
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Modules\Bugtracker\Mappers;

use Modules\Bugtracker\Models\SubCategory as SubCategoryModel;
use Modules\Bugtracker\Models\Category as CategoryModel;


class SubCategory extends \Ilch\Mapper
{
    public function getAllSubCategories()
    {
        $query = "SELECT bugtracker_sub_categories.id as sub_category_id, bugtracker_sub_categories.name AS sub_category_name,
                    bugtracker_sub_categories.category_id, bugtracker_categories.name AS category_name
                  FROM bugtracker_sub_categories
                  JOIN bugtracker_categories
                  ON bugtracker_sub_categories.category_id = bugtracker_categories.id";
        $res = $this->db()->query($query);

        $i = 0;
        $subCategories[] = array();

        while ($row = mysqli_fetch_assoc($res))
        {
        	$subCategories[$i] = new SubCategoryModel($row['sub_category_id'], new CategoryModel($row['category_id'], $row['category_name']), $row['sub_category_name']);
            $i++;
        }

        return $subCategories;
    }    
}
