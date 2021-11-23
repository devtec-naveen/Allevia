<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-danger"  style="text-align: center;"  onclick="this.classList.add('hidden');"><?= $message ?></div>
