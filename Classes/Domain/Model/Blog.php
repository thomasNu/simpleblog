<?php
namespace Lobacher\Simpleblog\Domain\Model;


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
 * This is a blog
 */
class Blog extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Title of the blog
	 *
	 * @var string
	 * @validate NotEmpty, Lobacher.Simpleblog:Word(maximumWords=5)
	 */
	protected $title = '';

	/**
	 * Description of the blog
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * Image of the blog
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $image = NULL;

	/**
	 * posts
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Lobacher\Simpleblog\Domain\Model\Post>
	 * @cascade remove
	 * @lazy
	 */
	protected $posts = NULL;

	/**
	 * __construct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties
	 * Do not modify this method!
	 * It will be rewritten on each save in the extension builder
	 * You may modify the constructor of this class instead
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->posts = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the image
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Sets the image
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
	 * @return void
	 */
	public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image) {
		$this->image = $image;
	}

	/**
	 * Adds a Post
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Post $post
	 * @return void
	 */
	public function addPost(\Lobacher\Simpleblog\Domain\Model\Post $post) {
		$this->posts->attach($post);
	}

	/**
	 * Removes a Post
	 *
	 * @param \Lobacher\Simpleblog\Domain\Model\Post $postToRemove The Post to be removed
	 * @return void
	 */
	public function removePost(\Lobacher\Simpleblog\Domain\Model\Post $postToRemove) {
		$this->posts->detach($postToRemove);
	}

	/**
	 * Returns the posts
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Lobacher\Simpleblog\Domain\Model\Post> $posts
	 */
	public function getPosts() {
		return $this->posts;
	}

	/**
	 * Sets the posts
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Lobacher\Simpleblog\Domain\Model\Post> $posts
	 * @return void
	 */
	public function setPosts(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $posts) {
		$this->posts = $posts;
	}

}