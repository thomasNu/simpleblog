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
 * Comments
 */
class Comment extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Post comment
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $comment = '';

	/**
	 * Comment Date
	 *
	 * @var \DateTime
	 */
	protected $commentdate = NULL;

	/**
	 * Returns the comment
	 *
	 * @return string $comment
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * Sets the comment
	 *
	 * @param string $comment
	 * @return void
	 */
	public function setComment($comment) {
		$this->comment = $comment;
	}

	/**
	 * Returns the commentdate
	 *
	 * @return \DateTime $commentdate
	 */
	public function getCommentdate() {
		return $this->commentdate;
	}

	/**
	 * Sets the commentdate
	 *
	 * @param \DateTime $commentdate
	 * @return void
	 */
	public function setCommentdate(\DateTime $commentdate) {
		$this->commentdate = $commentdate;
	}

}