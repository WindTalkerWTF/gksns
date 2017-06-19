<?php
echo $this->cplace("友情链接管理");
?>
<div class="tab-box">
    <ul id="nav_tabs">
        <li class="active"><a href="<?php echo $this->url("linked/index");?>" >列表</a></li>
        <li><a href="<?php echo $this->url("linked/add");?>">添加</a></li>
    </ul>
</div>
<div style="clear: both"></div>
<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
    <tr class="tr-1">
        <td class="tablerow1 tablerow" width="5%" noWrap="noWrap">ID</td>
        <td class="tablerow1 tablerow" width="10%" noWrap="noWrap">链接title</td>
        <td class="tablerow1 tablerow" width="5%">排序</td>
        <td class="tablerow1 tablerow" width="50%">网址</td>
        <td class="tablerow1 tablerow">操作</td>
    </tr>
    <?php if($this->list):?>
        <?php foreach($this->list as $kv=>$v):?>
            <tr class="tr-<?php echo $kv%2==0 ? 1:2?>">
                <td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
                    <?php echo $v['id'];?>
                </td>
                <td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
                   <?php echo $v['title'];?>
                </td>
                <td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
                    <?php echo $v['fsort'];?>
                </td>
                <td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
                    <?php echo $v['url'];?>
                </td>
                <td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
                    <a href="<?php echo $this->url("linked/edit/id/" . $v['id']);?>" title="编辑" >
                        <i class="icon-pencil"></i></a>
                    <a  title="删除"
                        href="javascript:if(confirm('确认删除吗')){ location.href='<?php echo $this->url("linked/delete/id/" . $v['id']);?>';}"
                        ><i class="icon-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach;?>
    <?php endif;?>
</table>