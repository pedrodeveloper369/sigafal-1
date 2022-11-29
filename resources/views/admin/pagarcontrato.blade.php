
@extends('layouts.template')

@section('title', 'Contractos')


@section('content')

<div class="section__content section__content--p30">
    <div class="container-fluid">

        @if($errors->any())
              
                         @foreach($errors->all() as $erro)
                            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                <span class="badge badge-pill badge-danger">Erro</span>
                                {{$erro}} 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endforeach            
                    

                 @endif  

                 @if(isset($sms))

                 <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                     <span class="badge badge-pill badge-success">Success</span>
                     {{$sms}}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
 
                 @endif

                 <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Contractos</h2>
                            <button class="au-btn au-btn-icon au-btn--blue" data-toggle="modal" data-target="#registarcontratos" >
                                <i class="zmdi zmdi-plus"></i>Registar</button>
                        </div>
                    </div>
                </div>

        <div class="myresponsivetable table-responsive table-responsive-data3 ">
        <table class="table " id="datatable">
            <thead class="table-dark">
           
                <tr>
                    <th>Id</th>
                    <th>Cliente</th>
                    <th>Nif</th>
                    <th>Modo de pagamento</th>
                   
                    <th>Valor do contracto</th>
                    <th>Data</th> 
                    <th>Acções</th>
                    </tr>
                
            </thead>
            <tbody>
                

                @php 
                //formatando o valor que vem da BD no formato de dinheiro
               // $valor = number_format($s->multa, 2,",",".");

                @endphp
            @if(isset($contratos))
                  @foreach($contratos as $c)
                  
               
                <tr>
                    <td>{{ $c->id}}</td>
                    <td>{{ $c->cliente}}</td>
                    <td>{{ $c->nif}}</td>
                    <td>{{ $c->modopagamento}}</td>
                   
                    <td>{{number_format( $c->precocontrato, 2,",",".") }}</td>
                    <td>{{$c->datacontrato  }}</td>
                    <td  class="d-flex justify-content-center"> 
                        <button class="btn btn-sm btn-outline-primary editar mr-1" id="">
                            <a class="bnEditar" href="{{url("/dashboard/contratos/show/$c->id")}}">Alterar</a>
                        </button>

                        <button class="btn btn-sm btn-secondary mr-1">
                            <a href="{{url("/dashboard/contrato$c->id")}}" class="bnEditar" target="_blank">Imprimir</a>
                        </button>
                        @can('Administrador')
                        <button class="btn btn-sm btn btn-danger eliminar mr-1" id="{{$c->id}}" onclick="retornaid({{$c->id}})" data-toggle="modal"   data-target="#smallmodal">
                          Eliminar
                         </button>

                         <button class="btn btn-sm btn btn-info mr-1" id="{{$c->id}}">
                           <a class="bnEditar" href="{{url("/dashboard/contratos-show/$c->id")}}">Pagar</a>
                           </button>
                        @endcan
                    </td>
                   

                </tr>
                @endforeach
                   
            @endif 
            </tbody>
          </table>
        </div>
    </div>
</div>




<!-- modal registar Contratos -->
<div class="modal fade" id="s" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Registar Contratos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div hidden class="sufee-alert alert with-close alert-danger alert-dismissible fade show" id="erro-registar">
                                </div>
                                <form id="form-registar-contrato" action="{{url('/dashboard/contratos/store')}}" method="Post" novalidate="novalidate">
                                    @csrf

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <label for="cliente" class=" form-control-label">Cliente</label>
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <select name="cliente" id="cliente" class="form-control">
                                                        <option selected="selected">Selecione</option>
                                                        @if(isset($clientes))
                                                            @foreach($clientes as $c)
                                                        <option value="{{$c->id}}">{{$c->nome}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="valor" class="control-label mb-1">Valor</label>
                                                <input id="valor" name="valor" type="text" class="form-control cc-exp" required>
                                                <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                                            </div>
                                        </div>


                                        <div class="col-6">
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <label for="modopagamento" class=" form-control-label">Modo de pagamento</label>
                                                </div>
                                                <div class="col-12 col-md-12">
                                                    <select name="modopagamento" id="modopagamento" class="form-control">
                                                        <option selected="selected">Selecione</option>
                                                        <option value="Prestação">Prestação</option>
                                                        <option value="Completo">Completo</option>
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="valorapagar" class="control-label mb-1">Valor a pagar</label>
                                                <input id="valorapagar" name="valorapagar" type="text" class="form-control cc-exp" required>
                                                <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                                            </div>
                                        </div>

                                        

                                        

                                        
                                    </div>

                                    <div class="text-right">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" id="btn-registar-contrato" class="btn btn-primary">Confirmar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- end modal medium -->


<!-- modal small -->
<div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="smallmodalLabel">Atenção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-3">
                    Tem certeza que deseja eliminar este registo?
                </p>
                <form action="{{url("/dashboard/contratos/delete")}}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" value="" name="id" id="contrato_id">
                    <div class="float-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                        <button type="submit" class="btn btn-primary">Sim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end modal small -->






<!-- modal registar Contratos -->
<div class="modal fade" id="pagamentocontrato" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Registar pagamento de Contrato</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div hidden class="sufee-alert alert with-close alert-danger alert-dismissible fade show" id="erro-registar">
                                </div>
                                <div class="mb-2">
                                    <p> Cliente: {{$cont[0]->cliente}} </p>
                                    <p> Nif: {{$cont[0]->nif}} </p>
                                </div>
                                <form id="form-registar-contrato" action="{{url('/dashboard/pagar-contrato ')}}" method="Post" novalidate="novalidate">
                                    @csrf

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="pagarcontrato" class="control-label mb-1">Valor a pagar</label>
                                                <input id="pagarcontrato" name="valor" type="text" class="form-control cc-exp" required>
                                                <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>
                                                <input id="contrato_id"  value="{{$cont[0]->id}}" name="contrato_id" type="hidden"required>

                                            </div>
                                        </div>   
                                    </div>

                                    <div class="text-right">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" id="btn-registar-contrato" class="btn btn-primary">Confirmar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- end modal medium -->






<script>
    $(document).ready(function(){
        //mascaras com jmask
        $('#valor').mask('#.##0,00',{reverse: true});
        $('#valor').mask('#.##0,00',{reverse: true});
        $('#valorapagar').mask('#.##0,00',{reverse: true});
        $('#pagarcontrato').mask('#.##0,00',{reverse: true});
        $('#pagamentocontrato').modal('show');


    });
    
    $(document).ready(function(){
        //codigo para inicializar a data table
       var table=$('#datatable').DataTable();

    btn_registar=document.getElementById("btn-registar-contrato");
    btn_registar.addEventListener('click', (event)=>{

            event.preventDefault();
            var formregistar=document.getElementById("form-registar-contrato");
            var cliente=document.getElementById("cliente").value;
            var valor=document.getElementById("valor").value;
            var modo=document.getElementById("modopagamento").value;
            var valorapagar=document.getElementById("valorapagar").value;
            var erro= document.getElementById("erro-registar");

            if(cliente == 'Selecione'){
                erro.innerHTML="Por favor Selecione um cliente";
                erro.removeAttribute('hidden');
                cliente.focus();
                return false;
            }else{
                erro.setAttribute('hidden', true);
            }

            if(valor == ''){
                erro.innerHTML="O campo <strong> Valor </strong> é de Obrigatório";
                erro.removeAttribute('hidden');
                cliente.focus();
                return false;
            }else{
                erro.setAttribute('hidden', true);
            }

            if(modo == 'Selecione'){
                erro.innerHTML="Por favor Selecione um <strong> modo de pagamento </strong>";
                erro.removeAttribute('hidden');
                modo.focus();
                return false;
            }else{
                erro.setAttribute('hidden', true);
            }

            if(valorapagar == ''){
                erro.innerHTML="O campo <strong> Valor a pagar </strong> é de Obrigatório";
                erro.removeAttribute('hidden');
                cliente.focus();
                return false;
            }else{
                erro.setAttribute('hidden', true);
                formregistar.submit();
            }





        });
            
   });

        function retornaid(id){
            $('#contrato_id').val(id);
        }

        function pagar(id){
            $('#contrato_id').val(id);
        }

</script>

@endsection