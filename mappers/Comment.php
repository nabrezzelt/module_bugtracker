<?php
/**
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Modules\Bugtracker\Mappers;

use Modules\Bugtracker\Models\Comment as CommentModel;
use Modules\User\Mappers\User as UserMapper;
use Ilch\Date;

class Comment extends \Ilch\Mapper
{
    public function getAllCommentsByBugID($bugID)
    {
        $userMapper = new UserMapper();

        $link = $this->db()->getLink();
        $bugID = mysqli_real_escape_string($link, $bugID);


        $query = "SELECT * FROM bugtracker_comments WHERE bug_id = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $bugID);
        $stmt->execute();

        $res = $stmt->get_result();

        $i = 0;
        $comments = array();

        while($row = mysqli_fetch_assoc($res))
        {
            $id = $row['id'];
            $bugID = $row['bug_id'];
            $content = $row['content'];
            $user = $userMapper->getUserById((int) $row['poster_id']);
            $internOnly = (boolean) $row['intern_only'];
            $createTime = new Date($row['create_time']);

            $comments[$i] = new CommentModel($id, $bugID, $content, $user, $internOnly, $createTime);
            $i++;
        }

        return $comments;
    }

    public function addComment($bugID, $content, $userID, $internOnly)
    {
        $link = $this->db()->getLink();

        $query = "INSERT INTO bugtracker_comments (`bug_id`, `content`, `poster_id`, `intern_only`) VALUES (?, ?, ?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param('isii', $bugID, $content, $userID, $internOnly);
        var_dump($bugID, $content, $userID, $internOnly);
        $stmt->execute();
    }

    public function saveComment($commentID, $content)
    {
        
    }

    public function deleteComment($commentID)
    {
        
    }
}
