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

interface ProviderInterface
{
	/**
	* Get unique type of provider
	*
	* @return string 
	*/
	public function getName();
	
	/**
	* Get source of media
	* 
	* @param mixed $sourceId
	*
	* @return mixed 
	*/
	public function getSource( $sourceId );
	
	/**
	* Gets template 
	* 
	* @param string $kind
	* 
	* @return string
	*/
	public function getTemplate($kind);
}
