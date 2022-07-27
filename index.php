<?php
	$folder_root = substr($_SERVER['PHP_SELF'], 0, strripos($_SERVER['PHP_SELF'], "/")+1);
	$currFilePath = 'contests/temp/'.get7();
	if(isset($_GET['q'])){
		$currFilePath = 'contests/'.$_GET['q'];
		//create that file
		$contest_name = substr($_GET['q'], 0, strripos($_GET['q'], "/"));
		if(!file_exists("contests/".$contest_name)) mkdir("contests/".$contest_name);
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
<!doctype html>
<html>
	<head>
		<link href="<?php echo $folder_root; ?>plugin/codemirror/lib/codemirror.css" rel="stylesheet">
		<link href="<?php echo $folder_root; ?>plugin/codemirror/theme/erlang-dark.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo $folder_root; ?>plugin/codemirror/addon/fold/foldgutter.css" />
		<link rel="stylesheet" href="<?php echo $folder_root; ?>css/style.css" />
	</head>
	<body>
		<div id="hdr">
			<div id="status">EDITING <span id="fn"><?php echo $currFilePath; ?></span><span id="err"></span></div>
			<div id="toolbox">
				<div id="toggci" onclick="openCI()">&ltlarr;</div>
			</div>
		</div>
		<div id="solution-container">
			<textarea id="fullarea"><?php echo file_get_contents($currFilePath.'.cpp');?></textarea>
			<div id="settings">
				<div class="close" onclick="closeCI()">&#10539;</div>
				<div id="custom_input" contenteditable="" oninput="updInput();" data-ph="Custom Input"></div>
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
		</div>
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
		

		<script src="<?php echo $folder_root; ?>plugin/codemirror/lib/codemirror.js"></script>
		<script src="<?php echo $folder_root; ?>plugin/codemirror/mode/clike/clike.js"></script>
		<script src="<?php echo $folder_root; ?>plugin/codemirror/addon/edit/matchbrackets.js"></script>
		<script src="<?php echo $folder_root; ?>plugin/codemirror/addon/edit/closebrackets.js"></script>
		<script src="<?php echo $folder_root; ?>plugin/codemirror/mode/xml/xml.js"></script>
		<script src="<?php echo $folder_root; ?>plugin/codemirror/addon/selection/active-line.js"></script>
		<script src="<?php echo $folder_root; ?>plugin/codemirror/addon/fold/foldcode.js"></script>
		<script src="<?php echo $folder_root; ?>plugin/codemirror/addon/fold/foldgutter.js"></script>
		<script src="<?php echo $folder_root; ?>plugin/codemirror/addon/fold/brace-fold.js"></script>
		<script src="<?php echo $folder_root; ?>plugin/codemirror/addon/fold/xml-fold.js"></script>
		<script src="<?php echo $folder_root; ?>plugin/codemirror/addon/fold/indent-fold.js"></script>
		<script src="<?php echo $folder_root; ?>plugin/codemirror/addon/fold/markdown-fold.js"></script>
		<script src="<?php echo $folder_root; ?>plugin/codemirror/addon/fold/comment-fold.js"></script>
		<script src="<?php echo $folder_root; ?>js/jquery.js"></script>

		
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
					console.log(e.keyCode);
					if(e.keyCode==120)compile();
				};
				editor = CodeMirror.fromTextArea(document.getElementById('fullarea'),
				{
					lineNumbers:true,
					matchBrackets:true,
					autoCloseBrackets:true,
					mode: "text/x-c++src",
					theme: "erlang-dark",
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
				var elem = editor.getWrapperElement();
				elem.id = "fullarea-cm-editor";
				console.log(editor);
			};
			function compile(){
				save();
				$('#head').html('Compiling...');
				$('#text').html('');
				$('#log').css({'display':'block'});
				$.ajax({
					url: "<?php echo $folder_root; ?>compile.php",
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
					url: "<?php echo $folder_root; ?>save.php",
					type: "post",
					data: {path:path, code:editor.getValue()},
					success: function (response) {
						$('#err').css({'color':'#777'});
						$('#err').html(response);
						setTimeout(function(){
							if(response == $('#err').html())
								$('#err').html("");
						}, 1500, response);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$('#err').css({'color':'#f00'});
					    $('#err').html(textStatus + errorThrown);
					}
				});
			}
			function run(){
				$('#head').html('Running...');
				$('#text').html('');
				$('#log').css({'display':'block'});
				$.ajax({
					url: "<?php echo $folder_root; ?>run.php",
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
				$('#settings').css({'width':'30vw', 'padding':'10px'});
			}
			function closeCI(){
				$('#toggci').css({'display':'block'});
				$('#settings').css({'width':'0', 'padding':'0'});
			}
			function updInput(){
				var el = document.getElementById('custom_input');
				input = el.innerText.trim();
				console.log(input);
				if(el.innerHTML.trim()==='<br>')el.innerHTML='';
				localStorage.setItem(path+'_ci' , input);
			}
		</script>
	</body>
</html>