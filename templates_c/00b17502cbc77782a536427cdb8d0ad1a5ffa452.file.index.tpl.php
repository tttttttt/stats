<?php /* Smarty version Smarty-3.1-DEV, created on 2015-07-13 16:42:32
         compiled from "/home/mk/stats/templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:138270030355a3d03cdb76b6-46157592%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00b17502cbc77782a536427cdb8d0ad1a5ffa452' => 
    array (
      0 => '/home/mk/stats/templates/index.tpl',
      1 => 1436805745,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '138270030355a3d03cdb76b6-46157592',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1-DEV',
  'unifunc' => 'content_55a3d03ce18557_53247129',
  'variables' => 
  array (
    'result' => 0,
    'client' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55a3d03ce18557_53247129')) {function content_55a3d03ce18557_53247129($_smarty_tpl) {?><html>
<head>
<title>stats</title>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
</head>

<body>

<form action="/index.php" method="post">
<table border="0">
<tr>
  <td>First name:</td>
  <td><input type="text" name="first_name" value="" /></td>
</tr>
<tr>
  <td>Last name:</td>
  <td><input type="text" name="last_name" value="" /></td>
</tr>
<tr>
  <td>Phone:</td>
  <td><input type="text" name="phone" value="" /></td>
</tr>
<tr>
  <td colspan="2" align="right"><input type="submit" name="submit" value="Send" /></td>
</tr>
</table>
</form>

<?php if (isset($_smarty_tpl->tpl_vars['result']->value)){?>
<script>
var allClients = [];
<?php  $_smarty_tpl->tpl_vars['client'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['client']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['result']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['client']->key => $_smarty_tpl->tpl_vars['client']->value){
$_smarty_tpl->tpl_vars['client']->_loop = true;
?>
allClients.push(<?php echo $_smarty_tpl->tpl_vars['client']->value['id'];?>
);
<?php } ?>

$(document).ready(function() {
  for(var i = 0; i < allClients.length; ++i) {
    var id = allClients[i];
    $('#client_' + id).bind('change', function(evt) {
      var sourceId = evt.target.id;
      var value    = $('#' + sourceId + ' option:selected').val();
      var clientId = (sourceId.split('_'))[1];

      if(value) {
        var data = {};
        data['client_id']     = clientId;
        data['client_status'] = value;

        $.ajax({
          type: 'post',
          url: '/change_status.php',
          data: data,
          success: function() { window.location.reload(true); },
          error: function() { alert('Server failed. Try later.'); },
          dataType: 'json'
        });
      }
    });
  }
});
</script>

<ul>
<?php  $_smarty_tpl->tpl_vars['client'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['client']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['result']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['client']->key => $_smarty_tpl->tpl_vars['client']->value){
$_smarty_tpl->tpl_vars['client']->_loop = true;
?>
    <li>
      <?php echo $_smarty_tpl->tpl_vars['client']->value['id'];?>
 <?php echo $_smarty_tpl->tpl_vars['client']->value['added'];?>
 <?php echo $_smarty_tpl->tpl_vars['client']->value['first_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['client']->value['last_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['client']->value['phone'];?>

      <select id="client_<?php echo $_smarty_tpl->tpl_vars['client']->value['id'];?>
" name="status">
        <?php if ($_smarty_tpl->tpl_vars['client']->value['status']=='new'){?><option value="" selected="selected">Choose</option><?php }?>
        <option value="registered" <?php if ($_smarty_tpl->tpl_vars['client']->value['status']=='registered'){?>selected="selected"<?php }?>>registered</option>
        <option value="unavailable" <?php if ($_smarty_tpl->tpl_vars['client']->value['status']=='unavailable'){?>selected="selected"<?php }?>>unavailable</option>
        <option value="rejected" <?php if ($_smarty_tpl->tpl_vars['client']->value['status']=='rejected'){?>selected="selected"<?php }?>>rejected</option>
      </select>
    </li>
<?php } ?>
</ul>
<?php }?>

</body>
</html>

<?php }} ?>