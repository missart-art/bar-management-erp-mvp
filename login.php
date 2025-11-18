

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <style>

        body {
  font-family: "Gill Sans Extrabold", Helvetica, sans-serif;
  background-image: linear-gradient(45deg, rgb(136, 52, 185), rgb(5, 5, 124));
}
        div{
            background-color: rgba(0, 0, 0, 0.35);   
            position: absolute;
            top: 50%;
            left:50%;
            transform: translate(-50%, -50%);
            padding: 35px;
            border-radius: 13px;
            color: white;
            outline: none;
        }
        input{
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 15px;

        }

        input[type=submit]{
            background-color: rgb(49, 152, 184);
            border: none;
            padding: 8px;
            width: 100%;
            border-radius: 10px;
            color: white;
            font-size: 16px;
           }
           input[type=submit]:hover{
            background-color: rgb(45, 37, 148);
            cursor: pointer;
           }
        
           .erro {
        color: red;
        outline: none;
        background-color: rgba(0, 0, 0, 0.35);
        position:absolute;
        top: 100%;
        left: -3%;
        font-size: 15px;
        border-radius: 13px;
        padding: 6px;
        width: 100%;

        

        
    }
        
    </style>
</head>
<body>
    <div>
        <h1>Login</h1>
        <form method="POST" action="logar.php">
            <input type="text" name="login" placeholder="Login">
            <br><br>
            <input type="password" name="senha" placeholder="Senha">
            <br><br>
            <input type="submit" name="acao" value="Entrar">
        </form>
        </div>
    
    
</body>
    
</html>
