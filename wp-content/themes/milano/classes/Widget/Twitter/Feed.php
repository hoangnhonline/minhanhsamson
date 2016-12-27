<?php

class Widget_Twitter_Feed
{
	private $username = '';

	public function getFeedItems($username, $feedItemsNum = 5, $encode = true, $extractLinks = true, $extractUsers = true, $target_blank = false)
	{
		$this->username = $username;
		$aMessage = $this->getTwitterMessages($username, $feedItemsNum);

		if (empty($aMessage))
		{
			return array();
		}
		if (!is_wp_error($aMessage))
		{
			$aMessage = $this->parseMessages($aMessage, $encode, $extractLinks, $extractUsers, $target_blank);
			return $aMessage;
		}
		else
		{
			return "Error";
		}
	}

	/**
	 * Authenticating a User Timeline for Twitter OAuth API V1.1
	 * @see http://www.webdevdoor.com/php/authenticating-twitter-feed-timeline-oauth/
	 * @param type $username
	 * @param type $num
	 * @return type
	 */
	protected function getTwitterMessages($username, $num = 5)
	{
		include_once(ABSPATH . WPINC . '/feed.php');

		$connection = new Widget_Twitter_TwitterOAuth(
				get_option(SHORTNAME . '_consumer_key'),
				get_option(SHORTNAME . '_consumer_secret'),
				get_option(SHORTNAME . '_access_token'),
				get_option(SHORTNAME . '_access_token_secret'));

		//"https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$username."&count=".$num);
		$aMessage = $connection->get('statuses/user_timeline',
														array(
														  'screen_name'     => $username,
														  'count'           => $num,
														  'exclude_replies' => false
														)
									);
		if(!empty($aMessage) && !isset($aMessage->errors)) { // $connection->http_code != 200) {
			return $aMessage;
		}
		return array();
	}

	protected function parseMessages($aMessage, $encode, $extractLinks, $extractUsers, $target_blank)
	{
		$aParsedMsg = array();

		foreach ($aMessage as $tweet)
		{
			$content = $tweet->text;
			if ($encode)
			{
				//	for avoid re reconverting
				if(mb_detect_encoding($content) != 'UTF-8')
				{
					$content = utf8_encode($content);
				}
			}

			if ($extractLinks)
			{
				$content = $this->extractHyperlinks($content, $target_blank);
			}

			if ($extractUsers)
			{
				$content = $this->extractUsers($content, $target_blank);
			}
			
			$item['link'] = 'http://twitter.com/#!/'. $this->username .'/status/'. $tweet->id_str; //$tweet->get_link();
			$item['description'] = $content;
			$item['date-posted'] = $this->getMessageTimestamp($tweet->created_at);
			$aParsedMsg[] = $item;
		}
		return $aParsedMsg;
	}

	protected function getMessageTimestamp($publishDate)
	{
		
		$h_time = null;
		$time = strtotime($publishDate);
		if (( abs(time() - $time) ) < 864000)
		{
			$h_time = sprintf(__('%s ago', 'milano'), human_time_diff($time));
		}
		else
		{
			$h_time = date_i18n('Y/m/d', $time);
		}
		return sprintf(__('%s', 'milano'), ' <span class="twitter-timestamp">' . $h_time . '</span>');
	}

	private function extractHyperlinks($text, $target_blank = false)
	{
		$target = '';
		if($target_blank)
		{
			$target = ' target=\"_blank\"';
		}
		$text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i', "<a href=\"$1\" class=\"twitter-link\"$target>$1</a>", $text);

		$text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i', "<a href=\"http://$1\" class=\"twitter-link\"$target>$1</a>", $text);

		$text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i", "<a href=\"mailto://$1\" class=\"twitter-link\"$target>$1</a>", $text);

		$text = preg_replace('/([\.|\,|\:|\�|\�|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/search?q=$2\" class=\"twitter-link\"$target>#$2</a>$3 ", $text);
		return $text;
	}

	private function extractUsers($text, $target_blank = false)
	{
		$target = '';
		if($target_blank)
		{
			$target = ' target=\"_blank\"';
		}
		
		$text = preg_replace('/([\.|\,|\:|\�|\�|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\"$target>@$2</a>$3 ", $text);
		return $text;
	}
}
?>