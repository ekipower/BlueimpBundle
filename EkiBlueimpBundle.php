<?php
/**
 * This file is part of the EkiBlueimpBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\BlueimpBundle;

use Eki\BlueimpBundle\DependencyInjection\Compiler\BlueimpProviderPass;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EkiBlueimpBundle extends Bundle
{
	/**
	* 
	* @inheritdoc
	* 
	*/
 	public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new BlueimpProviderPass());
    }
}
