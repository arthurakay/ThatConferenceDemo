<?php
    $buildNo = time();
?>
<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ThatConference Demo App</title>
    <link rel="stylesheet" type="text/css" href="sencha-touch/resources/css/sencha-touch.css?build=<?php echo $buildNo; ?>"/>
    <script type="text/javascript" src="sencha-touch/sencha-touch-all.js?build=<?php echo $buildNo; ?>"></script>
    <script type="text/javascript" src="app-all.js?build=<?php echo $buildNo; ?>"></script>
    <script type="text/javascript">
        if (!Ext.browser.is.WebKit) {
            alert("The current browser is unsupported.\n\nSupported browsers:\n" +
                  "Google Chrome\n" +
                  "Apple Safari\n" +
                  "Mobile Safari (iOS)\n" +
                  "Android Browser\n" +
                  "BlackBerry Browser"
            );
        }
    </script>

</head>
<body>

</body>
</html>