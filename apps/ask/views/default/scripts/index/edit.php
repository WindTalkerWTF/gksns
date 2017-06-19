<?php 
echo $this->loadscript("js/jquerytags/jquery.tagsinput.js");
echo $this->loadscript("js/jquerytags/jquery.tagsinput.css");
echo $this->loadscript("js/jquerytags/jquery-ui-1.10.3.custom.min.js");
echo $this->loadscript("js/jquerytags/ui-lightness/jquery-ui-1.10.3.custom.min.css");
?>
<div class="grow gmt60 ask-new-page">
        <div class="main gspan-21">
            <div class="gbreadcrumb">
                <ul>
                    <li>
                        <a href="<?php echo $this->url("/index/index","ask")?>">问答</a>
                    </li>
                    <li>
                        编辑问题
                    </li>
                </ul>
            </div>
            
    <div class="">
<?php echo My_Tool_Form::start("editAsk", $this->url('index/doedit'),"post", array("id"=>"editAsk","class"=>"gform"));?>
    <label for="askTitle">问题</label>
    <?php 
		$initConfig = getInit();
		$wordCount = $initConfig['site']['title']['word']['count'];
	?>
<div class="gform-box gclear">
<textarea autofocus="" class="gttxt"   onkeyup="checkLength(this, <?php echo $wordCount; ?>, 'chLeft1');"  id="askTitle" name="question" required=""><?php echo
			$this->info['title'];?></textarea>
 <p class="lengthtip"><small>文字最大长度: <?php echo $wordCount; ?>. 还剩: <span id="chLeft1"></span></small></p>
    <span class="tip"></span> 
        </div>
            <div class="ask-desc">
                <a href="javascript:void 0;" id="descTrigger">添加补充说明</a>
 <div <?php if(!$this->content['content']):?>class="ghide"<?php endif;?>>
				<?php echo $this->keditor("annotation");?>
   <textarea id="annotation" name="annotation" style="width:99%;height:300px"><?php echo $this->content['content']; ?></textarea>
                </div>
            </div>
            <label>标签</label>
            <div class="gform-box gclear">
                <div class="editor-tags-fix">
                    <p class="post-tags tags" id="tagContent"></p>
                    <div class="hide post-autoComp_tags" style="display: block;">
<input type="text"   id="tags"  class="tags" name="tags" value="<?php echo trim($this->info['tag_name_path'],',');?>">
                        <p>给问题打上正确的标签有助于更快获得解答</p>
                        <p class="tip">最多只能添加3个标签,按回车键创建</p>
                    </div>
                </div>
            </div>

            <div class="ask-ft">
                <input id="id" name="id" type="hidden" value="<?php echo $this->id;?>">
                <input type="button" class="gbtn-submit submit" value="发布">
                 <span class="tip" id="draftTip"></span> 
            </div>
<?php echo My_Tool_Form::end();?> 
    </div>

        </div>
        
    <div class="side gspan-10 gprefix-1">
        <div class="side-summary">
            <h2>如何更快得到靠谱答案</h2>
            以下要点可以方便你更快寻求到靠谱答案：
            <ol>
                <li>
                    1.请先搜索是否已经有同类问题得到解决;
                </li>
                <li>
                    2.请在提问时精确描述你的问题，不要写与问题无关的内容，也不要用“详情请入内”之类无意义的语句；
                </li>
                <li>
                    3.提问时，@相关领域的达人，会让他们更快关注到你的问题。
                </li>
            </ol>
            <a href="<?php echo $this->url("index/view/id/6");?>">问答详细指南 &gt;</a>
        </div>
    </div>

    </div>
    <script>
    
    $(function(){
    	$('#tags').tagsInput({
    		'height':'50px', //设置高度
 		    'width':'500px',  //设置宽度
 		    'defaultText':'添加标签',
 		    'interactive':true,
 		    'removeWithBackspace':true,
 		    'minChars':1,
 		    'maxChars':20,
 		    'maxCount':3,
 		    'placeholderColor':'#f4f4f4',
  		    'autocomplete_url':'<?php echo $this->url("tag/tagssearch","ask");?>',
  		    'upperCase':true,
        	});
        
		$(".submit").click(function(){
			var askTitle = $.trim($("#askTitle").val());
			if(!askTitle){
				$("#draftTip").html("问题不能为空");
				return false;
			}

			if(askTitle.length <5 || askTitle.length ><?php echo $wordCount; ?>){
				$("#draftTip").html("问题字数必须在5到<?php echo $wordCount; ?>个字内");
				return false;
			}

			var tags = $('#tags').val();
			if(!tags){
				$("#draftTip").html("标签不能为空!");
				return false;
			}
			
			$("#editAsk").submit();
			
		});

        
    	$("#descTrigger").click(function(){
    		$(".ghide").show();
    	});
    });
    </script>