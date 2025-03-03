<!-- alunos.php -->
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
                    <th class="text-end">
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody>
                <!-- Dados da tabela aqui -->
            </tbody>
        </table>
    </div>
</div>

<div class="overlay" id="overlay">
    <div class="modal delete-aluno-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deletar Aluno(a)</h5>
                <button type="button" class="modal-close btn btn-danger" id="add-aluno" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete-aluno-form">
                <input type="hidden" id="id_aluno_delete" name="id_aluno_delete">
                <div class="modal-body">
                    <div class="form-messages d-flex flex-column gap-1 px-3 pt-3 ">
                        <div class="alert alert-danger" role="alert">
                            Deseja realmente deletar o aluno "<span class="aluno_nome" id="aluno_nome">Sandro Filho </span> <span class="aluno_matricula" id="aluno_matricula"> (MATR001)</span>"?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-danger" value="Deletar">
                    <button type="button" class="btn btn-secondary modal-close" data-dismiss="modal">Cancelar</button>
                </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="modal add-aluno-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Aluno(a)</h5>
                <button type="button" class="modal-close btn btn-danger" id="add-aluno" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add-aluno-form">
                <div class="form-messages d-flex flex-column gap-1 px-3 pt-3 ">

                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" placeholder="Nome" aria-label="nome" name="nome" aria-describedby="basic-addon1">
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


<div class="overlay_loading d-flex align-items-center justify-content-center" id="overlay_loading">
    <div class="spinner-border text-primary" role="status">
    </div>
</div>
