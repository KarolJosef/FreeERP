@extends('funcionario::template')

@section('title')
    {{ $data['title'] }}
@endsection

@section('body')
    <form id="form" action="{{ $data['url'] }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @if($data['model'])
            @method('PUT')
        @endif

        <strong><h6 class="mb-3">Dados Básicos</h6></strong>
        <hr>
        <div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    <label for="nome" class="control-label">Nome</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">person</i>
                            </span>
                        </div>
                        <input required type="text" placeholder="Nome" name="funcionario[nome]" id="nome" class="form-control" value="{{ old('funcionario.nome', $data['model'] ? $data['model']->nome : '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('funcionario.nome') }} </span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="sexo" class="control-label">Sexo</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">person</i>
                            </span>
                        </div>
                        <select required name="funcionario[sexo]" class="form-control">
                                <option value="">Selecione</option>
                                <option {{ old('funcionario.sexo', $data['model'] ? $data['model']->sexo : '') == '0' ? 'selected' : ''}} value='0'>Feminino</option>
                                <option {{ old('funcionario.sexo', $data['model'] ? $data['model']->sexo : '') == '1' ? 'selected' : ''}} value='1'>Masculino</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-{{$data['model'] ? '4' : 3}}">
                <div class="form-group">
                    <label for="estado_civil_id" class="control-label">Estado Civil</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">person</i>
                            </span>
                        </div>
                        <select required name="funcionario[estado_civil_id]" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($data['estado_civil'] as $item)
                                <option value="{{ $item->id }}" {{ old('funcionario.estado_civil_id', $data['model']? $data['model']->estado_civil()->id : '') == $item->id ? 'selected' : '' }}> {{ $item->nome }} </option>
                            @endforeach 
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-{{$data['model'] ? '4' : 3}}">
                <div class="form-group">
                    <label for="data_nascimento" class="control-label">Data de Nascimento</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">date_range</i>
                            </span>
                        </div>
                        <input required type="text" placeholder="00/00/0000" name="funcionario[data_nascimento]" id="data_nascimento" class="form-control data" value="{{ old('funcionario.data_nascimento', $data['model'] ? $data['model']->data_nascimento : '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('funcionario.data_nascimento') }} </span>
                </div>
            </div>
            <div class="col-md-{{$data['model'] ? '4' : 3}}">
                <div class="form-group">
                    <label for="data_f" class="control-label">Data de Admissão</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">date_range</i>
                            </span>
                        </div>
                        <input required type="text" placeholder="00/00/0000" name="funcionario[data_admissao]" id="data_admissao" class="form-control data" value="{{ old('funcionario.data_admissao', $data['model'] ? $data['model']->data_admissao : '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('funcionario.data_admissao') }} </span>
                </div>
            </div>
            @if(!$data['model'])
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="cargo_id" class="control-label">Cargo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons">work</i>
                                </span>
                            </div>
                            <select required name="cargo[cargo_id]" class="form-control">
                                <option value="">Selecione</option>
                                @foreach($data['cargos'] as $item)
                                    <option value="{{ $item->id }}" {{ old('cargo.cargo_id', $data['model'] ? $data['model']->cargos->last()->pivot->cargo_id : '' ) ? 'selected' : '' }}> {{ $item->nome }} </option>
                                @endforeach 
                            </select>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <strong><h6 class="mt-5 mb-3">Documentos</h6></strong>
        <hr>
        <div id="documentos">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tipo" class="control-label">CPF</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons">description</i>
                                </span>
                            </div>
                            @if($data['model'])
                                <input type="hidden" name="documentos[cpf][id]" value="{{$data['model']->cpf()->id}}">
                            @endif
                            <input required type="text" placeholder="XXX.XXX.XXX-XX" name="documentos[cpf][numero]" id="cpf" class="form-control" value="{{ old('documentos.cpf.numero', $data['model'] ? $data['model']->cpf()->numero : '') }}">
                            <input required type="hidden" name="documentos[cpf][tipo_documento_id]" value="1">
                        </div>
                        <span class="errors"> {{ $errors->first('documentos.cpf.numero') }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tipo" class="control-label">RG</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="material-icons">description</i>
                                </span>
                            </div>
                            @if($data['model'])
                                <input type="hidden" name="documentos[rg][id]" value="{{$data['model']->rg()->id}}">
                            @endif
                            <input required type="text" placeholder="RG" name="documentos[rg][numero]" id="rg" class="form-control" value="{{ old('documentos.rg.numero', $data['model'] ? $data['model']->rg()->numero : '') }}">
                            <input required type="hidden" name="documentos[rg][tipo_documento_id]" value="2">
                        </div>
                        <span class="errors"> {{ $errors->first('documentos.rg.numero') }}</span>
                    </div>
                </div>
            </div>        
            @foreach(old('docs_outros', $data['documentos']) as $key => $documento)

                <div class="row doc {{ isset($documento['numero']) ? '' : 'd-none'}}">
                    @if(isset($documento['id']))
                        <input type="hidden" class="documentos" value="{{isset($documento['id']) ? $documento['id'] : ''}}" name="docs_outros[{{$key}}][id]">
                    @endif

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tipo" class="control-label">Tipo</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">description</i>
                                    </span>
                                </div>
                                <select name="docs_outros[{{$key}}][tipo_documento_id]" class="form-control documentos" {{isset($documento) ? '' : 'disabled'}}>
                                    <option value="">Selecione</option>
                                    @foreach($data['tipo_documentos'] as $tipo)
                                        <option value="{{$tipo->id}}" {{ isset($documento['tipo_documento_id']) && $documento['tipo_documento_id'] == $tipo['id'] ? 'selected' : '' }}>{{$tipo->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="errors"> {{ $errors->first('docs_outros.'.$key.'.tipo_documento_id') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="numero_documento" class="control-label">Número</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">description</i>
                                    </span>
                                </div>
                                <input required type="text" placeholder="Número" name="docs_outros[{{$key}}][numero]" id="numero_documento_{{$key}}" class="form-control documentos" value="{{ isset($documento['numero']) ? $documento['numero'] : ''}}" {{ isset($documento) ? '' : 'disabled' }}>
                            </div>
                            <span class="errors"> {{ $errors->first('docs_outros.'.$key.'.numero') }} </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Comprovante</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">archive</i>
                                    </span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="docs_outros[{{$key}}][comprovante]" id="comprovante_{{$key}}" class="custom-file-input documentos">
                                    <label for="comprovante" class="custom-file-label">Comprovante</label>   
                                </div>
                                <span class="errors"> {{ $errors->first('docs_outros.'.$key.'.comprovante') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <span class="btn btn-danger border text-center material-icons del-doc mt-2">delete</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-2">
            <i class="btn btn-info border text-center add-doc">ADICIONAR DOCUMENTO</i>
        </div>

        <strong><h6 class="mt-5 mb-3">Endereço</h6></strong>
        <hr>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="cep" class="control-label">CEP</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">location_on</i>
                            </span>
                        </div>
                        <input required type="text" placeholder="CEP" name="endereco[cep]" id="cep" class="form-control" value="{{ old('endereco.cep', $data['model'] ? $data['model']->endereco()->cep : '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('endereco.cep') }} </span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="uf" class="control-label">Estado</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">location_on</i>
                            </span>
                        </div>
                        <select name="endereco[estado_id]" id="estado_id" class="form-control estados">
                            <option value="">Selecione</option>
                            @foreach($data['estados'] as $estado))
                                <option data-uf="{{$estado->uf}}" value="{{ $estado->id }}" {{ old('endereco.estado_id', $data['model'] ? $data['model']->endereco()->cidade->estado_id : '') == $estado->id ? 'selected' : '' }}>{{ $estado->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span class="errors"> {{ $errors->first('endereco.uf') }} </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="cidade" class="control-label">Cidade</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">location_on</i>
                            </span>
                        </div>
                        <select name="endereco[cidade_id]" id="cidade_id" class="form-control cidades">
                            <option value="">Selecione</option>
                            @foreach($data['cidades'] as $cidade))
                                <option value="{{ $cidade->id }}" {{ old('endereco.cidade_id', $data['model'] ? $data['model']->endereco()->cidade_id : '') == $cidade->id ? 'selected' : '' }}>{{ $cidade->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span class="errors"> {{ $errors->first('endereco.cidade_id') }} </span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="bairro" class="control-label">Bairro</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">location_on</i>
                            </span>
                        </div>
                        <input required type="text" placeholder="Bairro" name="endereco[bairro]" id="bairro" class="form-control bairro" value="{{ old('endereco.bairro', $data['model'] ? $data['model']->endereco()->bairro : '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('endereco.bairro') }} </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="logradouro" class="control-label">Logradouro</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">location_on</i>
                            </span>
                        </div>
                        <input required type="text" placeholder="Logradouro" name="endereco[logradouro]" id="logradouro" class="form-control logradouro" value="{{ old('endereco.logradouro', $data['model'] ? $data['model']->endereco()->logradouro : '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('endereco.logradouro') }} </span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="numero" class="control-label">Número</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">location_on</i>
                            </span>
                        </div>
                        <input required type="text" placeholder="N°" name="endereco[numero]" id="numero" class="form-control numero" value="{{ old('endereco.numero', $data['model'] ? $data['model']->endereco()->numero : '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('endereco.numero') }} </span>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="complemento" class="control-label">Complemento</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">location_on</i>
                            </span>
                        </div>
                        <input type="text" placeholder="Complemento" name="endereco[complemento]" id="complemento" class="form-control" value="{{ old('endereco.complemento', $data['model'] ? $data['model']->endereco()->complemento : '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('endereco.complemento') }} </span>
                </div>
            </div>
        </div>

        <strong><h6 class="mt-5 mb-3">Contato</h6></strong>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="control-label">E-mail</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">email</i>
                            </span>
                        </div>
                        <input required type="text" placeholder="E-mail" name="email" id="email" class="form-control" value="{{ old('email', $data['model'] ? $data['model']->email()->email : '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('email') }} </span>
                </div>
            </div>
        </div>
        <div id="telefones">
            @foreach(old('telefones', $data['telefones']) as $key => $telefone)
                <div class="row tel">
                    <div class="col-md-6">
                        <div class="form-row">

                            @if($data['model'])
                                <input type="hidden" value="{{isset($telefone->id) ? $telefone->id : ''}}" name="telefones[{{$key}}][id]">
                            @endif

                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">phone</i>
                                            </span>
                                        </div>
                                        <select required name="telefones[{{$key}}][tipo_telefone_id]" class="form-control tipo_telefones">
                                            <option value="">Selecione</option>
                                            @foreach($data['tipos_telefone'] as $item)
                                                <option value="{{ $item->id }}" {{ isset($telefone['tipo_telefone_id']) && $telefone['tipo_telefone_id'] == $item->id ? 'selected' : '' }}> {{ $item->nome }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="errors"> {{ $errors->first('telefones.'.$key.'.tipo_telefone_id') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <div class="input-group">
                                        <input required type="text" placeholder="Telefone" name="telefones[{{$key}}][numero]" class="form-control telefone" value="{{$telefone['numero'] ? $telefone['numero'] : ''}}">
                                    </div>
                                    <span class="errors"> {{ $errors->first('telefones.'.$key.'.numero') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <i class="btn btn-info border text-center material-icons add-tel">add</i>
                        <i class="btn btn-danger border text-center material-icons del-tel">delete</i>
                    </div>
                </div>
            @endforeach
        </div>
    </form>
@endsection

@section('footer')
    <div class="text-right">
        <button class="btn btn-success sendForm" type="button">{{$data['button']}}</button>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="{{Module::asset('funcionario:js/helpers.js')}}"></script>
    <script src="{{Module::asset('funcionario:js/views/funcionario/form.js')}}"></script>
    <script src="{{Module::asset('funcionario:js/views/funcionario/validations.js')}}"></script>
@endsection