<?php
echo $this->cplace("用户管理");
?>
<form method="post" name="frm" action="<?php echo $this->url("user/index");?>">
    <table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
        <tr class="tr-3">
            <td class="tablerow2">
                用户昵称 <input class="input" size="15" name="nickname" type="text" value="<?php echo $this->nickname?$this->nickname:""; ?>" />
                <button class="button" type="submit" name="btnsubmit" value="yes">提交</button>
            </td>
        </tr>
    </table>
</form>
<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
    <tr>
        <th width="10%" class="left" noWrap="noWrap">用户ID</th>
        <th width="10%" class="left" noWrap="noWrap">用户昵称</th>
        <th width="20%" class="left" noWrap="noWrap">用户email</th>
        <th width="10%" class="left" noWrap="noWrap">email是否认证</th>
        <th width="10%" class="left" noWrap="noWrap">角色</th>
        <th width="10%" class="left" noWrap="noWrap">状态</th>
        <th>操作</th>
    </tr>
    <?php if($this->list):?>
        <?php foreach ($this->list as $k=>$v):?>
            <tr class="tr-<?php echo $k%2==0 ? 1:2?>">
                <td class="tablerow<?php echo $k%2==0 ? 1:2?>"><?php echo $v['id'];?></td>
                <td class="tablerow<?php echo $k%2==0 ? 1:2?>"><?php echo $v['nickname'];?></td>
                <td class="tablerow<?php echo $k%2==0 ? 1:2?>"><?php echo $v['username'];?></td>
                <td class="tablerow<?php echo $k%2==0 ? 1:2?>"><?php echo $v['email_validate']?"是":"否";?></td>
                <td class="tablerow<?php echo $k%2==0 ? 1:2?>"><?php
                   if($v['role'] ==9){
                       echo "管理员";
                   }elseif($v['role']==10){
                       echo "超级管理员";
                   }else{
                       echo "普通会员";
                   }
                    ?></td>
                <td class="tablerow<?php echo $k%2==0 ? 1:2?>"><?php echo $v['is_del']?"屏蔽":"正常";?></td>
                <td class="tablerow<?php echo $k%2==0 ? 1:2?>" align="center" noWrap="noWrap">
                    <?php if($v['is_del']): ?>
                        <a href="javascript:if(confirm('确认要开启该用户吗')){ location.href='<?php echo $this->url("user/open/id/".$v['id']);?>';}"><strong>开启</strong></a>
                    <?php else:?>
                   <a href="javascript:if(confirm('确认要屏蔽吗')){ location.href='<?php echo $this->url("user/delete/id/".$v['id']);?>';}"><strong>屏蔽</strong></a>
                    <?php endif;?>
                </td>
            </tr>
        <?php endforeach;?>
    <?php endif;?>
    <tr class="tr-3">
        <td class="tablerow1" colspan="100%" align="right" id="pagecode">
            <?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "admin");?>
        </td>
    </tr>
</table>