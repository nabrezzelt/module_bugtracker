<?php
    $bugs = $this->get('bugs');
    $status = $this->get('status');
    $categories = $this->get('categories');
    $subCategories = $this->get('subCategories');

    $filter_keywords = $this->get('filter-keywords');
    $filter_status = $this->get('filter-status');
    $filter_category = $this->get('filter-category');
    $filter_sub_category = $this->get('filter-sub-category');
    $filter_my_reports = $this->get('filter-my-reports-only');
    $filter_internal_reports_only = $this->get('filter-internal-reports-only');

    $user = \Ilch\Registry::get('user');    
?>

<div class="row">
    <div class="col-sm-6">
        <h1>Bugtracker</h1> 
    </div>
    <div class="col-sm-6 text-right">
        <a class='btn btn-success' href='<?php echo $this->getUrl(['module'=> 'bugtracker', 'controller' => 'index', 'action' => 'new']); ?>'>New Issue</a>
    </div>
</div>    
<div class="row">
    <div class="col-sm-12">
        <p>Filter:</p>
        <form class="form-inline" method="POST">
            <?php echo $this->getTokenField(); ?>
            <div class="form-group">
                <label>Keywords</label>
                <input name="keywords" type="text" class="form-control" value="<?php echo $filter_keywords; ?>" />
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="0">All Status</option>

                    <?php
                        foreach ($status as $s)
                        {                                                        
                            echo "<option value='{$s->getID()}' " . (($s->getID() == $filter_status) ? 'selected': '') . ">{$s->getName()}</option>";
                        }
                    ?>
                    
                </select>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category" class="form-control">                    
                    <option value="0">All Categories</option>

                    <?php
                    foreach ($categories as $c)
                    {
                        echo "<option value='{$c->getID()}' " . (($c->getID() == $filter_category) ? 'selected': '') . ">{$c->getName()}</option>";
                    }
                    ?>
                    
                </select>
            </div>
            <div class="form-group">
                <label>Sub-Category:</label>                
                <select name="sub-category" class="form-control">                    
                    <option name="sub-category" value="0">All Sub Categories</option>

                    <?php
                    foreach ($subCategories as $sc)
                    {                        
                        echo "<option data-parent-id='{$sc->getCategory()->getID()}' value='{$sc->getID()}' " . (($sc->getID() == $filter_sub_category) ? 'selected': '') . ">{$sc->getName()}</option>";
                    }
                    ?>
                    
                </select>
            </div>
            <br />
            <div class="checkbox">
                <label>
                    <input name="my-reports-only" type="checkbox" value="1" <?php echo (($filter_my_reports == 1) ? 'checked': ''); ?>/> My reports only
                </label>
            </div>
            <?php            
            if(isset($user) && $user->isAdmin())
            {
                echo "<div class='checkbox'>
                        <label>
                            <input name='internal-reports-only' type='checkbox' value='1' " . (($filter_internal_reports_only == 1) ? 'checked': '') . "/> Internal Reports only
                        </label>
                     </div>"; 
            }
            ?>
            
            <button type="submit" class="btn btn-default">Filter</button>
            <button type="reset" class="btn btn-default disabled">Reset</button>
        </form>
        <br />
    </div>        
</div>
<div class="row">
    <div class="col-sm-12">
        <table class="table buglist">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Updated</th>
                    <th>Created By</th>
                    <th>Created</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($bugs as $bug)
                    {                        
                        echo "<tr>
                                  <td>{$bug->getID()}</td>
                                  <td>{$bug->getTitle()}</td>
                                  <td>{$bug->getSubCategory()->getCategory()->getName()} > {$bug->getSubCategory()->getName()}</td>
                                  <td>{$bug->getStatus()->getName()}</td>
                                  <td>{$bug->getPriority()}</td>
                                  <td>{$bug->getUpdateTime()}</td>
                                  <td>{$bug->getUser()->getName()}</td>
                                  <td>{$bug->getCreateTime()}</td>
                                  <td>L: " . count($bug->getLikes()) . " | DL: " . count($bug->getDislikes()) . "</td>
                              </tr>";
                    }
                ?>                
            </tbody>
        </table>
    </div>        
</div>

<?php
    //var_dump($this->get('bugs'));
?>


<script>
    $(document).ready(function(){
        $('#buglist').DataTable({
            "order": [[ 0, "desc" ]],
            searching: false,
            "pageLength": 20
        });
    });
</script>