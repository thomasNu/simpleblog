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
 * BlogController
 */
class BlogController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * blogRepository
	 *
	 * @var \Lobacher\Simpleblog\Domain\Repository\BlogRepository
	 * @inject
	 */
	protected $blogRepository = NULL;

	/**
	 * action list
	 *
     * @return void
	 */
	public function listAction() {
        if ($this->request->hasArgument('search')) {
            $search = $this->request->getArgument('search');
        }
        $limit = ($this->settings['blog']['max']) ? : NULL;
        $this->view->assign('blogs', $this->blogRepository->findSearchForm($search, $limit));
        $this->view->assign('search', $search);
	}
    /**
     * show action - displays a single blog
     *
     * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
	 * @return void
     */
    public function showAction(\Lobacher\Simpleblog\Domain\Model\Blog $blog) {
        $this->view->assign('blog', $blog);
    }
	/**
	 * addForm action - displays a form for adding a blog
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
	 * @return void
	 */
	public function addFormAction(\Lobacher\Simpleblog\Domain\Model\Blog $blog = NULL) {
		$this->view->assign('blog', $blog);
	}
	/**
	 * add action - adds a blog to the repository
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
	 * @return void
     */
    public function addAction(\Lobacher\Simpleblog\Domain\Model\Blog $blog) {
        $this->blogRepository->add($blog);
        $this->redirect('list');
   	}
	/**
	 * updateForm action - displays a form for editing a blog
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
	 * @return void
	 */
	public function updateFormAction(\Lobacher\Simpleblog\Domain\Model\Blog $blog) {
		$this->view->assign('blog', $blog);
	}
	/**
	 * update action - updates a blog in the repository
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
	 * @return void
	 */
	public function updateAction(\Lobacher\Simpleblog\Domain\Model\Blog $blog) {
		$this->blogRepository->update($blog);
		$this->redirect('list');
	}
	/**
	 * deleteConfirm action - displays a form for confirming the deletion of a blog
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
	 * @return void
	 */
	public function deleteConfirmAction(\Lobacher\Simpleblog\Domain\Model\Blog $blog) {
		$this->view->assign('blog', $blog);
	}
	/**
	 * delete action - deletes a blog in the repository
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Blog $blog
	 * @return void
	 */
	public function deleteAction(\Lobacher\Simpleblog\Domain\Model\Blog $blog) {
		$this->blogRepository->remove($blog);
		$this->redirect('list');
	}
}