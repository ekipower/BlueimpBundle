<?php
/**
 * This file is part of the EkiBlueimpBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\BlueimpBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class FrameExtension extends \Twig_Extension
{
	/**
	* 
	* @var Symfony\Component\DependencyInjection\ContainerInterface
	* 
	*/
	private $container;
	
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}
	
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'eki_blueimp_head' => new \Twig_Function_Method($this, 'head', array('is_safe' => array('html'))),
            'eki_blueimp_lightbox' => new \Twig_Function_Method($this, 'lightbox', array('is_safe' => array('html'))),
            'eki_blueimp_script_including' => new \Twig_Function_Method($this, 'script_including', array('is_safe' => array('html'))),
            'eki_blueimp_script_links' => new \Twig_Function_Method($this, 'script_links', array('is_safe' => array('html'))),
            'eki_blueimp_script_lightbox' => new \Twig_Function_Method($this, 'script_lightbox', array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders the include in head
     *
     * @param string|null $type
     * @param string|null $template
     *
     * @return Response
     */
    public function head($type = null, $template = null)
    {
		return $this->container->get('templating')->render( $this->getTemplateName('head', $type, $template), array() );
	}
	
	/**
	* Render lightbox for gallery
	* 
	* @param array $options
	* 
	* @return Response
	*/
	public function lightbox(array $options = array(), $type = null, $template = null)
	{
		if ( !isset($options['close']) )
		{
			$options['close'] = true;
		}

		if ( !isset($options['caption']) )
		{
			$options['caption'] = false;
		}

		if ( !isset($options['controls']) )
		{
			$options['controls'] = false;
		}

		if ( !isset($options['indicator']) )
		{
			$options['indicator'] = true;
		}

		if ( !isset($options['carousel']) )
		{
			$options['carousel'] = false;
		}
		
		if ( !isset($options['lightboxId']) )
		{
			$options['lightboxId'] = 'blueimp-gallery';
		}

		if ( !isset($options['lightboxClass']) )
		{
			$options['lightboxClass'] = 'blueimp-gallery';
		}
		
		if ( !isset($options['slidesClass']) )
		{
			$options['slidesClass'] = 'slides';
		}

		if ( !isset($options['titleClass']) )
		{
			$options['titleClass'] = 'title';
		}
		
		if ( !isset($options['captionClass']) )
		{
			$options['captionClass'] = 'description';
		}

		return $this->container->get('templating')->render( 
			$this->getTemplateName('lightbox', $type, $template), 
			$options
		);
	}

	/**
	* Render including script
	* 
	* @param array $options
	* 
	* @return Response
	*/
	public function script_including($type = null, $template = null)
	{
		return $this->container->get('templating')->render( 
			$this->getTemplateName('script_including', $type, $template), 
			array() 
		);
	}

	/**
	* Render links script
	* 
	* @param array $options
	* 
	* @return Response
	*/
	public function script_links(array $blueimpOptions = array(), array $options = array(), $type = null, $template = null)
	{
		if ( !isset($blueimpOptions['index']) )
		{
			$blueimpOptions['index'] = 'link';
		}

		if ( !isset($blueimpOptions['event']) )
		{
			$blueimpOptions['event'] = 'event';
		}
		
		if ( !isset($options['linksId']) )
		{
			$options['linksId'] = 'links';
		}	
			
		return $this->container->get('templating')->render( 
			$this->getTemplateName('script_links', $type, $template), 
			array(
				'options' => $options,
				'blueimpOptions' => $blueimpOptions,
			) 
		);
	}

	/**
	* Render lightbox script
	* 
	* @param array $options
	* 
	* @return Response
	*/
	public function script_lightbox(array $options = array(), $type = null, $template = null)
	{
		if ( !isset($options['linksId']) )
		{
			$options['linksId'] = 'links';
		}
		if ( !isset($options['lightboxId']) )
		{
			$options['lightboxId'] = 'blueimp-gallery';
		}
		if ( !isset($options['slidesClass']) )
		{
			$options['slidesClass'] = 'slides';
		}

		if ( !isset($options['titleClass']) )
		{
			$options['titleClass'] = 'title';
		}
		
		if ( !isset($options['captionClass']) )
		{
			$options['captionClass'] = 'description';
		}
		
		return $this->container->get('templating')->render( 
			$this->getTemplateName('script_lightbox', $type, $template),
			$options
		);
	}

    /**
     * Gets template name
     *
     * @param string|null $type
     * @param string|null $template
     *
     * @return Response
     */
    private function getTemplateName($kind, $type = null, $template = null)
    {
		$type = $type === null ? 'default' : $type;
		if ( $template === null )
		{
			$provider = null;
			
			if ( $this->container->has('eki_blueimp.provider.'.$type) )	
			{
				$provider = $this->container->get('eki_blueimp.provider.'.$type);
			}
			
			if ( $provider === null || null === ( $template = $provider->getTemplate($kind) ) )
			{
				$template = 'EkiBlueimpBundle:blueimp/'.$type.':'.$kind.'.html.twig';
				
			}

			if ( !file_exists(__DIR__.'/../Resources/views/blueimp/'.$type.'/'.$kind.'.html.twig') )
			{
				$template = 'EkiBlueimpBundle:blueimp/default:'.$kind.'.html.twig';
			}
		}
		
		return $template;
	}

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'eki_blueimp_frame';
    }
}
