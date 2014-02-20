<?php
// no direct access
defined('_JEXEC') or die;

$url = JURI::base();
$document = JFactory::getDocument();

JHtml::_('jquery.framework'); // load jQuery framework to Joomla 3
$document->addScript('modules/mod_easyradio/js/jquery.jplayer.min.js'); // add jPlayer .js file
$document->addScript('modules/mod_easyradio/add-on/jquery.jplayer.inspector.js'); // DEBUGGING
$document->addStyleSheet('modules/mod_easyradio/skins/blue/blue.css'); // add CSS

$document->addScriptDeclaration('
jQuery(document).ready(function(){
    var stream = {
        title: "ABC Jazz",
        mp3: "http://listen.radionomy.com/abc-jazz"
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
        swfPath: "js/",
        supplied: "mp3",
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
        <div class="jp-title">
            <ul>
              <li>Bubble</li>
            </ul>
        </div>
        <div class="jp-no-solution">
            <span>Update Required</span>
            To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
        </div>
    </div>
</div>
<div id="jplayer_inspector">inspector</div>