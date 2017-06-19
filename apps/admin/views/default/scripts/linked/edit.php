<?php
echo $this->cplace("编辑链接");
?>
<div class="tab-box">
    <ul id="nav_tabs">
        <li><a href="<?php echo $this->url("linked/index");?>" >列表</a></li>
    </ul>
</div>
<div style="clear: both"></div>
<form name="add-tree"  enctype="multipart/form-data"  method="post" action="<?php echo My_Tool::url("/linked/edit")?>" >
    <table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
        <caption>编辑链接</caption>
        <tr>
            <th colspan="2" class="th1">名称:</th>
        </tr>

        <tr>
            <td class="tablerow1 formrow">
                <input type="text" name="title" value="<?php echo $this->title ? $this->title:$this->info['title']; ?>" >
            </td>
            <td class="tablerow1 tips">友情链接名字</td>
        </tr>
        <tr>
            <th colspan="2" class="th1">链接地址:</th>
        </tr>
        <tr>
            <td class="tablerow1 formrow">
                <input type="text" name="url" value="<?php echo $this->url ? $this->url:$this->info['url'];?>" >
            </td>
            <td class="tablerow1 tips"></td>
        </tr>

        <tr>
            <th colspan="2" class="th2">顺序:</th>
        </tr>

        <tr>
            <td class="tablerow2 formrow">
                <input type="text" name="fsort" value="<?php echo $this->fsort ? $this->fsort:$this->info['fsort']; ?>" >
            </td>
            <td class="tablerow2 tips">数字越小越靠前</td>
        </tr>
        <tr>
            <td colspan="2" class="tablerow2">
                <input name="id" type="hidden" value="<?php echo $this->id; ?>">
                <button class="btnsubmit" type="submit" name="btnsubmit" value="yes">提 交</button>
            </td>
        </tr>
    </table>
</form>