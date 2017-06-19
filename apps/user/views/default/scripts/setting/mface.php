<div class="grow gpack gmt60 settings-profile-page">
<?php echo $this->leftsettingmenu();?>
<div class="main gspan-24 gprefix-1">
                <div class="gbtitle">
                    <h2>设置头像</h2>
                </div>
                <style>
                </style>
                <div class="gprefix-2 gmt20">
                    <form method="POST" enctype="multipart/form-data" id="mfacefrm" action="<?php echo $this->url("setting/mface", "user");?>">
                        <div class="form-div">
                            <p>
                                <input type="file" name="upload_file" id="face" accept="image/*" required="" />
                                <input type="button" id="imgSubmit" value="上传" />
                                <p id="uploadMsg" class="head-summary">
                                    （支持bmp、jpg、png、gif图片格式，大小不要超过1M）
                                </p>
                            </p>
                        </div>
                    </form>
                    <div class="gmt60 gpack">
                        <div class="main-head">
                            <div class="main-head-holder">
                                <div id="preview160" style="height:160px;width:160px;">
                                    <img src="<?php echo My_tool::getFace($this->user['face']?$this->user['face']:$this->user['id'],160);?>" id="previewBig" width="160px" height="160px">
                                </div>
                            </div>
                            <p class="head-summary center">
                                大尺寸头像，160×160像素
                            </p>
                        </div>
                        <div class="other-head">
                            <div>
                                <div id="preview48">
                                    <img src="<?php echo My_tool::getFace($this->user['face']?$this->user['face']:$this->user['id'],48);?>" id="previewMiddle" width="48" height=48>
                                </div>
                                <p class="head-summary">
                                    中尺寸头像，48x48像素
                                </p>
                            </div>
                            <div class="gmt20">
                                <div id="preview24">
                                    <img src="<?php echo My_tool::getFace($this->user['face']?$this->user['face']:$this->user['id'],24);?>" id="previewTiny" width="24" height="24">
                                </div>
                                <p class="head-summary">
                                    小尺寸头像，24x24像素
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             </div>
 <script>
 //js开始    
 $(function(){
 	$("#imgSubmit").click(function(){
 		var face = $("#face").val();
 		if(face){
 			$("#mfacefrm").submit();
 		}
 	});
 	
 });
 </script>