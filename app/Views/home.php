<!-- home.php -->
<div class="container">
    <div class="d-flex justify-content-between align-items-center my-4">
        <h2>Lista de Alunos</h2>
        <button id="add-aluno" class="btn btn-success">
            Cadastrar Aluno
        </button>
    </div>
    <div class="table-responsive">
        <table id="tb-lista" class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Aluno</th>
                    <th>Matrícula</th>
                    <td>

                    </td>
                </tr>
            </thead>
            <tbody>
                <!-- Dados da tabela aqui -->
            </tbody>
        </table>
    </div>
</div>

<div class="overlay" id="overlay">
    <div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Adicionar Aluno</h5>
            <button type="button" class="modal-close btn btn-danger" id="add-aluno" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="add-aluno-form">
            <div class="modal-body">
                  <input type="text" class="form-control" placeholder="Nome" aria-label="name" aria-describedby="basic-addon1">
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Salvar">
                <button type="button" class="btn btn-secondary modal-close" data-dismiss="modal">Fechar</button>
            </div>
            </div>
        </form>
    </div>
    </div>
</div>