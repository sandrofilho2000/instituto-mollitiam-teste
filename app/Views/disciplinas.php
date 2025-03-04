<!-- disciplinas.php -->
<div class="container">
    <div class="d-flex justify-content-between align-items-center my-4">
        <h2>Lista de Disciplinas</h2>
        <button id="add-disciplina" class="btn btn-success">
            Cadastrar Disciplina
        </button>
    </div>
    <div class="table-responsive">
        <table id="tb-lista" class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Disciplina</th>
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
    <div class="modal delete-disciplina-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deletar Disciplina</h5>
                <button type="button" class="modal-close btn btn-danger" id="add-disciplina" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete-disciplina-form">
                <input type="hidden" id="id_disciplina_delete" name="id_disciplina_delete">
                <div class="modal-body">
                    <div class="form-messages d-flex flex-column gap-1 px-3 pt-3 ">
                        <div class="alert alert-danger" role="alert">
                            Deseja realmente deletar o disciplina "<span class="disciplina_nome" id="disciplina_nome">Sandro Filho </span> <span class="disciplina_matricula" id="disciplina_matricula"> (MATR001)</span>"?
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
    
    <div class="modal add-disciplina-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Disciplina</h5>
                <button type="button" class="modal-close btn btn-danger" id="add-disciplina" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add-disciplina-form">
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


<script src="<?= base_url(relativePath: 'assets/js/disciplinas.js'); ?>"></script>
