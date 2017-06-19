<?php echo $this->groupnav();?>
<div class="wrap grow  gpack group-apply-page">
        <div class="gspan-22  main">
<?php echo My_Tool_Form::start("newGroup", $this->url("index/doapply","group"),"post", array("id"=>"newGroup","class"=>"gform","enctype"=>"multipart/form-data"));?>               
                <div class="gprefix-1">
                    <div class="gform-box" >
                        <span class="gform-box-left">小组类型:</span>
                        <div class="gform-box-right gclear">
                                <div class="gform-sub-left">
                                    <input checked id="public-group" name="area" type="radio" value="0">
    <label for="public-group">公开小组<div class="group-descrip">任何人都可以看见,加入。</div></label>
                                </div>
                            
                                <div class="gform-sub-left">
                                    <input id="private-group" name="area" type="radio" value="1">
    <label for="private-group">私密小组<div class="group-descrip">非成员无法查看小组及其内容。<br/>需要申请才能加入该群。</div></label>
                                </div>
                            
                        </div>
                    </div>
                    
    <div class="gform-box">
    <label for="name">小组名称:</label>
<input autofocus="" class="gbtxt" id="name" maxlength="30" name="name" placeholder="给小组起个醒目的名称吧，2到8个字以内" type="text" value="">
        </div>


<div class="gform-box">
<span class="gform-box-left">小组图标:</span>
<div class="gform-box-right" id="imgUpload">
<input type="file" id="trueFile" name="upload_file"/><br/>
<span id="uploadMsg">（支持png、jpg、gif图片格式，大小不要超过1M）</span>
</div>
</div>
                    
    
        
    <div class="gform-box">
    <label for="blackboard">小组介绍:</label>
   <textarea  onkeyup="checkLength(this, 100, 'chLeft1');"  class="gttxt" cols="48" id="blackboard" name="introduction" placeholder="介绍一下小组是干什么的，它将作为黑板报显示" rows="6"></textarea>
    <br />
    <small>文字最大长度: 100. 还剩: <span id="chLeft1"></span>.</small>

        
        </div>

    <div class="gform-box">
    <label for="reason">申请理由:</label>
<textarea   onkeyup="checkLength(this, 100, 'chLeft2');" class="gttxt" cols="48" id="reason" name="annotation" placeholder="告诉我们你创建这个小组的想法吧,不少于100字" rows="6"></textarea>
            <br />
<small>文字最大长度: 100. 还剩: <span id="chLeft2"></span>.</small>

        </div>

    <div class="gform-box">
    <label for="contact">联系QQ:</label>
            <input class="gbtxt" id="contact" name="contact" placeholder="请留下您的QQ号码" type="number" value="">
    <span class="tip"></span>

        </div>
      <div class="gform-rem gform-box">
        <div class="gform-box-right">
            <input id="rule" name="disclaimer" type="checkbox" value="y">
    <label for="rule">我已阅读并愿意遵守<a href="<?php echo $this->url("index/view/id/".getSysData('site.config.guidelines.id'),"group")?>" target="_blank">《社区指导原则》</a></label>

        </div>
                    </div>
                    <div>
                        <div class="gform-box-right">
                            <input type="button" class="gbtn-primary submit" value="申请">
                            <span class="tip" id="draftTip"></span>        
                        </div>
                    </div>
                </div>
<?php echo My_Tool_Form::end();?> 
        </div>
    </div>
    <script>
		$(function(){
			$(".submit").click(function(){
				var name = $.trim($("#name").val());
				if(!name){
					$("#draftTip").html("小组名称不能为空!");
					return false;
				}

				if(name.length <2 || name.length >10){
					$("#draftTip").html("小组名称必须在2到8个字以内!");
					return false;
				}

				if(!$("#trueFile").val()){
					$("#draftTip").html("小组图标需要上传");
					return false;
				}

				var introduction = $.trim($("#blackboard").val());
				if(!introduction){
					$("#draftTip").html("小组介绍不能为空!");
					return false;
				}

				var reason = $.trim($("#reason").val());
				if(!reason){
					$("#draftTip").html("申请理由不能为空!");
					return false;
				}

				var contact = $("#contact").val();
				if(!contact){
					$("#draftTip").html("QQ号码有误!");
					return false;
				}

				var reg = /^\s*[.0-9]{5,12}\s*$/;
				if(!reg.test(contact)){
					$("#draftTip").html("QQ号码格式不正确!");
					return false;
				}
				
				if($("#rule").attr("checked")==false){
					$("#draftTip").html("需要同意《社区指导原则》");
						return false;
				}

				$("#newGroup").submit();
				
			});
		});
    </script>