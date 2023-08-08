@extends('master')

@section('content')
    @if(empty(session('month')))
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

    <div id="divForm" class="container-sm text-light" style="max-width: 750px">
        <form class="mt-3">
            <div class="row mb-3 text-left">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Dia:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control text-light" id="inputEmail3" style="background: #2f2841; border: none;">
                </div>
            </div>
            <div class="row mb-3 text-left">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Lançamento:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control text-light" id="inputEmail3" style="background: #2f2841; border: none;">
                </div>
            </div>
            <div class="row mb-3 text-left">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Valor:</label>
                <div class="col-sm-10 align-end">
                    <input type="email" class="form-control text-light" id="inputEmail3" style="background: #2f2841; border: none;">
                </div>
            </div>
            <button type="submit" class="btn btn-light mb-3 text-light">Cadastrar</button>
            <button type="submit" class="btn btn-danger mb-3 text-light" id="btnFinalizar">Finalizar</button>
        </form>
    </div>
@endsection

@section('js')
    <script>
        let btnModal = $('#btn');
        let btnSelecionar = $('#btnSelectMonth');
        let btnSair = $('#btnSair');
        let inputMonth = $('#month');
        let form = $('#formMonth');
        let csrfToken = $("[name='_token']");
        let input = $('input');
        let divForm = $('#divForm');

        function updateBtn() {
            if (btnSelecionar.hasClass('disabled')) {
                btnSelecionar.removeClass('disabled');
            }

            if (!inputMonth.val()) {
                btnSelecionar.addClass('disabled');
            }
        }

        btnModal.trigger("click");

        inputMonth.change(updateBtn);

        form.submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: this.action,
                data: {
                    _token: csrfToken.val(),
                    date: inputMonth.val()
                },
                method: 'POST'
            }).done(function (response) {
                btnSair.trigger('click');

                btnModal.hide();
                divForm.fadeIn(400);
            }).fail(function () {
                divForm.hide();
                btnModal.show();
            });
        });
    </script>
@endsection
