<?php

namespace Wunderman\CMS\YoutubeVideo\PrivateModule\Components\YoutubeVideo;

interface IYoutubeVideoFactory
{

	/**
	 * @return YoutubeVideo
	 * @param  array $componentParams
	 */
	public function create(array $componentParams);

}
