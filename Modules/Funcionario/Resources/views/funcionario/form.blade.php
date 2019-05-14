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
            <div class="col-md-12">
                <div class="form-group">
                    <label for="nome" class="control-label">Nome</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">person</i>
                            </span>
                        </div>
                        <input required type="text" placeholder="Nome" name="funcionario[nome]" id="nome" class="form-control" value="{{ $data['model'] ? $data['model']->nome : old('funcionario.nome', '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('funcionario.nome') }} </span>
                </div>
            </div>
        </div>
        <div class="row">
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
                                <option {{ $data['model'] && $data['model']->sexo == 0 ? 'selected' : ''}} value="0">Feminino</option>
                                <option {{ $data['model'] && $data['model']->sexo == 1 ? 'selected' : ''}} value="1">Masculino</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
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
                                <option value="{{ $item->id }}" {{ ($data['model'] && $item->id == $data['model']->estado_civil_id ) ? 'selected' : '' }}> {{ $item->nome }} </option>
                            @endforeach 
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="data_nascimento" class="control-label">Data de Nascimento</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">date_range</i>
                            </span>
                        </div>
                        <input required type="text" placeholder="00/00/0000" name="funcionario[data_nascimento]" id="data_nascimento" class="form-control data" value="{{ $data['model'] ? $data['model']->data_nascimento : old('funcionario.data_nascimento', '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('funcionario.data_nascimento') }} </span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="data_admissao" class="control-label">Data de Admissão</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">date_range</i>
                            </span>
                        </div>
                        <input required type="text" placeholder="00/00/0000" name="funcionario[data_admissao]" id="data_admissao" class="form-control data" value="{{ $data['model'] ? $data['model']->data_admissao : old('funcionario.data_admissao', '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('funcionario.data_admissao') }} </span>
                </div>
            </div>
        </div>

        <?php
            $documentos = ['vazio'];

            if(old('docs_outros') !== null) {
                $documentos = old('docs_outros');
            }
            else if($data['model']) {
                $documentos = $data['model']->documentos->where('tipo', '<>', 'cpf')->where('tipo', '<>', 'rg');

                if(count($documentos) == 0) {
                    $documentos = ['vazio'];
                }
            }
        ?>

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
                                <input type="hidden" name="documentos[cpf][id]" value="{{$data['model']->cpf()->first()->id}}">
                            @endif
                            <input required type="text" placeholder="XXX.XXX.XXX-XX" name="documentos[cpf][numero]" id="cpf" class="form-control" value="{{$data['model'] && old('documentos.cpf.numero') == null ? $data['model']->cpf()->first()->numero : old('documentos.cpf.numero', '') }}">
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
                                <input type="hidden" name="documentos[rg][id]" value="{{$data['model']->rg()->first()->id}}">
                            @endif
                            <input required type="text" placeholder="RG" name="documentos[rg][numero]" id="rg" class="form-control" value="{{ $data['model'] && old('documentos.rg.numero') == null ? $data['model']->rg()->first()->numero : old('documentos.rg.numero', '') }}">
                        </div>
                        <span class="errors"> {{ $errors->first('documentos.rg.numero') }}</span>
                    </div>
                </div>
            </div>        
            @foreach($documentos as $key => $documento)

                <div class="row doc {{ $documento !== 'vazio' ? '' : 'd-none'}}">
                    @if($documento !== 'vazio')
                        <input type="hidden" class="documentos" value="{{isset($documento->id) ? $documento->id : ''}}" name="docs_outros[{{$key}}][id]">
                    @endif
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tipo" class="control-label">Nome</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">description</i>
                                    </span>
                                </div>
                                <input required type="text" placeholder="Nome" name="docs_outros[{{$key}}][tipo]" id="tipo_{{$key}}" class="form-control documentos" value="{{$documento !== 'vazio' ? $documento['tipo'] : ''}}" {{($documento !== 'vazio') ? '' : 'disabled'}}> 
                            </div>
                            <span class="errors"> {{ $errors->first('docs_outros.tipo') }}</span>
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
                                <input required type="text" placeholder="Número" name="docs_outros[{{$key}}][numero]" id="numero_documento_{{$key}}" class="form-control documentos" value="{{($documento !== 'vazio') ? $documento['numero'] : ''}}" {{($documento !== 'vazio') ? '' : 'disabled'}}>
                            </div>
                            <span class="errors"> {{ $errors->first('docs_outros.numero') }} </span>
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
                                    <input type="file" name="docs_outros[{{$key}}][comprovante]" id="comprovante_{{$key}}" class="custom-file-input documentos" value="{{($documento !== 'vazio' && isset($documento['comprovante'])) ? $documento['comprovante'] : ''}}" {{($documento !== 'vazio') ? '' : 'disabled'}}>
                                    <label for="comprovante" class="custom-file-label">Comprovante</label>   
                                </div>
                                <span class="errors"> {{ $errors->first('docs_outros.comprovante') }}</span>
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
            <div class="col-md-3">
                <div class="form-group">
                    <label for="cep" class="control-label">CEP</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">location_on</i>
                            </span>
                        </div>
                        <input required type="text" placeholder="CEP" name="endereco[cep]" id="cep" class="form-control" value="{{ $data['model'] ? $data['model']->endereco->cep : old('endereco.cep', '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('endereco.cep') }} </span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="uf" class="control-label">UF</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">location_on</i>
                            </span>
                        </div>
                        <input required type="text" placeholder="UF" name="endereco[uf]" id="uf" class="form-control" value="{{ $data['model'] ? $data['model']->endereco->uf : old('endereco.uf', '') }}">
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
                        <input required type="text" placeholder="Cidade" name="endereco[cidade]" id="cidade" class="form-control" value="{{ $data['model'] ? $data['model']->endereco->cidade : old('endereco.cidade', '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('endereco.cidade') }} </span>
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
                        <input required type="text" placeholder="Bairro" name="endereco[bairro]" id="bairro" class="form-control" value="{{ $data['model'] ? $data['model']->endereco->bairro : old('endereco.bairro', '') }}">
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
                        <input required type="text" placeholder="Logradouro" name="endereco[logradouro]" id="logradouro" class="form-control" value="{{ $data['model'] ? $data['model']->endereco->logradouro : old('endereco.logradouro', '') }}">
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
                        <input required type="text" placeholder="N°" name="endereco[numero]" id="numero" class="form-control" value="{{ $data['model'] ? $data['model']->endereco->numero : old('endereco.numero', '') }}">
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
                        <input type="text" placeholder="Complemento" name="endereco[complemento]" id="complemento" class="form-control" value="{{ $data['model'] ? $data['model']->endereco->complemento : old('endereco.complemento', '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('endereco.complemento') }} </span>
                </div>
            </div>
        </div>

        <strong><h6 class="mt-5 mb-3">Cargos</h6></strong>
        <hr>
        @if($data['model'])
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped">
                        <thead class="thead thead-dark">
                            <tr>
                                <th>Cargo</th>
                                <th>Data de Entrada</th>
                                <th>Data de Saída</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data['model']->cargos as $cargo)
                        <tr>
                            <td>{{ $cargo->cargo->nome }}</td>
                            <td>{{ $cargo->data_entrada }}</td>
                            <td>{{ ($cargo->data_saida) ? $cargo->data_saida : 'X' }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="cargo_id" class="control-label">Cargo Atual</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">work</i>
                            </span>
                        </div>
                        <select required name="cargo[cargo_id]" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($data['cargos'] as $item)
                                <option value="{{ $item->id }}" {{ ($data['model'] && $item->id == $data['model']->cargos->last()->cargo_id ) ? 'selected' : '' }}> {{ $item->nome }} </option>
                            @endforeach 
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="data_admissao" class="control-label">Data de entrada</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">date_range</i>
                            </span>
                        </div>
                        <input required type="text" placeholder="00/00/0000" name="cargo[data_entrada]" id="data_admissao" class="form-control data" value="{{ $data['model'] ? $data['model']->data_admissao : old('funcionario.data_admissao', '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('funcionario.data_admissao') }} </span>
                </div>
            </div>
        </div>

        <?php
            $telefones = old('telefones') !== null ? old('telefones') : ($data['model'] ? $data['model']->contato->telefones : ['vazio']);
        ?>

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
                        <input required type="text" placeholder="E-mail" name="contato[email]" id="email" class="form-control" value="{{ $data['model'] ? $data['model']->contato->email : old('contato.email', '') }}">
                    </div>
                    <span class="errors"> {{ $errors->first('contato.email') }} </span>
                </div>
            </div>
        </div>
        <div id="telefones">
            @foreach($telefones as $key => $telefone)
                <div class="row tel">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">phone</i>
                                    </span>
                                </div>
                                @if($data['model'])
                                    <input type="hidden" value="{{isset($telefone->id) ? $telefone->id : ''}}" name="telefones[{{$key}}][id]">
                                @endif
                                <input required type="text" placeholder="Telefone" name="telefones[{{$key}}][numero]" class="form-control telefone" value="{{$telefone != 'vazio' ? $telefone['numero'] : ''}}">
                            </div>
                            <span class="errors"> {{ $errors->first('telefones.numero') }}</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <i class="btn btn-info border text-center material-icons add-tel">add</i>
                        <i class="btn btn-danger border text-center material-icons del-tel">delete</i>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- <strong><h6 class="mt-4 mb-3">Dependentes</h6></strong>
        <hr>
        <div class="form-group row">
            <div class="col-md-8">
                <label for="nome_dependente" class="control-label">Nome</label>
                <input type="text" placeholder="Nome" name="dependentes[nome]" id="nome_dependente" class="form-control" value="{{ $data['model'] ? $data['model']->nome : old('dependentes.nome', '') }}">
                <label class="errors"> {{ $errors->first('dependentes.nome') }} </label>
            </div>
            <div class="col-md-4">
                <label for="data_nascimento_dependente" class="control-label">Data de Nascimento</label>
                <input type="text" placeholder="00/00/0000" name="dependentes[data_nascimento]" id="data_nascimento_dependente" class="form-control" value="{{ $data['model'] ? $data['model']->data_nascimento : old('dependentes.data_nascimento', '') }}">
                <label class="errors"> {{ $errors->first('dependentes.data_nascimento') }} </label>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="cpf_dependente" class="control-label">CPF</label>
                <input type="text" placeholder="E-mail" name="dependentes[cpf]" id="cpf_dependente" class="form-control" value="{{ $data['model'] ? $data['model']->cpf : old('dependentes.cpf', '') }}">
                <label class="errors"> {{ $errors->first('dependentes.cpf') }} </label>
            </div>
            <div class="col-md-6">
                <label for="comprovante_dependente" class="control-label">Carteira de Vacinação</label>
                <input type="file" placeholder="E-mail" name="dependentes[comprovante]" id="comprovante_dependente" class="form-control-file" value="{{ $data['model'] ? $data['model']->comprovante : old('dependentes.comprovante', '') }}">
                <label class="errors"> {{ $errors->first('dependentes.comprovante') }} </label>
            </div>
        </div>
        -->
    </form>
@endsection

@section('footer')
    <div class="text-right">
        <button class="btn btn-success sendForm" type="button">{{$data['button']}}</button>
    </div>
@endsection

@section('script')
    <script src="{{Module::asset('funcionario:js/helpers.js')}}"></script>
    <script src="{{Module::asset('funcionario:js/views/funcionario/form.js')}}"></script>
    <script src="{{Module::asset('funcionario:js/views/funcionario/validations.js')}}"></script>
@endsection