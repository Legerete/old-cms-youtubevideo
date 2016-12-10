<?php

/**
 * @copyright   Copyright (c) 2016 Wunderman s.r.o. <wundermanprague@wunwork.cz>
 * @author      Petr Besir Horáček <sirbesir@gmail.com>
 * @author      Pavel Janda <me@paveljanda.com>
 * @package     Wunderman\CMS\YoutubeVideo
 */

namespace Wunderman\CMS\YoutubeVideo\DI;

use Nette\DI\CompilerExtension;
use Nette\Utils\Arrays;

class YoutubeVideoExtension extends CompilerExtension
{

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$extensionConfig = $this->loadFromFile(__DIR__ . '/config.neon');
		$this->compiler->parseServices($builder, $extensionConfig, $this->name);

		$builder->parameters = Arrays::mergeTree(
			$builder->parameters,
			Arrays::get($extensionConfig, 'parameters', [])
		);
	}


	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();

		/**
		 * Adding custom CSS for extension
		 */
		$builder->getDefinition("webloader.cssPublicFiles")->addSetup('addFile', [realpath(__DIR__ . '/css/main.css')]);
		$builder->getDefinition("webloader.cssPrivateFiles")->addSetup('addFile', [realpath(__DIR__ . '/css/main.css')]);

		$builder->getDefinition('privateComposePresenter')->addSetup(
			'addExtensionService',
			['youtubeVideo', $this->prefix('@privateModuleService')]
		);

		/**
		 * PublicModule component
		 */
		$builder->getDefinition('publicComposePresenter')->addSetup(
			'setComposeComponentFactory',
			['youtubeVideo', $this->prefix('@publicYoutubeVideoFactory')]
		);

		/**
		 * PrivateModule component
		 */
		$builder->getDefinition('privateComposePresenter')->addSetup(
			'setComposeComponentFactory',
			['youtubeVideo', $this->prefix('@privateYoutubeVideoFactory')]
		);
	}

}
