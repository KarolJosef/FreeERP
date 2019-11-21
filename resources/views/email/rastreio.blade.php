<html>
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