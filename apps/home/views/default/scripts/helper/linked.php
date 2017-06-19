<?php if($this->list):?>
    <div class="linked">
<ul>
    <?php foreach($this->list as $v): ?>

<li>
    <a href="<?php echo $v['url']; ?>" target="_blank"><?php echo $v['title']; ?></a>
</li>
     <?php endforeach;?>
</ul>
     </div>
<?php endif;?>