<html>
    <body>
        <p>Olá doidão !</p>
        <p></p>
        <p>Esse é apenas um e-mail de teste, para exemplificar o funcionamento do envio de e-mails no Laravel.</p>
        <p></p>
        <p>Att, <br>
        Carlos Ferreira!</p>

        <table class="table table-striped">
                <thead>
                    <tr>                       
                    </tr>
                </thead>
                <tbody>

                  @foreach({{$tabela}} as $tr)
                    <tr>
                        <td>{{$tr[0]}}</td>                        
                        <td>{{$tr[1]}}</td>
                    </tr>
                  @endforeach
                </tbody>  
             </table> 
    </body>
</html>