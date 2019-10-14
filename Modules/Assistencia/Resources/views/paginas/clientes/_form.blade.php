<div class="form-group row">
    <div class="input-group col-12">
        <div class="input-group-prepend">
            <span class="input-group-text" id="cliente"><i class="material-icons">person</i></span>
        </div>
        <input required class="form-control" name="nome" type="text" placeholder="Nome completo"
            value="{{ isset($cliente->nome) ? $cliente->nome : old('nome', '') }}">
    </div>
    <span class="errors"> {{ $errors->first('nome') }} </span>
</div>

<div class="row">
    <div class="form-group">
        <div class="input-group col-12">
            <div class="input-group-prepend">
                <span class="input-group-text" id="cliente"><i class="material-icons">picture_in_picture</i></span>
            </div>
            <input required type="text" class="form-control cpf-mask" minlength=11 name="cpf"
                placeholder="000.000.000-00 (CPF)" value="{{ isset($cliente->cpf) ? $cliente->cpf : old('cpf', '') }}">
        </div>
        <span class="errors"> {{ $errors->first('cpf') }} </span>
    </div>
    <div class="form-group col-lg-6 col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="email"><i class="material-icons">email</i></span>
            </div>
            <input required class="form-control" type="email" name="email" placeholder="E-mail"
                value="{{ isset($cliente->email) ? $cliente->email : old('email', '') }}">
        </div>
        <span class="errors"> {{ $errors->first('email') }} </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6 col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="nascimento"><i class="material-icons">calendar_today</i></span>
            </div>
            <input required class="form-control" name="data_nascimento" type="date" id="example-date-input"
                value="{{ isset($cliente->data_nascimento) ? $cliente->data_nascimento : old('data_nascimento', '10-10-2000') }}">
        </div>
        <span class="errors"> {{ $errors->first('data_nascimento') }} </span>
    </div>
    

</div>

<div class="row">
    <div class="form-group col-xl-6 col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="celnumber"><i class="material-icons">smartphone</i></span>
            </div>
            <input required id="celnumber" name="celnumero" class="form-control input-md cel_sp"
                placeholder="(XX) X XXXX-XXXX" type="text" maxlength="11"
                value="{{isset($cliente->celnumero) ? $cliente->celnumero : old('celnumero', '')}}">
        </div>
        <span class="errors"> {{ $errors->first('celnumero') }} </span>
    </div>
    <div class="form-group col-xl-6 col-sm-12">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="telefone"><i class="material-icons">phone</i></span>
            </div>
            <input id="celnumber" name="telefonenumero" class="form-control input-md cel_sp"
                placeholder="(XX) X XXXX-XXXX" type="text" maxlength="11"
                value="{{isset($cliente->telefonenumero) ? $cliente->telefonenumero : old('telefonenumero', '')}}">
        </div>
        <span class="errors"> {{ $errors->first('telefonenumero') }} </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-3">
        <label for="endereco[cep]">CEP</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="material-icons">map</i></span>
            </div>
            <input type="text" class="form-control cep" name="endereco[cep]" value="{{ old('endereco.cep', isset($cliente) ? $cliente->endereco->cep : '') }}">
        </div>
    </div>
    <div class="form-group col-sm-6">
        <label for="endereco[logradouro]">Logradouro</label>
        <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="material-icons">house</i></span>
                </div>
                <input type="text" class="form-control" name="endereco[logradouro]" value="{{ old('endereco.logradouro', isset($cliente) ? $cliente->endereco->logradouro : '') }}">
            </div>
        </div>
    <div class="form-group col-sm-2">
        <label for="endereco[numero]">Numero</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="material-icons">house</i></span>
            </div>
            <input type="text" class="form-control" name="endereco[numero]" value="{{ old('endereco.numero', isset($cliente) ? $cliente->endereco->numero : '') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-3">
        <label for="endereco[bairro]">bairro</label>
        <div class="input-group">
            <div class="input-group-prepend">
                    <span class="input-group-text"><i class="material-icons">location_city</i></span>
            </div>
            <input type="text" class="form-control" name="endereco[bairro]" value="{{ old('endereco.bairro', isset($cliente) ? $cliente->endereco->bairro : '') }}">
        </div>
    </div>
    <div class="form-group col-sm-3">
        <label for="endereco[estado_id]">Estado</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="material-icons">location_city</i></span>
            </div>
            <select name="endereco[estado_id]" class="form-control" id="">
                <option value="" disabled selected>Selecione</option>
                @foreach($estados as $estado){
                    <option value="{{$estado->id}}" uf="{{$estado->uf}}" {{ old('endereco.estado_id', isset($cliente) ? $cliente->endereco->cidade->estado_id : "") == $estado->id ? 'selected' : '' }}>{{ $estado->nome }}</option>
                }
                @endforeach
            </select>
        </div>  
    </div>
    <div class="form-group col-sm-3">
        <label for="endereco[cidade_id]">Cidade</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="material-icons">location_city</i></span>
            </div>
            <input type="text" class="form-control" name="endereco[cidade_id]" value="">
        </div>
    </div>
</div>