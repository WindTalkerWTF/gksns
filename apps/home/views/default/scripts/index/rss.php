<?php
$str = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
echo $str;
    ?>
<rss version="2.0">
  <channel>
    <title><?php echo getSysData('site.config.seo.home.title');?></title>
    <link>http://<?php echo getSysData('site.config.domain');?></link>
    <description><?php echo getSysData('site.config.seo.home.descr');?></description>
    <pubDate><?php echo date('Y-m-d H:i:s')?></pubDate>
    <language>zh-cn</language>
    <?php foreach ($this->list as $v):?>
    <item>
      <title><?php echo $v['title'];?></title>
      <link>http://<?php echo getSysData('site.config.domain');?><?php echo $this->url("index/view/id/".$v['id'],"site");?></link>
      <description><![CDATA[<?php if($v['face']):?><p><img src="<?php echo My_Tool::getFace($v['face'],160); ?>"  border="0"></p><?php endif; ?>
      <?php echo $v['descr'];?>]]></description>
<guid isPermaLink="true">http://<?php echo getSysData('site.config.domain');?><?php echo $this->url("index/view/id/".$v['id'],"site");?></guid>
      <pubDate><?php echo $v['created_at'];?></pubDate>
    </item>
    <?php endforeach; ?>
  </channel>
</rss>