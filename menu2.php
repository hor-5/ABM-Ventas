<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>menu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<style>
        nav{
        transition: 0.7s;
        border-radius: 20px;
        background-color: rgba(192, 192, 192, 0.500);       
        margin-left: 300px;
        margin-right: 300px;
        opacity: 85%;        
        
    }
    .menu img{
            
        width: 64px;
        height: 64px;         
        transition: ease 0.7s all;
     

        
    }
    .menu img:hover{
        margin-top: -50px;
        margin-bottom: 40px;
        transform: scale(2);      
                
    }

</style>

<body>
    <div class="container">

<footer>
    <div class="row menu">
        <div class="col-12">
            <nav class="navbar fixed-bottom mb-2 d-flex justify-content-center">   
                    
            
                    <a href="index.php" class="ml-3 mr-3"><img src="images/analytics2.png"  alt="analytics"></a>
                    <a href="clientes.php" class="ml-3 mr-3"><img src="images/user.png" alt="clientes" ></a>
                    <a href="productos.php" class="ml-3 mr-3"><img src="images/product.png" alt="producto" ></a>
                    <a href="ventas.php" class="ml-3 mr-3"><img src="images/sales1.png"  alt="venta"></a>
                    
            </nav>            
        </div>
    </div>
</footer>
    </div>  
    
</body>
</html>