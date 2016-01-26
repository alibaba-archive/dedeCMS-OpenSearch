<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <title>Aliyun opensearch options</title>
    <link href='img/base.css' rel='stylesheet' type='text/css'/>
    <style type="text/css">
        th, td {
            text-align: left;
            border: 1px #D1DDAA solid;
            font-size: 15px;
        }

        th {
            background: #E6F8B7;
        }

        table {
            margin-top: 20px;
        }

        .btn {
            text-decoration: none;;
        }
    </style>
</head>
<body>
<table width='80%' border='0' cellspacing='0' cellpadding='0'>
    <tr>
        <td height='30'>Access Key：</td>
        <td align="left"><?php echo $options->accesskey ?> </td>
    </tr>
    <tr>
        <td height='30'>Secret：</td>
        <td align="left"><?php echo $options->secret ?> </td>
    </tr>
    <tr>
        <td height='30'>Host:</td>
        <td align="left"><?php echo $options->host ?></td>
    </tr>
    <tr>
        <td height='30'>AppName:</td>
        <td align="left"><?php echo $options->appname ?></td>
    </tr>
    <tr>
        <td>Actions：</td>
        <td>
            <button><a class="btn" href="options.php?action=delete">Remove</a></button>
            <button><a class="btn" href="options.php?action=edit">Edit</a></button>
        </td>
    </tr>
</table>

</body>
</html>