@extends('master')

@section('content')
    <!-- Button trigger modal -->
    <button type="button" id="btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSelectExcel">
        Baixar Excel
    </button>

    <!-- Modal -->
    <div class="modal fade text-light" id="modalSelectExcel" tabindex="-1" aria-labelledby="modalSelectExcelLabel"
         aria-hidden="true" data-bs-theme="dark">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalSelectExcelLabel">Baixar Excel:</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.excel.download') }}">
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
                    </form>
                </div>
                <div class="modal-footer hidden" id="modalFooter">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sair</button>
                    <button type="button" class="btn btn-success">Baixar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $('#btn').trigger('click');

    $("#selectYear option").on('click', function () {
        $.ajax({
            url: '{{ route('admin.excel.selectMonth') }}',
            data: {
                '_token': $("[name='_token']").val(),
                year: $("#selectYear").val()
            },
            method: 'POST'
        }).done(function (response) {
            let divSelectMonth = $('#divSelectMonth');
            let selectMonth = $('#selectMonth');
            let modalFooter = $('#modalFooter');

            divSelectMonth.hide();
            selectMonth.empty()

            divSelectMonth.fadeIn(400);

            response.forEach(function (month) {
                $('#selectMonth').append($('<option>', {
                    value: month,
                    text: month
                }));
            });

            modalFooter.fadeIn(200);
        });
    });
</script>
@endsection
