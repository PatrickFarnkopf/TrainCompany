<? if(!defined('INC')) exit; ?>
<span class="<?= $vars['delayTime']->toInt() >= 300 ? 'Red' : 'Green' ?>">+<?= $vars['delayTime'] ?></span>