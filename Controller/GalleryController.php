<?php
/**
 * This file is part of the EkiBlueimpGalleryBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\BlueimpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class GalleryController extends Controller
{
	/**
	* Get source of media
	* 
	* @param mixed $sourceId
	* @param string $type
	*
	* @return mixed 
	*/
	protected function getSource( $sourceId, $type )
	{
		if ( null === ( $provider = $this->findProvider( $type ) ) )
		{
			throw new \LogicException('Cannot find any media provider with type ' . $type);	
		}
		
		return $provider->getSource($sourceId);
	}


	/**
	* Get default template type
	*
	* @return mixed 
	*/
	protected function getDefaultTemplateType()
	{
		return 'default';
	}

	/**
	* Get template name
	* 
	* @param string $templateType
	* @param string $kind
	*
	* @return mixed 
	*/
	protected function getTemplateName( $templateType, $kind )
	{
		return 'EkiBlueimpGalleryBundle:blueimp/' . $templateType . ':' . $kind . '.html.twig';
	}
	
	/**
	* Find a provider with type
	* 
	* @param undefined $type
	*
	* @return Eki\BlueimpGalleryBundle\MediaSource\ProviderInterface 
	*/
	protected function findProvider( $type )
	{
		$key = 'eki_blueimp.provider.'.$type;
		if ( $this->container->has($key) )
		{
			return $this->container->get($key);
		}
		
		return null;
	}
	
    /**
     * Get selector for gallery
     *
     * @param mixed $sourceId
     * @param string $type
	 * @param string $template
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function selectorAction( $sourceId, $type, $template = null, array $params = array() )
    {
		return $this->selectorForSource(
			$this->getSource($sourceId, $type), 
			$template, 
			$type, 
			$params
		);
    }
	
    /**
     * Get selector for gallery source
     *
     * @param mixed $sourceId
     * @param string $type
	 * @param string $template
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\Response
     */
	protected function selectorForSource( $sourceId, $template, $type, array $params)
	{
		
	}
	
    /**
     * Get source links for gallery
     *
     * @param mixed $sourceId
     * @param string $type
	 * @param string $template
     * @param array $params
	 * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function linksAction( $sourceId, $type, $template = null, array $params = array() )
    {
		if ( $template === null )
		{
			if ( null !== ( $provider = $this->findProvider($type) ) )
			{
				$template = $provider->getTemplate('links');
			}
		}
		
		return $this->linksForSource(
			$this->getSource($sourceId, $type), 
			$template, 
			$params
		);
    }
	
	/**
	* 
	* @param mixed $source
	* @param string $template
	* @param array $params
	* 
    * @return \Symfony\Component\HttpFoundation\Response
	*/
	protected function linksForSource( $source, $template, array $params )
	{
		return $this->render(
			$template,
			$source->getParameters() + $params
		);
	}

    /**
     * Get scripts for gallery
     *
     * @param mixed $sourceId
     * @param string $type
	 * @param string $template
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function scriptAction( $sourceId, $type = 'default', $template = null, array $params = array() )
	{
		$links = array();
		$options = array();
		
		if ( isset($params['links']) )
		{
			$links += $params['links'];
		}
		if ( isset($params['options']) )
		{
			$options += $params['options'];
		}
		
        return $this->scriptForSource(
            $this->getSource($sourceId, $type),
            $template,
			$type,
			array(
				'links' => $links,
				'options' => $options
			) + $params
        );
	}
	
    /**
     * Get scripts for gallery
     *
     * @param mixed $sourceId
     * @param string $type
	 * @param string $template
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\Response
     */
	protected function scriptForSource( $sourceId, $template, $type, array $params = array() )
	{
		
	}
}
