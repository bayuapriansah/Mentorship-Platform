  {{-- @php
  $data = [
      'subject' => 'New Email',
      'body' => 'sip@nmail.com',
      'first_name' => 'Farhan',
      'last_name' => 'Jon',
      'email' => 'faarhan@mail.com',
      'message'=> 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dignissimos atque suscipit amet non consectetur? Nam, a laborum? Accusamus similique beatae id distinctio cumque odit, ipsa nemo molestiae, libero, ratione consectetur?',
      'phone'=> '0822672362',
      'type' => 'contactUs',
  ];    
  @endphp --}}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="font-family: 'IntelOne Display', arial, 'helvetica neue', helvetica, sans-serif">
 <head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta name="x-apple-disable-message-reformatting">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="telephone=no" name="format-detection">
 </head>
 <body style="width:100%;font-family: 'IntelOne Display', arial, 'helvetica neue', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
  <table >
    <tr>
      <td colspan="4">Name: {{$data['first_name']}} {{$data['last_name']}}</td>
    </tr>
    <tr>
      <td colspan="2">Email: {{$data['email']}}</td>
      <td colspan="2">Phone: {{$data['phone']}}</td>
    </tr>
    <tr>
      <td colspan="4">
        {{$data['message']}}
      </td>
    </tr>
  </table>
 </body>
</html>
