<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>pacificpalmsproperty</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="" />
  <link rel="stylesheet" type="text/css" href="">
  <link rel="shortcut icon" type="image/png"  href="images/favicon.png" />
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:700&display=swap" rel="stylesheet">
</head>
<body style="margin: 0;">
    <table width="600" style="font-family: 'Roboto-Regular';margin:0 auto; " cellspacing="0">
      <tr style="height:80px;">
        <th style="text-align: center;vertical-align: middle;padding:40px; background: #348393;">
          <img src="{{ $data['base_url'] }}/public/img/email-t-logo.svg">
          <h3 style="font-size:36px; color:#fff;font-family: 'Roboto', sans-serif;margin-top: 20px;margin-bottom: 0;">pacificpalmsproperty</h3>
        </th>
      </tr>
      <tr>
      </tr>
      <tr>
        <td style="padding:20px 40px 20px 40px;">
          <p style="color:#666666;font-size:14px;font-weight: 400;margin: 0; font-family: 'Roboto', sans-serif;">Hello, {{ $data['name'] }} </p>
          <p style="color:#666666;font-size:14px;font-weight: 400;margin-bottom: 20px;margin-top: 10px; font-family: 'Roboto', sans-serif;line-height: 24px;">
            You are recently added to our system your password for your pacificpalmsproperty account.
          </p>
          <p style="color:#666666;font-size:14px;font-weight: 400;margin-bottom: 20px;margin-top: 10px; font-family: 'Roboto', sans-serif;line-height: 24px;">
            Please use this password below to login to your account.
          </p>
          <center><span style="background-color:#348393;color:ghostwhite;padding:10px;border-radius:3px;font-size: 36px">{{ $data['password'] }}</span></center>
          <p style="margin-top: 30px;font-size: 12px;color: #D9453A;font-family: 'Roboto', sans-serif; margin-bottom: 0px;">If you did not request an account, please ignore the email.</p>
          <p style="margin-top: 30px;font-size: 12px;color: #D9453A;font-family: 'Roboto', sans-serif; margin-bottom: 0px;">You are receiving this email because you have registered to be part of the pacificpalmsproperty.</p>
        </td>
      </tr>
      <tr style="height:60px;">
        <td style="background: #348393;">
          <table style="width: 100%; padding-left: 50px;padding-right: 50px;">
            <tr>
              <td style="width: 50%;" colspan="2"><img src="{{ $data['base_url'] }}/public/img/fLogo.svg"></td>
              <td colspan="2" style="font-size: 12px;color: #fff;font-family: 'Roboto', sans-serif; text-align: right;width: 50%;">Copyright &copy; <?php echo date('Y');?></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
</body>
</html>
