<html>
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

{if isset($result)}
<script>
var allClients = [];
{foreach from=$result item=client}
allClients.push({$client.id});
{/foreach}

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
{foreach from=$result item=client}
    <li>
      {$client.id} {$client.added} {$client.first_name} {$client.last_name} {$client.phone}
      <select id="client_{$client.id}" name="status">
        {if $client.status == 'new'}<option value="" selected="selected">Choose</option>{/if}
        <option value="registered" {if $client.status == 'registered'}selected="selected"{/if}>registered</option>
        <option value="unavailable" {if $client.status == 'unavailable'}selected="selected"{/if}>unavailable</option>
        <option value="rejected" {if $client.status == 'rejected'}selected="selected"{/if}>rejected</option>
      </select>
    </li>
{/foreach}
</ul>
{/if}

</body>
</html>

