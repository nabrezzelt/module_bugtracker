<?php
/**
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Modules\Bugtracker\Controllers\Admin;

use Modules\Bugtracker\Mappers\Comment as CommentMapper;
use Modules\Bugtracker\Mappers\Bug as BugMapper;
use Modules\Bugtracker\Mappers\Category as CategoryMapper;
use Modules\Bugtracker\Mappers\SubCategory as SubCategoryMapper;

class Index extends \Ilch\Controller\Admin
{
    public function init()
    {
        $items = [
            [
                'name' => 'Bugtracker',
                'active' => false,
                'icon' => 'fa fa-th-list',
                'url' => $this->getLayout()->getUrl(['controller' => 'index', 'action' => 'index']),
                [
                    'name' => 'Add Category',
                    'active' => false,
                    'icon' => 'fa fa-plus-circle',
                    'url' => $this->getLayout()->getUrl(['controller' => 'index', 'action' => 'addCategory'])
                ],
                [
                    'name' => 'Add Sub-Category',
                    'active' => false,
                    'icon' => 'fa fa-plus-circle',
                    'url' => $this->getLayout()->getUrl(['controller' => 'index', 'action' => 'addSubCategory'])
                ],
            ]
        ];

        if ($this->getRequest()->getActionName() == 'addCategory')
        {
            $items[0][0]['active'] = true;
        }
        else if ($this->getRequest()->getActionName() == 'addSubCategory')
        {
            $items[0][1]['active'] = true;
        }
        else {
            $items[0]['active'] = true;
        }

        $this->getLayout()->addMenu
        (
            'Announcements',
            $items
        );
    }

    public function indexAction()
    {
        $categoryMapper = new CategoryMapper();
        $subCategoryMapper = new SubCategoryMapper();

        $categories = $categoryMapper->getAllCategories();

        $subCategories = $subCategoryMapper->getAllSubCategories();

        $this->getView()->set('categories', $categories);
        $this->getView()->set('subCategories', $subCategories);
    }

    public function addCategoryAction()
    {
        $name = $this->getRequest()->getPost('name');

        if(isset($name))
        {
            $categoryMapper = new CategoryMapper();
            $categoryMapper->createCategory($name);

            $this->redirect(['controller' => 'index', 'action' => 'index']);
        }
    }

    public function addSubCategoryAction()
    {
        $categoryMapper = new CategoryMapper();
        $subCategoryMapper = new SubCategoryMapper();

        $parentID = $this->getRequest()->getPost('parent-id');
        $name = $this->getRequest()->getPost('name');

        if(isset($parentID) && isset($name))
        {
            $subCategoryMapper->createSubCategory($parentID, $name);
            $this->redirect(['controller' => 'index', 'action' => 'index']);
            return;
        }

        $this->getView()->set('categories', $categoryMapper->getAllCategories());
    }

    public function editCategoryAction()
    {
        $categoryMapper = new CategoryMapper();

        $categoryID = $this->getRequest()->getParam('id');

        if(isset($categoryID))
        {
            $category = $categoryMapper->getCategoryByID($categoryID);
            $this->getView()->set('category', $category);
        }
        else
        {
            $this->redirect(['controller' => 'index', 'action' => 'index']);
        }
    }

    public function saveCategoryAction()
    {
        $categoryMapper = new CategoryMapper();

        $categoryID = $this->getRequest()->getParam('id');
        $name = $this->getRequest()->getPost('name');

        if(isset($categoryID) && isset($name))
        {
            $categoryMapper->saveCategory($categoryID, $name);
            $this->redirect(['controller' => 'index', 'action' => 'index']);
        }
    }

    public function editSubCategoryAction()
    {
        $categoryMapper = new CategoryMapper();
        $subCategoryMapper = new SubCategoryMapper();

        $subCategoryID = $this->getRequest()->getParam('id');

        if(isset($subCategoryID))
        {
            $subCategory = $subCategoryMapper->getSubCategoryByID($subCategoryID);
            $this->getView()->set('subCategory', $subCategory);
            $this->getView()->set('categories', $categoryMapper->getAllCategories());
        }
        else
        {
            $this->redirect(['controller' => 'index', 'action' => 'index']);
        }
    }

    public function saveSubCategoryAction()
    {
        $subCategoryMapper = new SubCategoryMapper();

        $subCategoryID = $this->getRequest()->getParam('id');
        $parentID = $this->getRequest()->getPost('parent-id');
        $name = $this->getRequest()->getPost('name');

        if(isset($subCategoryID) && isset($parentID) && isset($name))
        {
            $subCategoryMapper->saveSubCategory($subCategoryID, $parentID, $name);
            $this->redirect(['controller' => 'index', 'action' => 'index']);
        }
        else
        {
        	$this->redirect(['controller' => 'index', 'action' => 'index']);
        }
    }

    public function deleteCategoryAction()
    {
        $categoryID = $this->getRequest()->getParam('id');

        if(isset($categoryID))
        {
            $commentMapper = new CommentMapper();
            $bugMapper = new BugMapper();
            $categoryMapper = new CategoryMapper();
            $subCategoryMapper = new SubCategoryMapper();

            $commentMapper->deleteCommentsByCategoryID($categoryID);
            $bugMapper->removeAssigneesByCategoryID($categoryID);
            $bugMapper->deleteBugByCategoryID($categoryID);
            $subCategoryMapper->deleteSubCategoriesByParentID($categoryID);
            $categoryMapper->deleteCategory($categoryID);
        }

        $this->redirect(['controller' => 'index', 'action' => 'index']);
    }

    public function deleteSubCategoryAction()
    {
        $subCategoryID = $this->getRequest()->getParam('id');

        if(isset($subCategoryID))
        {
            $commentMapper = new CommentMapper();
            $bugMapper = new BugMapper();
            $subCategoryMapper = new SubCategoryMapper();

            $commentMapper->deleteCommentsBySubCategoryID($subCategoryID);
            $bugMapper->removeAssigneeBySubCategoryID($subCategoryID);
            $bugMapper->deleteBugBySubCategoryID($subCategoryID);
            $subCategoryMapper->deleteSubCategory($subCategoryID);
        }

        $this->redirect(['controller' => 'index', 'action' => 'index']);
    }
}
