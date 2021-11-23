<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = $message;
}
?>
<div class="alert alert-warning"  style="text-align: center;"  onclick="this.classList.add('hidden');"><?= $message ?></div>
