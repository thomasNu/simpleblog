<?php
namespace Lobacher\Simpleblog\Validation\Validator;

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
 * WordValidator
 */
class WordValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {

	/**
	 * @var array
	 */
	protected $supportedOptions = array(
		'maximumWords' => array(10, 'Maximum words for a valid string', 'integer')
	);

	/**
	 * Checks if the given value matches the specified maximum words.
	 *
	 * @param mixed $value The value that should be validated
	 * @return void
	 */
    public function isValid($value) {
        $maximumWords = $this->options['maximumWords'];
        if (str_word_count($value) > $maximumWords) {
            $this->addError('Verringern Sie die Anzahl der Worte - es sind maximal ' . $maximumWords . ' erlaubt!', 1383400016);
        }
    }
}
?>
