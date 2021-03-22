<?php
	$currFilePath = 'contests/temp/'.get7();
	if(isset($_GET['q'])){
		$currFilePath = 'contests/'.$_GET['q'];
		//create that file
		
		if(!file_exists($currFilePath.'.cpp'))file_put_contents($currFilePath.'.cpp',"#include <bits/stdc++.h>\nusing namespace std;\nint main(){\n   \n   return 0;\n}");
		
	}
	else file_put_contents($currFilePath.'.cpp',"#include <bits/stdc++.h>\nusing namespace std;\nint main(){\n   \n   return 0;\n}");
	
	function get7(){
		$ret= '';
		for($i=0;$i<7;$i++){
			$ret.=chr(rand()%26+97);
		}
		return $ret;
	}
?>
<html>
	<head>
		<link href="/cpp/plugin/codemirror/lib/codemirror.css" rel="stylesheet">
		<link href="/cpp/plugin/codemirror/theme/night.css" rel="stylesheet">
		<link rel="stylesheet" href="/cpp/plugin/codemirror/addon/fold/foldgutter.css" />
		<script src="/cpp/plugin/codemirror/lib/codemirror.js"></script>
		<script src="/cpp/plugin/codemirror/mode/clike/clike.js"></script>
		<script src="/cpp/plugin/codemirror/addon/edit/matchbrackets.js"></script>
		<script src="/cpp/plugin/codemirror/addon/edit/closebrackets.js"></script>
		<script src="/cpp/plugin/codemirror/mode/xml/xml.js"></script>
		<script src="/cpp/plugin/codemirror/addon/selection/active-line.js"></script>
		<script src="/cpp/plugin/codemirror/addon/fold/foldcode.js"></script>
		<script src="/cpp/plugin/codemirror/addon/fold/foldgutter.js"></script>
		<script src="/cpp/plugin/codemirror/addon/fold/brace-fold.js"></script>
		<script src="/cpp/plugin/codemirror/addon/fold/xml-fold.js"></script>
		<script src="/cpp/plugin/codemirror/addon/fold/indent-fold.js"></script>
		<script src="/cpp/plugin/codemirror/addon/fold/markdown-fold.js"></script>
		<script src="/cpp/plugin/codemirror/addon/fold/comment-fold.js"></script>
		<script src="/cpp/js/jquery.js"></script>
		<style>
			body{
				margin:0;
			}
			#hdr{
				height:5vh;
				background:rgba(255,0,0,0.1);
				z-index:1000;
				color:#fff;
				font-size:15px;
				line-height:5vh;
				position:fixed;
				top:0;
				left:0;
				width:100vw;
				font-family:Open Sans;
				padding-left:10px;
				display:flex;
			}
			#fn{
				color:#0f0;
			}
			#log{
				position:fixed;
				opacity:0.9;
				background:#05f;
				box-shadow:0px -10px 20px #000;
				bottom:0;
				left:0;
				width:100vw;
				z-index:100000;
				display:none;
				font-family:Lucida Console;
			}
			#head{
				color:#fff;
				background:rgba(0,0,0,.1);
				font-size:20px;
				box-sizing:border-box;
				padding:20px;
				border-bottom:1px solid rgba(255,255,255,.3);
			}
			#text{
				color:#fff;
				background:rgba(0,0,0,0.3);
				font-size:15px;
				box-sizing:border-box;
				padding:20px;
				max-height:35vh;
				overflow:auto;
				max-width:100vw;
			}
			.close{
				position:absolute;
				top:10px;
				right:20px;
				font-weight:600;
				color:#fff;
				font-size:20px;
				cursor:pointer;
			}
			#success{
				display:flex;
			}
			#ip,#op{
				flex:1;
				border-right:1px solid rgba(0,0,0,.3);
				margin-right:20px;
				max-width:50vw;
				max-height:27vh;
				overflow:auto;
				white-space: pre-wrap;       /* Since CSS 2.1 */
				white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
				white-space: -pre-wrap;      /* Opera 4-6 */
				white-space: -o-pre-wrap;    /* Opera 7 */
				word-wrap: break-word;       /* Internet Explorer 5.5+ */
			}
			#ip::before, #op::before{
				font-family:Cambria;
				display:block;	
				font-weight:600;
			}
			#ip::before{
				content:'INPUT';
			}
			#op::before{
				content:'OUTPUT';
			}
			#settings{
				height:100vh;
				overflow:auto;
				width:30vw;
				opacity:0.8;
				position:fixed;
				overflow:auto;
				right:-30vw;
				top:0;
				background:rgba(0,0,0,0.5);
				border-left:1px solid #fff;
				z-index:1000;
				box-sizing:border-box;
				padding:10px;
				transition:all .1s linear;
				display:flex;
				flex-direction:column;
			}
			#custom_input{
				border:none;
				width:100%;
				height:200px;
				background:transparent;
				color:#fff;
				font-family:Open Sans;
				font-weight:600;
				resize:none;
				border-bottom:1px solid rgba(255,255,255,.1);
				flex:1;
			}
			#toggci{
				color:#0f0;
				font-family:Lucida Console;
				cursor:pointer;
			}
			#status{
				flex:1;
			}
			#toolbox{
				padding-right:30px;
				font-size:30px;
			}
			#details{
				color:#fff;
				width:100%;
				font-size:15px;
				font-family:Open Sans;
			}
			caption{
				margin:10px;
			}
			td{
				text-align:center;
				padding:10px;
			}
			#err{
				color:#777;
				font-size:11px;
				padding-left:20px;
			}
		</style>
	</head>
	<body>
		<div id="hdr">
			<div id="status">EDITING <span id="fn"><?php echo $currFilePath; ?></span><span id="err"></span></div>
			<div id="toolbox">
				<div id="toggci" onclick="openCI()">&ltlarr;</div>
			</div>
		</div>
		<textarea id="fullarea"><?php echo file_get_contents($currFilePath.'.cpp');?></textarea>
		<div id="log">
			<div id="head">Successfully Executed</div> 
			<div id="text">
				<div id="success">
					<pre id="ip">1<br></pre>
					<pre id="op">2 4<br>5 6</pre>
				</div>
			</div>
			<div class="close" onclick="closelog()">&#10539;</div>
		</div>
		<div id="settings">
			<div class="close" onclick="closeCI()">&#10539;</div>
			<textarea id="custom_input" oninput="updInput();" placeholder="Custom Input"></textarea>
			<table id="details">
				<caption>Solution Details</caption>
				<tr>
					<td>Problem Link</td>
					<td><input id="link" value=""></td>
				</tr>
				<tr>
					<td>Difficulty</td>
					<td><input id="diff" value=""></td>
				</tr>
				<tr>
					<td>Solution Status</td>
					<td><input id="sst" value=""></td>
				</tr>
			</table>
		</div>
		<script>
			<?php echo 'var path = \''.$currFilePath.'\';'; ?>
			var editor;
			var input="";
			window.onload=function(){
				document.getElementById('custom_input').value = localStorage.getItem(path+'_ci');
				input = localStorage.getItem(path+'_ci');
				document.getElementById('link').value = localStorage.getItem(path+'_link');
				document.getElementById('diff').value = localStorage.getItem(path+'_diff');
				document.getElementById('sst').value =  localStorage.getItem(path+'_sst' );
				document.getElementById('link').oninput=function(){
					localStorage.setItem(path+'_link' , this.value);
				}
				document.getElementById('diff').oninput=function(){
					localStorage.setItem(path+'_diff' , this.value);
				}
				document.getElementById('sst').oninput=function(){
					localStorage.setItem(path+'_sst' , this.value);
				}
				document.onkeydown = function(e){
					if(e.keyCode==120)compile();
				};
				editor = CodeMirror.fromTextArea(document.getElementById('fullarea'),
				{
					lineNumbers:true,
					matchBrackets:true,
					autoCloseBrackets:true,
					mode: "text/x-c++src",
					theme: "night",
					styleActiveLine: true,
					indentUnit:3,
					extraKeys: {
						"Tab": function(cm){
							cm.replaceSelection("   " , "end");
						}
					},
					foldGutter: true,
					gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
				});
				editor.on("change",function(){
					save();
				});
			};
			function compile(){
				save();
				$('#head').html('Compiling...');
				$('#text').html('');
				$('#log').css({'display':'block'});
				$.ajax({
					url: "/cpp/compile.php",
					type: "post",
					data: {path:path},
					success: function (response) {
						if(response == ''){
							run();
						} else {
							$('#head').html('Compile Error');
							$('#text').html('<pre>'+response+'</pre>');
							$('#log').css({'display':'block'});
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
					   $('#err').html(textStatus + errorThrown);
					}
				});
			}
			function save(){
				$.ajax({
					url: "/cpp/save.php",
					type: "post",
					data: {path:path, code:editor.getValue()},
					success: function (response) {
						$('#err').html(response);
					},
					error: function(jqXHR, textStatus, errorThrown) {
					   $('#err').html(textStatus + errorThrown);
					}
				});
			}
			function run(){
				$('#head').html('Running...');
				$('#text').html('');
				$('#log').css({'display':'block'});
				$.ajax({
					url: "/cpp/run.php",
					type: "post",
					data: {path:path,input:input},
					timeout:10000,
					success: function (response) {
						$('#head').html('Successfully Executed');
						$('#text').html('<div id="success"><pre id="ip">'+((input=='')?'No Input':input)+'</pre><pre id="op">'+response+'</pre></div>');
						$('#log').css({'display':'block'});
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$('#head').html(textStatus);
						$('#text').html('took more than 5 second');
						$('#log').css({'display':'block'});
					}
				});
			}
			function closelog(){
				$('#log').css({'display':'none'});
			}
			function openCI(){
				$('#toggci').css({'display':'none'});
				$('#settings').css({'right':'0'});
			}
			function closeCI(){
				$('#toggci').css({'display':'block'});
				$('#settings').css({'right':'-30vw'});
			}
			function updInput(){
				input = document.getElementById('custom_input').value;
				localStorage.setItem(path+'_ci' , input);
			}
		</script>
	</body>
</html>
<!--
RUNTIME ERRORS
Compilation LOG
-->