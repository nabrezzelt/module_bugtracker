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
        $query = "SELECT [prefix]_bugtracker_sub_categories.id AS sub_category_id, [prefix]_bugtracker_sub_categories.name AS sub_category_name,
                    [prefix]_bugtracker_sub_categories.category_id, [prefix]_bugtracker_categories.name AS category_name
                  FROM [prefix]_bugtracker_sub_categories
                  JOIN [prefix]_bugtracker_categories
                  ON [prefix]_bugtracker_sub_categories.category_id = [prefix]_bugtracker_categories.id";
        $res = $this->db()->query($query);

        $i = 0;
        $subCategories = array();

        while ($row = mysqli_fetch_assoc($res))
        {
        	$subCategories[$i] = new SubCategoryModel($row['sub_category_id'], new CategoryModel($row['category_id'], $row['category_name']), $row['sub_category_name']);
            $i++;
        }

        return $subCategories;
    }

    public function createSubCategory($parentID, $name)
    {
        $link = $this->db()->getLink();

        $parentID = mysqli_real_escape_string($link, $parentID);
        $name = mysqli_real_escape_string($link, $name);

        $query = "INSERT INTO [prefix]_bugtracker_sub_categories (category_id, name) VALUES (?, ?)";
        $query = $this->db()->getSqlWithPrefix($query);
        $stmt = $link->prepare($query);
        $stmt->bind_param('is', $parentID, $name);
        $stmt->execute();
    }

    public function getSubCategoryByID($id)
    {
        $link = $this->db()->getLink();

        $query = "SELECT [prefix]_bugtracker_sub_categories.id AS sub_category_id, [prefix]_bugtracker_sub_categories.name AS sub_category_name,
                    [prefix]_bugtracker_sub_categories.category_id, [prefix]_bugtracker_categories.name AS category_name
                  FROM [prefix]_bugtracker_sub_categories
                  JOIN [prefix]_bugtracker_categories
                  ON [prefix]_bugtracker_sub_categories.category_id = [prefix]_bugtracker_categories.id
                  WHERE [prefix]_bugtracker_sub_categories.id = ?";
        $query = $this->db()->getSqlWithPrefix($query);
        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $res = $stmt->get_result();

        $row = mysqli_fetch_assoc($res);

        return new SubCategoryModel($row['sub_category_id'], new CategoryModel($row['category_id'], $row['category_name']), $row['sub_category_name']);
    }

    public function saveSubCategory($id, $parentID, $name)
    {
        $link = $this->db()->getLink();

        $id = mysqli_real_escape_string($link, $id);
        $parentID = mysqli_real_escape_string($link, $parentID);
        $name = mysqli_real_escape_string($link, $name);

        $query = "UPDATE [prefix]_bugtracker_sub_categories SET category_id = ?, name = ? WHERE id = ?";
        $query = $this->db()->getSqlWithPrefix($query);
        $stmt = $link->prepare($query);
        $stmt->bind_param('isi', $parentID, $name, $id);
        $stmt->execute();
    }

    public function deleteSubCategory($id)
    {
        $link = $this->db()->getLink();

        $id = mysqli_real_escape_string($link, $id);

        $query = "DELETE FROM [prefix]_bugtracker_sub_categories WHERE id = ?";
        $query = $this->db()->getSqlWithPrefix($query);
        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }

    public function deleteSubCategoriesByParentID($parentID)
    {
        $link = $this->db()->getLink();

        $parentID = mysqli_real_escape_string($link, $parentID);

        $query = "DELETE FROM [prefix]_bugtracker_sub_categories WHERE category_id = ?";
        $query = $this->db()->getSqlWithPrefix($query);
        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $parentID);
        $stmt->execute();
    }
}
