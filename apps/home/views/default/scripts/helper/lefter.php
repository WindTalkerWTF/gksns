 <div class="shellleft">
    <div id="dkButton"> <a class="dkbtn" href="javascript:void(0);">签到领积分</a> </div>
    <div class="col-sub">
      <div class="add-item">
        <ul>
          <li class="HoverPane"> <a href="/" class="trigger">网址导航</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <script>
  	$(function(){
		//签到
		$(".dkbtn").click(function(){
			$.post("/user/index/sign",{},function(a){
				alert(a.msg);
				if(a.code == 0) location.reload();
			},"json");
		})
  	 });
  </script>