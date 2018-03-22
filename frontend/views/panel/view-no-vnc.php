<?php

/* @var $this yii\web\View */

$this->title = $panelName . ' - ' . Yii::$app->name;

use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use frontend\assets\NoVncAsset;
$asset = NoVncAsset::register($this);

// $this->registerMetaTag([
//   'http-equiv'=>'refresh',
//   'content' => sprintf('1; url=%s/vnc_lite.html?scale=false&resize=true&host=%s&port=%d&&password=%s&path=%s', $asset->baseUrl, $host, $port, $password, $path ),
// ])
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<!--
based on noVNC example: lightweight example using minimal UI and features
Copyright (C) 2012 Joel Martin
Copyright (C) 2017 Samuel Mannehed for Cendio AB
noVNC is licensed under the MPL 2.0 (see LICENSE.txt)
This file is licensed under the 2-Clause BSD license (see LICENSE.txt).

-->
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <!-- Apple iOS Safari settings -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
                Remove this if you use the .htaccess -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= $asset->baseUrl; ?>/app/styles/lite.css">

     <!--
    <script type='text/javascript'
        src='http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js'></script>
    -->

    <!-- promise polyfills promises for IE11 -->
    <script src="<?= $asset->baseUrl; ?>/vendor/promise.js"></script>
    <!-- ES2015/ES6 modules polyfill -->
    <script type="module">
        window._noVNC_has_module_support = true;
    </script>
    <script>
        window.addEventListener("load", function() {
            if (window._noVNC_has_module_support) return;
            var loader = document.createElement("script");
            loader.src = "<?= $asset->baseUrl; ?>/vendor/browser-es-module-loader/dist/browser-es-module-loader.js";
            document.head.appendChild(loader);
        });
    </script>

    <!-- actual script modules -->
    <script type="module" crossorigin="anonymous">
        // Load supporting scripts
        import * as WebUtil from '<?= $asset->baseUrl; ?>/app/webutil.js';
        import RFB from '<?= $asset->baseUrl; ?>/core/rfb.js';

        var rfb;
        var desktopName;

        function updateDesktopName(e) {
            desktopName = e.detail.name;
        }
        function credentials(e) {
            var html;

            var form = document.createElement('form');
            form.innerHTML = '<label></label>';
            form.innerHTML += '<input type=password size=10 id="password_input">';
            form.onsubmit = setPassword;

            // bypass status() because it sets text content
            document.getElementById('noVNC_status_bar').setAttribute("class", "noVNC_status_warn");
            document.getElementById('noVNC_status').innerHTML = '';
            document.getElementById('noVNC_status').appendChild(form);
            document.getElementById('noVNC_status').querySelector('label').textContent = 'Password Required: ';
        }
        function setPassword() {
            rfb.sendCredentials({ password: document.getElementById('password_input').value });
            return false;
        }
        function sendCtrlAltDel() {
            rfb.sendCtrlAltDel();
            return false;
        }
        function machineShutdown() {
            rfb.machineShutdown();
            return false;
        }
        function machineReboot() {
            rfb.machineReboot();
            return false;
        }
        function machineReset() {
            rfb.machineReset();
            return false;
        }
        function status(text, level) {
            switch (level) {
                case 'normal':
                case 'warn':
                case 'error':
                    break;
                default:
                    level = "warn";
            }
            document.getElementById('noVNC_status_bar').className = "noVNC_status_" + level;
            document.getElementById('noVNC_status').textContent = text;
        }

        function connected(e) {
            document.getElementById('sendCtrlAltDelButton').disabled = false;
            if (WebUtil.getConfigVar('encrypt',
                                     (window.location.protocol === "https:"))) {
                status("Connected (encrypted) to " + desktopName, "normal");
            } else {
                status("Connected (unencrypted) to " + desktopName, "normal");
            }
        }

        function disconnected(e) {
            document.getElementById('sendCtrlAltDelButton').disabled = true;
            updatePowerButtons();
            if (e.detail.clean) {
                status("Disconnected", "normal");
            } else {
                status("Something went wrong, connection is closed", "error");
            }
        }

        function updatePowerButtons() {
            var powerbuttons;
            powerbuttons = document.getElementById('noVNC_power_buttons');
            if (rfb.capabilities.power) {
                powerbuttons.className= "noVNC_shown";
            } else {
                powerbuttons.className = "noVNC_hidden";
            }
        }

        document.getElementById('sendCtrlAltDelButton').onclick = sendCtrlAltDel;
        document.getElementById('machineShutdownButton').onclick = machineShutdown;
        document.getElementById('machineRebootButton').onclick = machineReboot;
        document.getElementById('machineResetButton').onclick = machineReset;

        WebUtil.init_logging(WebUtil.getConfigVar('logging', 'warn'));
        // document.title = '<?= $panelName; ?>';
        // By default, use the host and port of server that served this file
        var host = '<?= $host; ?>';
        var port = <?= $port; ?>;

        // if port == 80 (or 443) then it won't be present and should be
        // set manually
        if (!port) {
            if (window.location.protocol.substring(0,5) == 'https') {
                port = 443;
            }
            else if (window.location.protocol.substring(0,4) == 'http') {
                port = 80;
            }
        }

        var password = '<?= $password; ?>';
        var path = '<?= $path; ?>';

        // If a token variable is passed in, set the parameter in a cookie.
        // This is used by nova-novncproxy.
        var token = WebUtil.getConfigVar('token', null);
        if (token) {
            // if token is already present in the path we should use it
            path = WebUtil.injectParamIfMissing(path, "token", token);

            WebUtil.createCookie('token', token, 1)
        }

        (function() {
            status("Connecting", "normal");

            if ((!host) || (!port)) {
                status('Must specify host and port in URL', 'error');
            }

            var url;

            if (WebUtil.getConfigVar('encrypt',
                                     (window.location.protocol === "https:"))) {
                url = 'wss';
            } else {
                url = 'ws';
            }

            url += '://' + host;
            if(port) {
                url += ':' + port;
            }
            url += '/' + path;

            rfb = new RFB(document.body, url,
                          { repeaterID: WebUtil.getConfigVar('repeaterID', ''),
                            shared: WebUtil.getConfigVar('shared', true),
                            credentials: { password: password } });
            rfb.viewOnly = WebUtil.getConfigVar('view_only', false);
            rfb.addEventListener("connect",  connected);
            rfb.addEventListener("disconnect", disconnected);
            rfb.addEventListener("capabilities", function () { updatePowerButtons(); });
            rfb.addEventListener("credentialsrequired", credentials);
            rfb.addEventListener("desktopname", updateDesktopName);
            rfb.scaleViewport = WebUtil.getConfigVar('scale', true);
            rfb.resizeSession = WebUtil.getConfigVar('resize', true);
        })();
    </script>

</head>
<body>
<?php $this->beginBody() ?>
<div id="noVNC_status_bar">
  <div id="noVNC_left_dummy_elem"></div>
  <div id="noVNC_status">Loading</div>
  <div id="noVNC_buttons">
    <input type=button value="Send CtrlAltDel"
           id="sendCtrlAltDelButton" class="noVNC_hidden">
    <span id="noVNC_power_buttons" class="noVNC_hidden">
      <input type=button value="Shutdown"
             id="machineShutdownButton">
      <input type=button value="Reboot"
             id="machineRebootButton">
      <input type=button value="Reset"
             id="machineResetButton">
    </span>
  </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
