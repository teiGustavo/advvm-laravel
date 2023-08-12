@extends('master')

@section('content')
    @if(session()->missing('month'))
        <!-- Button trigger modal -->
        <button type="button" id="btn" class="btn btn-light text-light" data-bs-toggle="modal"
                data-bs-target="#modalSelectMonth">Começar</button>

        <!-- Modal -->
        <div class="modal fade text-light" id="modalSelectMonth" tabindex="-1" aria-labelledby="modalSelectMonthLabel"
             aria-hidden="true" data-bs-theme="dark">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalSelectMonthLabel">Selecionar Mês:</h1>
                        <div id="loading" class="spinner-grow text-info spinner-grow-sm hidden" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.reports.selectMonth') }}" id="formMonth">
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label for="month" class="form-label hidden">Mês:</label>
                                <input type="month" class="form-control text-capitalize" id="month">
                            </div>
                        </div>
                        <div class="modal-footer" id="modalFooter">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnSair">Sair</button>
                            <button type="submit" class="btn btn-success disabled" id="btnSelectMonth">Selecionar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div id="divForm" class="container-sm text-light hidden" style="max-width: 750px">
        <form id="formCreate" action="{{ route('admin.reports.store') }}" class="mt-3">
            @csrf
            <x-forms.input type="date" label="Dia:" :min="session('dateMin')" :max="session('dateMax')" id="date" />
            <x-forms.input label="Lançamento:" id="report" class="text-capitalize" />
            <x-forms.input label="Valor:" id="value" />

            <button type="button" class="btn btn-danger mb-3 text-light" id="btnFinalizar">Finalizar</button>
            <button type="submit" class="btn btn-success mb-3 text-light">Cadastrar</button>
        </form>
    </div>
@endsection

@section('js')
    <script>
        let btnModal = $('#btn');
        let btnSelecionar = $('#btnSelectMonth');
        let btnSair = $('#btnSair');
        let btnFinalizar = $('#btnFinalizar');
        let inputMonth = $('#month');
        let formMonth = $('#formMonth');
        let formCreate = $('#formCreate');
        let csrfToken = $("[name='_token']");
        let input = $('input');
        let divForm = $('#divForm');
        let session = "{{ session('month') }}";

        if (session !== "") {
            divForm.fadeIn(400);
        } else {
            btnModal.trigger("click");
        }

        inputMonth.change(function () {
            if (btnSelecionar.hasClass('disabled')) {
                btnSelecionar.removeClass('disabled');
            }

            if (!inputMonth.val()) {
                btnSelecionar.addClass('disabled');
            }
        });

        formMonth.submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: this.action,
                data: {
                    _token: csrfToken.val(),
                    date: inputMonth.val()
                },
                method: 'POST'
            }).done(function () {
                btnSair.trigger('click');

                btnModal.hide();
                divForm.fadeIn(400);

                location.reload();
            }).fail(function () {
                divForm.hide();
                btnModal.show();
            });
        });

        formCreate.submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: this.action,
                data: {
                    _token: csrfToken.val(),
                    date: $('#date').val(),
                    report: $('#report').val(),
                    value: $('#value').val(),
                },
                method: 'POST'
            }).done(function () {
                location.reload();
            });
        });

        btnFinalizar.on('click', function () {
            window.location.href = "{{ route('admin.endCreateReport') }}";
        });
    </script>
@endsection
