<html>
    <head>
        <title>captcha</title>
    </head>
    <body>
        <form action="check.php" method="post" >
            <img id="img" src="http://test.xxx.com/pictureProcess/captcha.php?r=<?php echo rand()?>" alt="" >
            <a href="#" onclick="reimg()">刷新</a>
            <br>
            <br>
            <input type="text" name="captcha">
            <br>
            <br>
            <input type="submit" value="submit">
        </form>

        <script>
            function reimg(){
                var img = document.getElementById("img");
                img.src = "captcha.php?r=" + Math.random();
            }
        </script>
    </body>
</html>
