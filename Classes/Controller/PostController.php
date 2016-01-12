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
     * show action - displays a single post
     *
     * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
     * @param \Lobacher\Simpleblog\Domain\Model\Post $post
	 * @return void
     */
    public function showAction(
            \Lobacher\Simpleblog\Domain\Model\Blog $blog,
            \Lobacher\Simpleblog\Domain\Model\Post $post) {
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
	public function addFormAction(
            \Lobacher\Simpleblog\Domain\Model\Blog $blog,
            \Lobacher\Simpleblog\Domain\Model\Post $post = NULL) {
		$this->view->assign('blog', $blog);
		$this->view->assign('post', $post);
	}
	/**
	 * add action - adds a post to the repository
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
	 * @param \Lobacher\Simpleblog\Domain\Model\Post $post
	 * @return void
     */
    public function addAction(
            \Lobacher\Simpleblog\Domain\Model\Blog $blog,
            \Lobacher\Simpleblog\Domain\Model\Post $post) {
        $post->setPostdate(new \DateTime());
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
	public function updateFormAction(
            \Lobacher\Simpleblog\Domain\Model\Blog $blog,
            \Lobacher\Simpleblog\Domain\Model\Post $post) {
		$this->view->assign('blog', $blog);
		$this->view->assign('post', $post);
	}
	/**
	 * update action - updates a post in the repository
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
	 * @param \Lobacher\Simpleblog\Domain\Model\Post $post
	 * @return void
	 */
	public function updateAction(
            \Lobacher\Simpleblog\Domain\Model\Blog $blog,
            \Lobacher\Simpleblog\Domain\Model\Post $post) {
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
	public function deleteConfirmAction(
            \Lobacher\Simpleblog\Domain\Model\Blog $blog,
            \Lobacher\Simpleblog\Domain\Model\Post $post) {
		$this->view->assign('blog', $blog);
		$this->view->assign('post', $post);
	}
	/**
	 * delete action - deletes a post in the repository
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Post $blog
	 * @return void
	 */
	public function deleteAction(
            \Lobacher\Simpleblog\Domain\Model\Blog $blog,
            \Lobacher\Simpleblog\Domain\Model\Post $post) {
        $blog->removePost($post);
        $this->objectManager->get('Lobacher\\Simpleblog\\Domain\\Repository\\BlogRepository')->update($blog);
		$this->postRepository->remove($post);               
		$this->redirect('show', 'Blog', NULL, array('blog' => $blog));
	}
}