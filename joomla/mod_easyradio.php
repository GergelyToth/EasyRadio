<?php
/**
 * EasyRadio Module
 * 
 * @package     EasyRadio
 * @subpackage  Modules
 * @link        http://gergelytoth.com/joomla/downloads/easyradio
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL General Public License version 3 or later
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

$url = JURI::base();
$document = JFactory::getDocument();

JHtml::_('jquery.framework'); // load jQuery framework to Joomla 3
$document->addScript('modules/mod_easyradio/media/js/jquery.jplayer.min.js'); // add jPlayer .js file
$document->addScript('modules/mod_easyradio/media/js/jquery.jplayer.inspector.js'); // DEBUGGING
$document->addStyleSheet('modules/mod_easyradio/media/css/' . $params->get('css') . '.css'); // add CSS

// styling
$document->addStyleDeclaration('
div.jp-audio-stream {
    color: ' . $params->get('name-color') . ';
    border: ' . $params->get('border-width') . 'px solid ' . $params->get('border-color') . ';
}

div.jp-interface {
    background: ' . $params->get('background-color') . ';
}

div.jp-type-single div.jp-title {
    background-color: ' . $params->get('name-background') . ';
}
');

// get the type of the server
$type = ''; // if the type is IceCast, don't include anything
if ( $params->get('type') == 1 ) { // if the type us ShoutCast include /;stream/1
    if ( substr( $params->get('url'), -1) == '/' ) {
        $type = ';stream/1';
    } else {
        $type = '/;stream/1';
    }
}

// format of the streaming
if ( $params->get('format') == 0 ) {
    $format = 'aac';
} else {
    $format = 'mp3';
}

$document->addScriptDeclaration('
jQuery(document).ready(function(){
    var stream = {
        title: "EasyRadio",
        ' . $format . ': "' . $params->get('url') . $type . '"
    },
    ready = false;

    jQuery("#jquery_jplayer_1").jPlayer({
        ready: function (event) {
            ready = true;
            jQuery(this).jPlayer("setMedia", stream);
        },
        pause: function() {
            jQuery(this).jPlayer("clearMedia");
        },
        error: function(event) {
            if(ready && event.jPlayer.error.type === jQuery.jPlayer.error.URL_NOT_SET) {
                // Setup the media stream again and play it.
                jQuery(this).jPlayer("setMedia", stream).jPlayer("play");
            }
        },
        swfPath: "modules/mod_easyradio/media/js",
        supplied: "mp3",
		solution: "html, flash",
        preload: "none",
        wmode: "window",
        keyEnabled: true
    });

    jQuery("#jplayer_inspector").jPlayerInspector({jPlayer:jQuery("#jquery_jplayer_1")});
});
');
?>

<div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id="jp_container_1" class="jp-audio-stream"><!-- radio width -->
    <div class="jp-type-single">
        <div class="jp-gui jp-interface">
            <ul class="jp-controls">
                <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li><!-- margin mute/unmute -->
                <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
            </ul>
            <div class="jp-volume-bar"><!-- left progressbar -->
                <div class="jp-volume-bar-value"></div>
            </div>
        </div>
       
<?php if ($params->get("show-name") == 1 ) : ?>
        <div class="jp-title">
            <ul>
              <li><?php echo $params->get('name'); ?></li>
            </ul>
        </div>
<?php endif; ?>
        <div class="jp-no-solution">
            <span>Update Required</span>
            To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin and restart your browser!</a>.
        </div>
    </div>
</div>
<?php
    if ($params->get('inspector') == 1) {
        echo '<div id="jplayer_inspector">inspector</div>';
    }
?>