<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="jquery,ui,easy,easyui,web">
	<meta name="description" content="easyui help you build your web page easily!">
	<title>Featured Properties</title>
	<link rel="stylesheet" type="text/css" href="easyui.css">
	<link rel="stylesheet" type="text/css" href="icon.css">
	<link rel="stylesheet" type="text/css" href="demo.css">
	<style type="text/css">
		#fm{
			margin:0;
			padding:10px 20px;
		}
		.ftitle{
			font-size:14px;
			font-weight:bold;
			color:#666;
			padding:5px 0;
			margin-bottom:10px;
			border-bottom:1px solid #ccc;
		}
		.fitem{
			margin-bottom:5px;
		}
		.fitem label{
			display:inline-block;
			width:80px;
		}
	</style>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.6.min.js"></script>
	<script type="text/javascript" src="jquery.easyui.min.js"></script>
	<script type="text/javascript">
          document.getElementById("addr").textContent='';
                var url;
		function getXMLHTTP() { //function to return the xml http object
		      var xmlhttp=false;
		      try{
		         xmlhttp=new XMLHttpRequest();
		      }
		      catch(e)   {
		         try{
		            xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		         }
		         catch(e){
		            try{
		            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		            }
		            catch(e1){
		               xmlhttp=false;
		            }
		         }
		      }

		      return xmlhttp;
		    }


function getMLS(mln)
{
   var strURL="mlscall.php?ml_num="+mln;
   var req = getXMLHTTP();
   if (req)
   {
     req.onreadystatechange = function()
     {
      if (req.readyState == 4)
      {
    // only if "OK"
    if (req.status == 200)
         {
       document.getElementById('naddr').innerHTML=req.responseText.split(":")[1];
       document.getElementById('ns_r').innerHTML=req.responseText.split(":")[0];
    } else {
       alert("There was a problem while using XMLHTTP:\n" + req.statusText);
    }
       }
      }
   req.open("GET", strURL, true);
   req.send(null);
   }
}
                function upTag(){
                        var row = $('#dg').datagrid('getSelected');
                        if (row){
                                                $.post('up_tag.php',{ml_num:row.ml_num,lorder:row.lorder},function(result){
                                                        if (result.success){
                                                                $('#dg').datagrid('reload');    // reload the tag data
                                                        } else {
                                                                $.messager.show({       // show error message
                                                                        title: 'Error',
                                                                        msg: result.msg
                                                                });
                                                        }
                                                },'json');
                        }
                 }

                function downTag(){
                        var row = $('#dg').datagrid('getSelected');
                        if (row){
                                                $.post('down_tag.php',{ml_num:row.ml_num,lorder:row.lorder},function(result){
                                                        if (result.success){
                                                                $('#dg').datagrid('reload');    // reload the tag data
                                                        } else {
                                                                $.messager.show({       // show error message
                                                                        title: 'Error',
                                                                        msg: result.msg
                                                                });
                                                        }
                                                },'json');
                        }
                 }




		function newTag(){
			$('#ndlg').dialog('open').dialog('setTitle','Enter MLS');
			$('#nfm').form('clear');
			url = 'save_tag.php';
		}
		function editTag(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Edit Property');
				$('#fm').form('load',row);
	           		document.getElementById("addr").textContent=row.addr;
				url = 'update_tag.php?ml_num='+row.ml_num;
			}
		}
		function saveTag(){
			$('#fm').form('submit',{
				url: url,
				onSubmit: function(){
					return $(this).form('validate');
				},
				success: function(result){
					var result = eval('('+result+')');
					if (result.success){
						$('#dlg').dialog('close');		// close the dialog
						$('#dg').datagrid('reload');	// reload the tag data
					} else {
						$.messager.show({
							title: 'Error',
							msg: result.msg
						});
					}
				}
			});
		}
                function saveNTag(){
                        $('#nfm').form('submit',{
                                url: url,
                                onSubmit: function(){
                                        return $(this).form('validate');
                                },
                                success: function(result){
                                        var result = eval('('+result+')');
                                        if (result.success){
                                                $('#ndlg').dialog('close');              // close the dialog
                                                $('#dg').datagrid('reload');    // reload the tag data
                                        } else {
                                                $.messager.show({
                                                        title: 'Error',
                                                        msg: result.msg
                                                });
                                        }
                                }
                        });
                }
		function removeTag(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirm','Are you sure you want to remove this tag?',function(r){
					if (r){
						$.post('remove_tag.php',{ml_num:row.ml_num},function(result){
							if (result.success){
								$('#dg').datagrid('reload');	// reload the tag data
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.msg
								});
							}
						},'json');
					}
				});
			}
		}
	</script>
</head>
<body>
	<h2>Featured List Management Portal</h2>
	<div class="demo-info" style="margin-bottom:10px">
		<div class="demo-tip icon-tip">&nbsp;</div>
		<div>Click the buttons on datagrid toolbar to do crud actions.</div>
	</div>
	
	<table id="dg" title="Featured Properties" class="easyui-datagrid" style="width:700px;height:250px"
			url="get_tags.php"
			toolbar="#toolbar" pagination="false"
			rownumbers="true" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="lorder" width="10">#</th>
				<th field="ml_num" width="10">MLS#</th>
				<th field="addr" width="50">Address</th>
				<th field="s_r" width="10">Status</th>
				<th field="disabled" width="10">Disabled</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newTag()">Add Property</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editTag()">Edit</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeTag()">Remove Property</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="upTag()">Up</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="downTag()">Down</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle">MLS#</div>
		<form id="fm" method="post" novalidate>
			<div class="fitem">
				<label>MLS# :</label>
				<input name="ml_num" onchange="getMLS(this.value)" class="easyui-validatebox" required="true">
			</div>
			<div class="fitem">
				<label>Address :</label>
				<span id="addr"> </span>
			</div>
			<div class="fitem">
				<label>Status:</label>
                                  <select name="s_r" size="1"  class="easyui-validatebox" required="true">
                                    <option value='Sale'>For Sale</option>
                                    <option value='Lease'>For Lease</option>
                                    <option value='Sold'>Sold</option>
                                    <option value='Sold Over Asking'>Sold Over Asking</option>
                                    <option value='Leased'>Leased</option>
                                 </select>
			</div>
                        <div class="fitem">
                                <label>Price Display:</label>
                                  <select name="is_price_display" size="1"  class="easyui-validatebox" required="true">
                                    <option value='N'>No</option>
                                    <option value='Y'>Yes</option>
                                 </select>

                        </div>
			<div class="fitem">
				<label valign="top" >Meassage1:<br><br></label>
				<textarea name="msg1" id="msg1" row="4" class="easyui-validatebox" ></textarea>
			</div>
			<div class="fitem">
				<label>Meassage2 :</label>
				<input name="msg2" id="msg2"  class="easyui-validatebox">
			</div>
			<div class="fitem">
				<label>Disabled:</label>
                                  <select name="disabled" size="1"  class="easyui-validatebox" required="true">
                                    <option value='N'>No</option>
                                    <option value='Y'>Yes</option>
                                 </select>

			</div>
		</form>
       </div>
       <div id="ndlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px" closed="true" buttons="#ndlg-buttons">

                <div class="ftitle">MLS#</div>

                <form id="nfm" method="post" novalidate>
                        <div class="fitem">
                                <label>MLS# :</label>
                                <input name="ml_num" onchange="getMLS(this.value)" class="easyui-validatebox" required="true">
                        </div>
                        <div class="fitem">
                                <label>Address :</label>
                                <span id="naddr"> </span>
                        </div>
                        <div class="fitem">
                                <label>Status :</label>
                                <span id="ns_r"> </span>
                        </div>
                </form>

	</div>

	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveTag()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancel</a>
	</div>
	<div id="ndlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveNTag()">Save</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#ndlg').dialog('close')">Cancel</a>
	</div>
</body>
</html>
