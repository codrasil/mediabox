<?php if ($sortKey === $_GET['sort']) : ?>
<?php switch ($_GET['order']): ?>
<?php case 'asc': ?>
    <a href="<?php echo url_params(['sort' => $sortKey, 'order' => 'desc']) ?>"><?php echo $label ?>&nbsp;<i class="mdi mdi-sort-ascending"></i></a>
<?php break; ?>
<?php case 'desc': ?>
    <a href="<?php echo url_params(['sort' => null, 'order' => null]) ?>"><?php echo $label ?>&nbsp;<i class="mdi mdi-sort-descending"></i></a>
<?php break; ?>
<?php endswitch; ?>
<?php else : ?>
    <a href="<?php echo url_params(['sort' => $sortKey, 'order' => 'asc']) ?>"><?php echo $label ?></a>
<?php endif; ?>
