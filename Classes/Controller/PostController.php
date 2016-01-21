<?php
namespace Lobacher\Simpleblog\Controller;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Patrick Lobacher <patrick.lobacher@typovision.com>, Typovision GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use Lobacher\Simpleblog\Domain\Model\Blog; 
use Lobacher\Simpleblog\Domain\Model\Post; 
use Lobacher\Simpleblog\Domain\Model\Comment; 

/**
 * PostController
 */
class PostController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * PostRepository
	 *
	 * @var \Lobacher\Simpleblog\Domain\Repository\PostRepository
	 * @inject
	 */
	protected $postRepository = NULL;

	/**
	 * FrontendUserRepository
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
	 * @inject
	 */
	protected $frontendUserRepository = NULL;

    /**
     * Initialize action - inits for all aktions
     *
	 * @return void
     */
    public function initializeAction() {
        $action = $this->request->getControllerActionName();
        if ((($this->settings['blog']['users']) ? : '0') == '0' && $action != 'show' && $action != 'ajax') {
            if (!$GLOBALS['TSFE']->fe_user->user['uid']) {
                $this->redirect(NULL, NULL, NULL, NULL, $this->settings['loginpage']);
            }
        }
    }
    /**
     * show action - displays a single post
     *
     * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
     * @param \Lobacher\Simpleblog\Domain\Model\Post $post
	 * @return void
     */
    public function showAction(Blog $blog, Post $post) {
        $this->view->assign('blog', $blog);
        $this->view->assign('post', $post);
    }
	/**
	 * addForm action - displays a form for adding a post
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
	 * @param \Lobacher\Simpleblog\Domain\Model\Post $post
	 * @return void
	 */
	public function addFormAction(Blog $blog, Post $post = NULL) {
		$this->view->assign('blog', $blog);
		$this->view->assign('post', $post);
        $this->view->assign('tags', $this->objectManager->get('Lobacher\\Simpleblog\\Domain\\Repository\\TagRepository')->findAll());
        $this->assignAuthorSelectOptions();
	}   
	/**
	 * add action - adds a post to the repository
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
	 * @param \Lobacher\Simpleblog\Domain\Model\Post $post
	 * @return void
     */
    public function addAction(Blog $blog, Post $post) {
        $post->setPostdate(new \DateTime());
        if ((($this->settings['blog']['users']) ? : '0') == '0') {
            $post->setAuthor($this->frontendUserRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']));
        }
        $blog->addPost($post);
        $this->objectManager->get('Lobacher\\Simpleblog\\Domain\\Repository\\BlogRepository')->update($blog);
        $this->redirect('show', 'Blog', NULL, array('blog' => $blog));
    }
	/**
	 * updateForm action - displays a form for editing a post
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
	 * @param \Lobacher\Simpleblog\Domain\Model\Post $post
	 * @return void
	 */
	public function updateFormAction(Blog $blog, Post $post) {
		$this->view->assign('blog', $blog);
		$this->view->assign('post', $post);
        $this->view->assign('tags', $this->objectManager->get('Lobacher\\Simpleblog\\Domain\\Repository\\TagRepository')->findAll());
        $this->assignAuthorSelectOptions();
	}
	/**
	 * update action - updates a post in the repository
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
	 * @param \Lobacher\Simpleblog\Domain\Model\Post $post
	 * @return void
	 */
	public function updateAction(Blog $blog, Post $post) {
		$this->postRepository->update($post);               
		$this->redirect('show', 'Blog', NULL, array('blog' => $blog));
	}
	/**
	 * deleteConfirm action - displays a form for confirming the deletion of a post
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
	 * @param \Lobacher\Simpleblog\Domain\Model\Post $post
	 * @return void
	 */
	public function deleteConfirmAction(Blog $blog, Post $post) {
		$this->view->assign('blog', $blog);
		$this->view->assign('post', $post);
	}
	/**
	 * delete action - deletes a post in the repository
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
	 * @param \Lobacher\Simpleblog\Domain\Model\Post $post
	 * @return void
	 */
	public function deleteAction(Blog $blog, Post $post) {
        $blog->removePost($post);
        $this->objectManager->get('Lobacher\\Simpleblog\\Domain\\Repository\\BlogRepository')->update($blog);
		$this->postRepository->remove($post);               
		$this->redirect('show', 'Blog', NULL, array('blog' => $blog));
	}
	/**
	 * ajax action - deletes a post in the repository
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Post $post
	 * @param \Lobacher\Simpleblog\Domain\Model\
	 * @return bool|string
	 */
	public function ajaxAction(Post $post, Comment $comment = NULL) {
        if ($comment->getComment()== '') return FALSE;
        $comment->setCommentdate(new \DateTime());
        $post->addComment($comment);
        $this->postRepository->update($post);
        $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager')->persistAll();
        $comments = $post->getComments();
        foreach ($comments as $comment){
            $json[$comment->getUid()] = array(
                'comment'=>$comment->getComment(),
                'commentdate' => $comment->getCommentdate()
            );
        }
        return json_encode($json);
    }
	protected function assignAuthorSelectOptions() {
        $authors = array();
        $users = explode(',', ($this->settings['blog']['users']) ? : '0');
        foreach ($users as $key => $uid) {
            $autors[] = $this->frontendUserRepository->findByUid($uid);
        }
        $this->view->assign('authors', $autors);
	}
}