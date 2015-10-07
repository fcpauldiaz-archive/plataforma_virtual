<?php


namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Comment as BaseComment;
use FOS\CommentBundle\Model\SignedCommentInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * 
 */
class Comment extends BaseComment implements SignedCommentInterface
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
    protected $autor;


    public function setAuthor(UserInterface $autor)
    {
        $this->autor = $autor;
    }

    public function getAuthor()
    {
        return $this->autor;
    }

    public function getNombreAutor()
    {
        if (null === $this->getAuthor()) {
            return 'Anonymous';
        }

        return $this->getAuthor()->getUsername();
    }


}