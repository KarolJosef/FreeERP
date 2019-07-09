<div class="form-group">
  <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text" id="cliente"><i class="material-icons">person</i></span>
    </div>
    <input class="form-control" name="nome" type="text" placeholder="Nome do serviço" value="{{isset($servico->nome) ? $servico->nome : old('nome', '')}}">
    <div class="col-12">
      <span class="errors"> {{ $errors->first('nome') }} </span>
    </div>
  </div>

</div>
<div class="form-group">
  <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text" id="cliente"><i class="material-icons">money</i></span>
    </div>
    <input class="form-control" name="valor" type="text" placeholder="Valor" value="{{isset($servico->valor) ? $servico->valor : old('valor', '')}}">
    <div class="col-12">
      <span class="errors"> {{ $errors->first('valor') }} </span>
    </div>
  </div>

</div>
