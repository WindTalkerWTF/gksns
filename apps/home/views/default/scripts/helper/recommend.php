<?php
if($this->isMy):
?>
    <div  style="margin: 0; border: none; padding: 0; clear: both; overflow: hidden; *zoom: 1; *position: relative;">
        <div style="padding: 0; margin: 0; border: none; clear: both; display: block;">
<?php if($this->list):?>
            <div style="margin: 0; border: none; padding: 20px 0 5px; _padding-top:10px; text-indent: 0; text-align: left; font-weight: bold; ">您可能也喜欢：</div>
<?php endif;?>
<div " style="clear: both; overflow: hidden; border: none; padding: 0;margin: 0;_zoom: 1;">
<?php
    foreach($this->list as $v):
?>
<a  title="<?php echo $v['title'];?>"
 style="display: block; float: left; text-decoration: none; border-bottom-style: none; cursor: pointer; position: relative; margin: 5px 0px 0px -1px; padding: 5px; text-align: left; outline: none; background-image: none; border-left-width: 1px !important; border-left-style: solid !important; border-left-color: rgb(221, 221, 221) !important;"
href="<?php echo $this->url("index/view/id/".$v['id'],$v['urltype']);?>">
<span  style="overflow: hidden; position: relative; display: block; width: 94px; height: 94px; margin: 0 0 5px; padding: 0; border: 1px solid #DDDDDD;">
    <img
  style="position: absolute; margin: 0px; padding: 0px; border: none; background-image: none; left: 2px; top: 2px; width: 90px; height: 90px; clip: rect(0px 90px 90px 0px); visibility: visible; background-position: initial initial; background-repeat: initial initial;"
  src="<?php echo $this->img($v['face']);?>">
</span>
   <div class="wumii-image-title" style="width: 96px; height: 55px; margin: 3px 0 0 0; padding: 0; text-indent: 0; text-align: left; border: none; font: 12px/15px arial; color: #333333; overflow: hidden; white-space: normal; clear: both;"><?php echo $v['title'];?></div>
</a>
<?php endforeach;?>
</div>
    </div>
    </div>
<?php else:?>
    <script type="text/javascript" id="wumiiRelatedItems"></script>
    <script type="text/javascript">
        var wumiiPermaLink = "http://<?php echo getSysData('site.config.domain').$this->url("index/view/id/".$this->rinfo['id'],$this->urlType);?>"; //请用代码生成文章永久的链接
        var wumiiTitle = "<?php echo stripslashes($this->rinfo['title']);?>"; //请用代码生成文章标题
        var wumiiTags = ""; //请用代码生成文章标签，以英文逗号分隔，如："标签1,标签2"
        var wumiiCategories = ["<?php echo getSysData('site.config.siteName') ?>"]; //请用代码生成文章分类，分类名放在 JSONArray 中，如: ["分类1", "分类2"]
        var wumiiSitePrefix = "http://<?php echo getSysData('site.config.domain');?>/";
        var wumiiParams = "&num=6&mode=3&pf=JAVASCRIPT";
    </script>
    <script type="text/javascript" src="http://widget.wumii.cn/ext/relatedItemsWidget"></script>
    <a href="http://www.wumii.com/widget/relatedItems" style="border:0;">
        <img src="http://static.wumii.cn/images/pixel.png" alt="无觅相关文章插件，快速提升流量" style="border:0;padding:0;margin:0;" />
    </a>
<?php endif;?>