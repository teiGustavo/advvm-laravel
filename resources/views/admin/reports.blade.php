@extends('master')

@section('content')
    <div class="container bg-dark rounded-3 w-100">
        <div class="container d-flex flex-column h-50" data-bs-theme="dark">
            <div class="d-flex justify-content-between mt-4 mb-5 p-2">
                <h3 class="text-light align-self-center pl-2">
                    Listagem de Lançamentos - Página {{ $reports->currentPage() }}
                </h3>

                <nav aria-label="Page navigation example" class="" data-bs-theme="dark">
                    <ul class="pagination pagination-sm justify-content-center">
                        <li class="page-item">
                            <a class="page-link text-light" href="{{ $reports->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @if($reports->currentPage() == 1)
                            <li class="page-item active">
                                <a class="page-link text-light" href="{{ $reports->url(1) }}">1</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link text-light" href="{{ $reports->url(1) }}">1</a>
                            </li>
                        @endif

                        <li class="page-item disabled">
                            <a class="page-link text-light">...</a>
                        </li>

                        @if($reports->currentPage() == $reports->lastPage())
                            <li class="page-item active">
                                <a class="page-link text-light"
                                   href="{{ $reports->url($reports->lastPage()) }}">{{ $reports->lastPage() }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link text-light"
                                   href="{{ $reports->url($reports->lastPage()) }}">{{ $reports->lastPage() }}</a>
                            </li>
                        @endif

                        <li class="page-item">
                            <a class="page-link text-light" href="{{ $reports->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <table class="table table-dark table-hover mb-5">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Data</th>
                    <th scope="col">Histórico</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Ação</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                        <tr class="" style="vertical-align: baseline">
                            <th scope="row">{{ $report->id }}</th>
                            <td>{{ date("d/m/y", strtotime($report->data_report)) }}</td>
                            <td>{{ $report->historico }}</td>
                            <td>{{ $report->tipo }}</td>
                            <td>R$ {{ number_format($report->valor, 2, ',', '.') }}</td>
                            <td class="w-25">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        Ações
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item cursor-pointer" id="edit"
                                            onclick="updateReport({{ $report->id }})" data-bs-toggle="modal"
                                               data-bs-target="#modal">Editar</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger cursor-pointer" id="delete"
                                               onclick="deleteReport({{ $report->id }})">Excluir</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade text-light" id="modal" tabindex="-1" aria-labelledby="modalLabel"
         aria-hidden="true" data-bs-theme="dark">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLabel">Editar Relatório:</h1>
                    <div id="loading" class="spinner-grow text-info spinner-grow-sm hidden" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.reports.update') }}" id="formUpdate">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="data_report" placeholder="0000-00-00">
                            <label for="data_report">Data</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="historico" placeholder="Lançamento">
                            <label for="historico">Lançamento</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="valor" placeholder="Valor">
                            <label for="valor">Valor</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="tipo" aria-label="Floating label select example">
                                <option value="Entrada" id="entrada">Entrada</option>
                                <option value="Saída" id="saida">Saída</option>
                            </select>
                            <label for="floatingSelect">Tipo</label>
                        </div>
                    </div>
                    <div class="modal-footer" id="modalFooter">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnSair">Sair</button>
                        <button type="submit" class="btn btn-success" id="btnSelectMonth">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    let form = $("#formUpdate");
    let data = $("#data_report");
    let historico = $("#historico");
    let tipo = $("#tipo");
    let entrada = $("#entrada");
    let saida = $("#saida");
    let valor = $("#valor");
    let csrfToken = $("[name='_token']");

    if ({{ $reports->count() }} === 0) {
        window.location.href = '{{ route('admin.reports') }}?page={{ $reports->lastPage() }}'
    }

    function updateReport(id) {
        const getReports = async (id) => {
            let url = '{{ env('APP_URL') }}';

            if ('{{ env('APP_ENV') }}' !== 'production') {
                url = `${url}:8000`;
            }

            const response = await fetch(`${url}/api/reports/${id}`);

            return response.json();
        }

        const defineReports = async (id) => {
            const report = await getReports(id);

            data.val(report.data_report);
            historico.val(report.historico);
            valor.val(report.valor);

            if (report.tipo === 'Entrada') {
                entrada.attr('selected', 'selected');
            } else {
                saida.attr('selected', 'selected');
            }
        }

        defineReports(id);

        form.submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: this.action,
                data: {
                    _token: csrfToken.val(),
                    id: id,
                    data_report: data.val(),
                    historico: historico.val(),
                    tipo: tipo.val(),
                    valor: valor.val(),
                },
                method: 'POST'
            }).done(function () {
                location.reload();
            })
        });
    }

    function deleteReport(id) {
        window.location.href = '{{ route('admin.reports.delete') }}/' + id;
    }
</script>
@endsection
