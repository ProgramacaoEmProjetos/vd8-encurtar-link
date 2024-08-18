<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Encurtador de Links</title>
        <style>

            html, body {
                margin: 0;
                padding: 0;
                background-color: beige;
            }

            * {
                font-size: 15pt;
            }

            .container { 
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                width: 100vw;
                height: 70vh;
            }

            .description {
                text-align: center;
            }

            .shortform {
                text-align: center;
            }

            .short-btn {
                text-align: center;
                padding: 10px;
            }

            input {
                padding: 10px;
                border: none;
                border-radius: 10px;
                background-color: #c8afff;

                -webkit-box-shadow: 1px 1px 5px 0px rgba(0,0,0,0.75);
                -moz-box-shadow: 1px 1px 5px 0px rgba(0,0,0,0.75);
                box-shadow: 1px 1px 5px 0px rgba(0,0,0,0.75);
            }

            input[type=submit] {
                transform: scale(1);
                transition: transform .5s;
            }

            input[type=submit]:hover {
                transform: scale(1.1);
                transition: transform .5s;
            }

            #future-link {
                margin: 10px;
                display: none;
            }

            .error {
                color: red;
            }

            .shorted {
                color: blue;
                font-size: 20pt;
            }

        </style>
    </head>
    <body>

        <div class="container">

            <div class="description">
                <p>Encurte um link de maneira rápida!</p>
                <p>Seu link curto vai existir por um 1 mês.</p>
                <?php if(isset($_SESSION["error"])): ?>
                    <p class="error"><?php echo $_SESSION["error"]; ?></p>
                <?php endif; ?>

                <?php if(isset($_SESSION["shortlink"])): ?>
                    <p class="shorted">Seu link encurtado é: <a target="_blank" href="<?php echo $_SESSION["shortlink"]; ?>"><?php echo $_SESSION["shortlink"]; ?></a> </p>
                <?php endif; ?>
            </div>

            <form class="shortform" action="createlink.php" method="post">
                <input type="text" name="srclink" placeholder="O link para encurtar" required>
                <input type="text" name="endlink" placeholder="Final do link (Opcional)" maxlenght="50">
                <div id="future-link">
                    <span>Seu link será: http://shortlink1.test/</span><span id="link-end"></span>
                    <br><span>*Talvez ela não esteja disponível!</span>
                </div>
                <div class="short-btn">
                    <input type="submit" value="ENCURTAR">
                </div>
            </form>

        </div>

        <script>

            var codelinkInput = document.querySelector('[name="endlink"]')
            var futurelinkDiv = document.getElementById('future-link')
            var linkendDiv = document.getElementById('link-end')

            codelinkInput.oninput = function() {
                if( codelinkInput.value.length > 0 ) {
                    futurelinkDiv.style.display = 'block'
                    linkendDiv.innerText = codelinkInput.value.replaceAll(' ', '_')
                } else {
                    futurelinkDiv.style.display = 'none'
                }
            }

        </script>
        
    </body>
</html>

<?php session_unset(); ?>