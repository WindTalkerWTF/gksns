<div class="mainWrap1">
    <div class="tab">
                    <ul>
                        <li>
                        <a href="/msg/index/index/t/0"><span><em>未读消息</em></span></a>
                        </li>
                        <li>
                        <a href="/msg/index/index/t/1"><span><em>已读消息</em></span></a>
                        </li>
                        <li>
                        <a href="/msg/index/index/t/2"><span><em>系统消息</em></span></a>
                        </li>
                         <li class="active" >
                        <span><em>已发送消息</em></span>
                        </li>
                        <li>
                           <a href="/msg/index/add" class="pa">发送消息</a>
                        </li>
                    </ul>
                </div>
                <div class="tabcon">
                <?php if($this->list):?>
  					<ul>
  				<?php foreach($this->list as $v):?>
  						<li style="margin-bottom:10px;border-bottom:1px dotted #ddd;">
  						    <div style="padding-left:10px;">
  						    <input type="checkbox" name="msgchoose[]" id="msgchoose_<?php echo $v['id'];?>" value="<?php echo $v['id'];?>" > 
  						    你&nbsp;&nbsp;对<a href="#"><?php echo $v['getuser']['nickname'];?></a>说:
  						    <a href="<?php echo $this->url("index/view/id/".$v['id']."/t/3","msg") ?>" target="_blank"><?php echo strip_tags($this->htmlcut($v['content'], 60));?></a>
  						    <span style="float:right;padding-right:10px;"><?php echo My_Tool::qtime($v['created_time'])?></span>
  						    </div>
  						</li>
  			   <?php endforeach;?>
  					</ul>
  			    <?php endif;?>
  			    <?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "msg");?>
                </div>
  </div>