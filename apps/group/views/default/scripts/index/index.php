<?php echo $this->groupnav();?>
<div class="grow group-list-page">
        <div class="main gspan-21">
            <ul class="gtabs gclear">
           <?php if(!$this->t):?>
              	<li class="gtabs-curr" >
                    	全部
                </li>
            <?php else:?>
            	 <li>
                    	<a href="<?php echo $this->url("index/index");?>">全部</a>
                </li>
            <?php endif;?>
            <?php if($this->treeList):?>
            <?php foreach ($this->treeList as $v):?>
            <?php if($this->t == $v['id']):?>
                <li class="gtabs-curr" >
                    	<?php echo $v['name'];?>
                </li> 
              <?php else:?>
              <li>
                    <a href="<?php echo $this->url("index/index/t/".$v['id']);?>"><?php echo $v['name'];?></a>
                </li>
             <?php endif;?>
             <?php endforeach;?>
             <?php endif;?>   
                
            </ul>
            <ul class="group-list gpack">
           <?php if($this->list):?>
           <?php foreach ($this->list as $v):?>     
                <li>
                    <div class="group-list-options">
<a target="_blank" href="<?php echo $this->url("/index/g/id/".$v['id'], "group");?>">
<img src="<?php echo My_Tool::getFace($v['face'], 48); ?>" class="group-icon" width="48" height="48">
</a>
<?php if($this->uid !=$v['uid']):?>
<span id="groupjoin_<?php echo $v['id'];?>">
<?php if($v['hasJoin']):?> 
<a href="javascript:void 0; " id="canceljoinBt" onclick="quite(<?php echo $v['id'];?>);";>退出</a>
<?php else:?>
<a href="javascript:void 0; " class="gbtn-join-gray joinBt" id="joinBt" onclick="join(<?php echo $v['id'];?>);"; >加入</a>
<?php endif;?>
</span>
<?php endif; ?>
                    </div>
                    <div class="group-list-desc">
                        <p>
                            <a target="_blank" href="<?php echo $this->url("/index/g/id/".$v['id'], "group");?>"><?php echo $v['name']; ?></a>
                            <span><span id="num_<?php echo $v['id'];?>"><?php echo $v['user_number'];?></span>人加入</span>
                        </p>
                        <p><?php echo $v['descr'];?></p>
                    </div>
                </li>
            <?php endforeach;?>
            <?php endif;?>
            </ul>
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum);?> 
        </div>
        <div class="side gspan-10 gprefix-1">
            <form id="groupSearch" action="<?php echo $this->url("index/group/","search");?>" class="gsearch" method="get">
                <p>
                <input id="word" type="text" class="gsearch-txt" name="wd" maxlength="10" placeholder="搜索小组" value=""/>
                <input type="submit" value="搜索" class="gsearch-bt gicon-search" />
                </p>
            </form>
            <div class="side-title">
                
                <h2>近期热门小组</h2>
                
            </div>
            <div id="hotGroups">
                <ul class="side-groups ">
                 <?php 
                	if($this->hot):
                ?>
                <?php 
                	foreach($this->hot as $v):
                ?>
                    <li>
                        <a class="pt-pic" href="<?php echo $this->url("/index/g/id/".$v['id'], "group");?>" title="<?php echo $v['name'];?>" target="_blank">
 <img width="48" height="48" src="<?php echo My_Tool::getFace($v['face'], 48); ?>" alt="<?php echo $v['name'];?>" hoverboxadded="true">
                        </a>
                        <div class="pt-txt">
                            <h3><a href="<?php echo $this->url("/index/g/id/".$v['id'], "group");?>" target="_blank"><?php echo $v['name'];?></a></h3>
                            <span><?php echo $v['user_number'];?>人加入</span>
                            <div class="pt-txt-d">
                                <p class="gellipsis"><?php echo $v['descr'];?></p>
                            </div>
                        </div>
                    </li>
                    <?php endforeach;?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="side-title">
                
                <h2>新创建的小组</h2>
            </div>
            <div id="newGroups">
                
                <ul class="side-groups ">
                 <?php 
                	if($this->new):
                ?>
                <?php 
                	foreach($this->new as $v):
                ?>
                    <li>
                        <a class="pt-pic" href="<?php echo $this->url("/index/g/id/".$v['id'], "group");?>" title="<?php echo $v['name'];?>" target="_blank">
                        <img width="48" height="48" src="<?php echo My_Tool::getFace($v['face'], 48); ?>" alt="<?php echo $v['name'];?>" hoverboxadded="true"></a>
                        <div class="pt-txt">
                            <h3><a href="<?php echo $this->url("/index/g/id/".$v['id'], "group");?>" target="_blank"><?php echo $v['name'];?></a></h3>
                            <span><?php echo $v['user_number'];?>人加入</span>
                            <div class="pt-txt-d">
                                <p class="gellipsis"><?php echo $v['descr'];?></p>
                            </div>
                        </div>
                    </li>
                 <?php endforeach;?>
                  <?php endif; ?>  
                </ul>
                
            </div>

        </div>
    </div>
    <script>
	function join(id){
            ajax_get("<?php echo $this->url("index/join/id/");?>"+id,function(a){
						if(a.code ==500){
							falert(a.msg);
						}
						else if(a.code ==100){
							var message = "<textarea id=\"reason\" style=\"width:300px;height:50px;\"></textarea>";
							var btnFn = function(){
								var reason = $.trim($("#reason").val());
								if(!reason){
									falert('申请资料不能为空!');
								}
								ajax_post("<?php echo $this->url("index/privatejoin");?>",{id:id,reason:reason},
											function(a){
												if(a.code != 200){
													falert(a.msg);
												}else{
													dclose();
													falert(a.msg);
												}
											}
										);
								return false;
							};
							easyDialog.open({
								  container : {
								    header : a.msg,
								    content : message,
								    yesFn : btnFn,
								    noFn : true
								  }
								});  
						}
						else{
							var str = "<a href=\"javascript:void 0; \" onclick=\"quite("+id+")\" id=\"canceljoinBt\" >退出</a>";
							$("#groupjoin_"+id).html(str);
							var num = parseInt($("#num_"+id).text());
							$("#num_"+id).html(num+1);
						}
             });
    }

       function quite(id){
           ajax_get("<?php echo $this->url("index/quite/id/");?>"+id,function(a){
				if(a.code !=200){
					falert(a.msg);
				}else{
					var str = "<a href=\"javascript:void 0; \" class=\"gbtn-join-gray joinBt\"  onclick=\"join("+id+")\"  id=\"joinBt\">加入</a>";
					$("#groupjoin_"+id).html(str);
					var num = parseInt($("#num_"+id).text());
					$("#num_"+id).html(num-1);
				}
   			});
		}
    </script>