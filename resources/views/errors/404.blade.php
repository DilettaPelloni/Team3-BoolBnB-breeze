<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Errore 404</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <div class="flex-container">
            

            <div class="img">

                <img
                        src="{{ asset('storage/img/404.png') }}"
                        alt="img404"
                        class=""
                    />
            </div>
            <div class="text">
                <h1>OOPS...</h1>
                        <h2>La pagina che stai cercando non è disponibile su questo sito<br>oppure non hai digitato l'URL correttamente.</h2>
                        <a href="{{ route('welcome') }}"><button>Torna alla home</button></a>
        
        
                    </div>
        </div>
    
    
</div>
</body>
</html>

<style scoped>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
.pink {
    color: #fe5b5f;
}

.container {
    
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}

.flex-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    text-align: center;
}

h1, h2 {
    font-family: 'Figtree';
    padding-bottom: 28px;
}

h1 {
    font-size: 115px;
    font-weight: bolder;
    color: #fe5b5f;
}

h2 {
    color: #3a3a3a;
}

button {
    padding: 17px 20px;
    border-radius: 50px;
    border: none;
    background-color: #fe5b5f;
    color: #fff;
    font-family: 'Figtree';
    font-size: 17px;
    cursor: pointer;
    margin-top: 23px;
}

button:hover {background-color: #df5759}

button:active {
  background-color: #fc9aa1;
  box-shadow: 0 5px #dd5b5f;
  transform: translateY(4px);
}

body {
    height: 100vh;
    background-color: #fbd2d840;
    position: relative;
}
img {
    width: 565px;
}

@media (max-width: 768px) {
  .flex-container {
    flex-direction: column;
    gap: 20px;
  }
  .text {
    text-align: center;
    margin-bottom: 20px;
  }
  button {
    margin-top: 20px;
  }
  img {
    width: 100%;
    height: auto;
  }
  h1 {
    font-size: 60px;}
}
</style>

