<html>
    <head>   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>  
    <body>
        

            <table class="table table-striped">
                
                <tbody>

                  @foreach($tabela as $tr)
                    <tr>
                        <td>{{$tr[0]}}</td>                        
                        <td>{{$tr[1]}}</td>
                    </tr>
                  @endforeach
                </tbody>  
             </table> 
    </body>
</html>