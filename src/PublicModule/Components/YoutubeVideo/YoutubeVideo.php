<?php

/**
 * @copyright   Copyright (c) 2016 Wunderman s.r.o. <wundermanprague@wunwork.cz>
 * @author      Petr Besir Horáček <sirbesir@gmail.com>
 * @package     Wunderman\CMS\YoutubeVideo
 */

namespace Wunderman\CMS\YoutubeVideo\PublicModule\Components\YoutubeVideo;

use Nette\Application\UI\Control;
use Kdyby\Doctrine\EntityManager;
use App\Entity\Attachment;

/**
 * Menu
 * @author Petr Besir Horáček <sirbesir@gmail.com>
 */
class YoutubeVideo extends Control
{

	/**
	 * @var EntityManager
	 */
	private $em;


	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}


	/**
	 * @var array $params
	 */
	public function render($params)
	{
		$this->getTemplate()->params = $params;
		$this->getTemplate()->video = isset($params['id']) ? $this->getAttachmentRepository()->find((int) $params['id']) : FALSE;

		$this->getTemplate()->render(__DIR__.'/templates/YoutubeVideo.latte');
	}


	public function getAttachmentRepository()
	{
		return $this->em->getRepository(Attachment::class);
	}

}
