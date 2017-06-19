<?php
class My_Tool_Tpl{
	private $tpl_base_dir="";
	private $charset = "utf-8";
	//模板扩展函数
	function template_ext($template)
	{
		$tpl_base_dir = $this->tpl_base_dir; //定义基本模板目录，结尾自带了斜杠
		//php标签
		/*
		{php echo phpinfo();} => <?php echo phpinfo(); ?>
		*/
		$template = preg_replace ( "/\{php\s+(.+)\}/", "<?php \\1?>", $template );
		
		//if 标签
		/*
		{if $name==1} => <?php if ($name==1){ ?>
		{elseif $name==2} => <?php } elseif ($name==2){ ?>
		{else} => <?php } else { ?>
		{/if} => <?php } ?>
		*/
		$template = preg_replace ( "/\{if\s+(.+?)\}/", "<?php if(\\1) { ?>", $template );
		$template = preg_replace ( "/\{else\}/", "<?php } else { ?>", $template );
		$template = preg_replace ( "/\{elseif\s+(.+?)\}/", "<?php } elseif (\\1) { ?>", $template );
		$template = preg_replace ( "/\{\/if\}/", "<?php } ?>", $template );
		
		
		//for 标签
		/*
		{for $i=0;$i<10;$i++} => <?php for($i=0;$i<10;$i++) { ?>
		{/for} => <?php } ?>
		*/
		$template = preg_replace("/\{for\s+(.+?)\}/","<?php for(\\1) { ?>",$template);
		$template = preg_replace("/\{\/for\}/","<?php } ?>",$template);
		
		//loop 标签
		/*
		{loop $arr $vo} => <?php $n=1; if (is_array($arr) foreach($arr as $vo){ ?>
		{loop $arr $key $vo} => <?php $n=1; if (is_array($array) foreach($arr as $key => $vo){ ?>
		{/loop} => <?php $n++;}unset($n) ?>
		*/
		$template = preg_replace ( "/\{loop\s+(\S+)\s+(\S+)\}/", "<?php \$n=1;if(is_array(\\1)) foreach(\\1 AS \\2) { ?>", $template );
		$template = preg_replace ( "/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}/", "<?php \$n=1; if(is_array(\\1)) foreach(\\1 AS \\2 => \\3) { ?>", $template );
		$template = preg_replace ( "/\{\/loop\}/", "<?php \$n++;}unset(\$n); ?>", $template );
		
		//函数 标签
		/*
		{date('Y-m-d H:i:s')} => <?php echo date('Y-m-d H:i:s');?> 
		{$date('Y-m-d H:i:s')} => <?php echo $date('Y-m-d H:i:s');?> 
		*/
		$template = preg_replace ( "/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/", "<?php echo \\1;?>", $template );
		$template = preg_replace ( "/\{(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/", "<?php echo \\1;?>", $template );
		
		//变量/常量 标签
		/*
		{$name} => <?php echo $name; ?>
		{CONSTANCE} => <?php echo CONSTANCE;?>
		*/
		/*$template = preg_replace ( "/\{(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/", "<?php echo \\1;?>", $template );*/
		/*$template = preg_replace("/\{(\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\}/es", "\$this->addquote('<?php echo \\1;?>')",$template);*/
		$template = preg_replace ( "/\{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", "<?php echo \\1;?>", $template );
		
		
		/* 修正css路径 */
		$template = preg_replace('/(<link\shref=["|\'])(?:\.\/|\.\.\/)?(css\/)?([a-z0-9A-Z_]+\.css["|\']\srel=["|\']stylesheet["|\']\stype=["|\']text\/css["|\'])/i','\1' . $tpl_base_dir . '\2\3', $template);
		
		/* 修正js目录下js的路径 */
		$template = preg_replace('/(<script\s(?:type|language)=["|\']text\/javascript["|\']\ssrc=["|\'])(?:\.\/|\.\.\/)?(js\/[a-z0-9A-Z_\-\.]+\.(?:js|vbs)["|\']><\/script>)/', '\1' . $tpl_base_dir . '\2', $template);
		
		/* 更换编译模板的编码类型 */
		$template = preg_replace('/<meta\shttp-equiv=["|\']Content-Type["|\']\scontent=["|\']text\/html;\scharset=(?:.*?)["|\'][^>]*?>\r?\n?/i', '<meta http-equiv="Content-Type" content="text/html; charset=' . $this->charset . '" />' . "\n", $template);
		
		
		$pattern = array(
		'/<!--[^<|>|{|\n]*?-->/', // 替换不换行的html注释
		'/(href=["|\'])\.\.\/(.*?)(["|\'])/i', // 替换相对链接
		'/((?:background|src)\s*=\s*["|\'])(?:\.\/|\.\.\/)?(images\/.*?["|\'])/is', // 在images前加上 $tmp_dir
		'/((?:background|background-image):\s*?url\()(?:\.\/|\.\.\/)?(images\/)/is', // 在images前加上 $tmp_dir
		'/([\'|"])\.\.\//is', // 以../开头的路径全部修正为空
		);
		$replace = array(
		'',
		'\1\2\3',
		'\1' . $tpl_base_dir . '\2',
		'\1' . $tpl_base_dir . '\2',
		'\1'
		);
		$template = preg_replace($pattern, $replace, $template);
		
		return $template;
	}
}