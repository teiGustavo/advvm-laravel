@extends('master')

@section('content')
    <!-- Button trigger modal -->
    <button type="button" id="btn" class="btn btn-light text-light" data-bs-toggle="modal" data-bs-target="#modalSelectExcel">
        Baixar Excel
    </button>

    <!-- Modal -->
    <div class="modal fade text-light" id="modalSelectExcel" tabindex="-1" aria-labelledby="modalSelectExcelLabel"
         aria-hidden="true" data-bs-theme="dark">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalSelectExcelLabel">Baixar Excel:</h1>
                    <div id="loading" class="spinner-grow text-info spinner-grow-sm hidden" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.excel.generate') }}" id="formExcel">
                    <div class="modal-body">
                        @csrf
                        <div class="form-floating mb-3" id="divSelectYear">
                                <select class="form-select" id="selectYear" aria-label="Floating label select">
                                    @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                                <label for="selectYear">Selecione o ano:</label>
                        </div>

                        <div class="form-floating mb-3 hidden" id="divSelectMonth">
                            <select class="form-select" id="selectMonth" aria-label="Floating label select">

                            </select>
                            <label for="selectYear">Selecione o mês:</label>
                        </div>
                    </div>
                    <div class="modal-footer hidden" id="modalFooter">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sair</button>
                        <button type="submit" class="btn btn-success" id="downloadExcel">Baixar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    let form =  $('#formExcel');
    let excelButton =  $('#btn');
    let downloadButton =  $('#downloadExcel');
    let divSelectMonth = $('#divSelectMonth');
    let selectMonth = $('#selectMonth');
    let selectYear = $("#selectYear");
    let selectYearOption = $("#selectYear option");
    let modalFooter = $('#modalFooter');
    let csrfToken = $("[name='_token']");
    let loading = $("#loading");

    function submitSelectForm() {
        $.ajax({
            url: '{{ route('admin.excel.selectMonth') }}',
            data: {
                _token: csrfToken.val(),
                year: selectYear.val()
            },
            method: 'POST'
        }).done(function (response) {
            divSelectMonth.hide();
            selectMonth.empty()

            divSelectMonth.fadeIn(400);

            response.forEach(function (month) {
                selectMonth.append($('<option>', {
                    value: month,
                    text: month
                }));
            });

            modalFooter.fadeIn(200);
        });
    }

    excelButton.on("click", function () {
        submitSelectForm();
    });

    excelButton.trigger('click');

    selectYearOption.on('click', function () {
        submitSelectForm();
    });

    downloadButton.on("click", function () {
        loading.show();
    })

    form.submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: this.action,
            data: {
                _token: csrfToken.val(),
                year: selectYear.val(),
                month: selectMonth.val()
            },
            method: 'POST'
        }).done(function (response) {
            window.open("{{ route("admin.excel.download") }}/" + response);
            loading.hide();
        });
    });
</script>
@endsection
