<?php
/**
 * Class helper
 */
class Theme
{
	
	static function get_post_video($post_id, $echo = false)
	{
		
		$video_url = get_post_meta($post_id, SHORTNAME . '_post_video_url', true);
		if($video_url)
		{

			if($id = self::getYouTubeID($video_url))
			{
				wp_enqueue_script('swfobject');
			$html = <<<HTML
				<div id="id$id" class="youtube" data-id="{$id}"><iframe width="400" height="200" src="http://www.youtube.com/embed/{$id}" frameborder="0" allowfullscreen></iframe></div>
				<script type="text/javascript">
						jQuery(document).ready(function() {
							initYoutube('$id');
						});
						function pauseOtherExcept_id$id(state)
						{
							if(state == 1)
							{
								galleryVideo.pauseOther('id$id');
							}
						}
				</script>
HTML;
			}
			elseif($id = self::getVimeoID($video_url))
			{
				wp_enqueue_script('th_frogoloop');


			$html = <<<HTML
			<iframe id="id$id" src="http://player.vimeo.com/video/$id?api=1&&player_id=id$id" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen data-player="vimeo" data-id="$id"></iframe>
			<script type="text/javascript">
						jQuery(document).ready(function() {
								initVimeoVideo('$id');
						});
					</script>
HTML;
			}
			else
			{
				switch(pathinfo($video_url, PATHINFO_EXTENSION))
				{
					case 'mp4':
					case 'm4v':  //mp4
						$media = "{m4v: '$video_url', poster:'".get_option(SHORTNAME . "_logo_custom")."'}";
						$supplied = 'supplied: "m4v",';
						break;
					case 'ogv':
					case 'ogg':
						$media = "{ogv: '$video_url'}";
						$supplied = 'supplied: "ogv",';
						break;
					case 'webmv':
					case 'webm':
						$media = "{webmv: '$video_url'}";
						$supplied = 'supplied: "webmv",';
						break;
					default:
						$media = "{flv: '$video_url'}";
						$supplied = 'supplied: "flv",';
						break;
				}
				
				wp_enqueue_script('jplayer');
				$iterator = $post_id;
			$html = <<<HTML
					<!--<link type="text/css" href="http://www.jplayer.org/latest/skin/blue.monday/jplayer.blue.monday.css" rel="stylesheet" />-->
				  <script type="text/javascript">
					jQuery(document).ready(function(){
					  galleryVideo.addVideoID('jplayer', '#jquery_jplayer_{$iterator}');
					  jQuery("#jquery_jplayer_{$iterator}").jPlayer({
						ready: function () {
						 jQuery(this).jPlayer("setMedia", {$media});
						 jQuery('#jquery_jplayer_{$iterator}').bind(jQuery.jPlayer.event.play, function() { // Bind an event handler to the instance's play event.
							galleryVideo.pauseOther('#jquery_jplayer_{$iterator}');
						 });

						},
						swfPath: THEME_URI+"/swf",
						size: {width:'100%', height:'56%'},
						{$supplied}
					  });
					});
				  </script>
				  <div id="jp_container_{$iterator}" class="jp-video jp-video-270p">
					<div class="jp-type-single">
					  <div id="jquery_jplayer_{$iterator}" class="jp-jplayer"></div>
					  <div class="jp-gui">
						<div class="jp-video-play">
						  <a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
						</div>
						<div class="jp-interface">
						  <div class="jp-progress">
							<div class="jp-seek-bar">
							  <div class="jp-play-bar"></div>
							</div>
						  </div>
						  <div class="jp-current-time"></div>
						  <div class="jp-duration"></div>
						  <div class="jp-controls-holder">
							<ul class="jp-controls">
							  <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
							  <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
							  <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
							  <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
							  <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
							  <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
							</ul>
							<div class="jp-volume-bar">
							  <div class="jp-volume-bar-value"></div>
							</div>
							<ul class="jp-toggles">
							  <li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full screen</a></li>
							  <li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen">restore screen</a></li>
							  <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
							  <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
							</ul>
						  </div>
						  <!-- <div class="jp-title">
							<ul>
							  <li>Big Buck Bunny Trailer</li>
							</ul>
						  </div> -->
						</div>
					  </div>
					  <div class="jp-no-solution">
						<span>Update Required</span>
						To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
					  </div>
					</div>
				  </div>
HTML;
			}

			if($echo)
			{
				echo $html;
			}
			else
			{
				return $html;
			}
		}
		else
		{
			return false;
		}
		
	}

	static function getYouTubeID($url)
	{
		$pattern =
			'%^# Match any youtube URL
			(?:https?://)?  # Optional scheme. Either http or https
			(?:www\.)?      # Optional www subdomain
			(?:             # Group host alternatives
			  youtu\.be/    # Either youtu.be,
			| youtube\.com  # or youtube.com
			  (?:           # Group path alternatives
				/embed/     # Either /embed/
			  | /v/         # or /v/
			  | /watch\?v=  # or /watch\?v=
			  )             # End path alternatives.
			)               # End host alternatives.
			([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
			%x';
		$result = preg_match($pattern, $url, $matches);
		if (false !== $result && isset($matches[1])) {
			return $matches[1];
		}
		return false;
	}

	static function getVimeoID($url)
	{
		$result = preg_match('/(vimeo).+\/(\d+)/', $url, $matches);
		if (false !== $result && isset($matches[2])) {
			return $matches[2];
		}
		return false;
	}

	static function getPostAudio($post_id)
	{
		$iterator = $post_id;
		wp_enqueue_script('jplayer');

		$href = get_post_meta($post_id, SHORTNAME . '_post_audio_url', true);

		if (filter_var($href, FILTER_VALIDATE_URL))
		{

			switch (pathinfo($href, PATHINFO_EXTENSION))
			{
				case 'mp3':  //mp3
					$supplied_format = "mp3";
					$media = array('mp3'=>$href);
					break;
				case 'm4a':  //mp4
					$supplied_format = "m4a, mp3";
					$media = array('m4a'=>$href);
					break;
				case 'ogg': //ogg
					$supplied_format = "oga, ogg, mp3";
					$media = array('oga'=>$href);
					break;
				case 'oga': //oga
					$supplied_format = "oga, ogg, mp3";
					$media = array('oga'=>$href);
					break;
				case 'webma': //webma
					$supplied_format = "webma, mp3";
					$media = array('webma'=>$href);
					break;
				case 'webm': //webma
					$supplied_format = "webma, mp3";
					$media = array('webma'=>$href);
					break;
				case 'wav':
					$supplied_format = "wav, mp3";
					$media = array('wav'=>$href);
					break;
				default:
					// not supporteg audio format
					return;
					break;
			}
			
			$media_json = htmlspecialchars(json_encode($media));
			
			$html = <<<HTML
			<div id="jquery_jplayer_{$iterator}" class="jp-jplayer th-audio-player" data-iterator="{$iterator}" data-media="{$media_json}" data-format="{$supplied_format}"></div>
			<div id="jp_container_{$iterator}" class="jp-audio">
            <div class="jp-type-single"><div class="jp-control"><a href="javascript:;" class="jp-play" tabindex="1">play</a><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></div> <div class="jp-gui jp-interface"><div class="jp-progress"><div class="jp-seek-bar"><div class="jp-play-bar"></div></div></div><div class="jp-volume"><div class="jp-volume-bar"><div class="jp-volume-bar-value"></div></div></div>
                </div>
HTML;
			$html .= <<<HTML
                <div class="jp-no-solution"><span>Update Required</span>To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.</div></div></div>
				<script type='text/javascript'>
					jQuery(document).ready(function() {
						initAudioTrack({$iterator});
					});
				</script>
HTML;
			return $html;
		}
	}
}
?>