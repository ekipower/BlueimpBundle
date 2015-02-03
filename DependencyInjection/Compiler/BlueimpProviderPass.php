<?php
/**
 * This file is part of the EkiBlueimpBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\BlueimpBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use \LogicException;

class BlueimpProviderPass implements CompilerPassInterface
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process( ContainerBuilder $container )
    {
        foreach ( $container->findTaggedServiceIds( 'eki_blueimp.provider' ) as $id => $attributes )
        {
			foreach( $attributes as $attribute )
			{
				if ( !isset($attribute['alias']) )
				{
					throw new \LogicException('Tag with name "alias" must be specified.');				
				}
				
				if ( 'eki_blueimp.provider.'.$attribute['alias'] !== $id )
				{
					$container->setAlias('eki_blueimp.provider.'.$attribute['alias'], $id);
				}
			}
		}
    }
}