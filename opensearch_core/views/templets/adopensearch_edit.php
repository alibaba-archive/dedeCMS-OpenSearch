<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <title>Aliyun opensearch options</title>
    <link href='img/base.css' rel='stylesheet' type='text/css'/>
    <style type="text/css">
        th, td {
            text-align: center;
            border: 1px #D1DDAA solid;
            font-size: 15px;
        }

        th {
            background: #E6F8B7;
        }

        table {
            margin-top: 20px;
        }

        .floatleft {
            float: left;
        }

        .optionitem {
            width: 300px !important;;
        }
    </style>
</head>
<body>

<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle"
       style="background:#CFCFCF;">
    <form method="post" action="options.php">
        <tr>
            <td width="19%" align="center" bgcolor="#FFFFFF"><b>Access Key：</b></td>
            <td width="81%" bgcolor="#FFFFFF">
                <input name="accesskey" type="text" style="width:180px" class='alltxt floatleft optionitem'
                       value="<?php echo $options->accesskey ?>"/></td>
        </tr>
        <tr>
            <td width="19%" align="center" bgcolor="#FFFFFF"><b>Secret：</b></td>
            <td width="81%" bgcolor="#FFFFFF">
                <input name="secret" type="text" style="width:180px" class='alltxt floatleft optionitem'
                       value="<?php echo $options->secret ?>"/></td>
        </tr>
        <tr>
            <td width="19%" align="center" bgcolor="#FFFFFF"><b>Host：</b></td>
            <td width="81%" bgcolor="#FFFFFF">
                <input name="host" type="text" style="width:180px" class='alltxt floatleft optionitem'
                       value="<?php echo $options->host ?>"/></td>
        </tr>
        <tr>
            <td width="19%" align="center" bgcolor="#FFFFFF"><b>AppName：</b></td>
            <td width="81%" bgcolor="#FFFFFF">
                <input name="appname" type="text" style="width:180px" class='alltxt floatleft optionitem'
                       value="<?php echo $options->appname ?>"/></td>
        </tr>
        <tr>
            <td width="19%" align="center" bgcolor="#FFFFFF">
                &nbsp;
            </td>
            <td width="19%" align="center" bgcolor="#FFFFFF">
                <input name="imageField" class="floatleft np" type="submit" value="Submit"/>
            </td>
        </tr>
    </form>
</table>
</body>
</html>