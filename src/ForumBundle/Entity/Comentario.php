<?php


namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Comment as BaseComment;
use FOS\CommentBundle\Model\SignedCommentInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\CommentBundle\Model\VotableCommentInterface;

/**
 * @ORM\Entity
 * @ORM\Table("comentarios")
 */
class Comentario extends BaseComment implements SignedCommentInterface,  VotableCommentInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Thread of this comment
     *
     * @var Thread
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\Thread")
     */
    protected $thread;

     /**
     * Author of the comment
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Usuario")
     * @var User
     */
    protected $author;

     /**
     *  contador de likes
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $contLikes = 0;


    public function setAuthor(UserInterface $author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getAuthorName()
    {
        if (null === $this->getAuthor()) {
            return 'Anonymous';
        }

        return $this->getAuthor()->getUsername();
    }

     /**
     * Sets the score of the comment.
     *
     * @param integer $score
     */
    public function setScore($score)
    {
        $this->contLikes = $score;
    }

    /**
     * Returns the current score of the comment.
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->contLikes;
    }

    /**
     * Increments the comment score by the provided
     * value.
     *
     * @param integer value
     *
     * @return integer The new comment score
     */
    public function incrementScore($by = 1)
    {
        $this->contLikes += $by;
    }



}