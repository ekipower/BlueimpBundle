<?php
/**
 * This file is part of the EkiBlueimpBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\BlueimpBundle\MediaSource;

interface SourceInterface
{
	/**
	* Get parameters for http response
	*
	* @return array 
	*/
	public function getParameters();
}
