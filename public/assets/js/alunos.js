async function addAluno(nome) { 
    try {
        const data = await $.ajax({
            url: '/alunos/addAluno',
            method: 'POST',
            dataType: 'json',
            data: { nome: nome },
            statusCode: {
                400: function (response) {
                    let errors_html = '';
                    if (response.errors) {
                        response.errors.forEach((item) => {
                            errors_html += `<div class="alert alert-danger" role="alert">
                                                    ${item}
                                                </div>`;
                        });
                        $(".form-messages").html(errors_html); // Exibe os erros no local adequado
                    } else {
                        $(".form-messages").html(`<div class="alert alert-danger" role="alert">
                                                    Erro desconhecido
                                                </div>`);
                    }
                },
                200: function () {
                    $(".form-messages").html(`<div class="alert alert-success" role="alert">
                                                   Aluno adicionado com sucesso!
                                                </div>`);
                    setTimeout(() => {
                        location.href = '/alunos'; // Redirecionamento, por exemplo
                    }, 3000);
                }
            }
        });
        return data;
    } catch (error) {
        console.error("Erro ao carregar os alunos", error);
        // Caso haja um erro na requisição, você pode exibir uma mensagem geral
        $(".form-errors").html('<span class="badge bg-danger">Erro ao processar a requisição. Tente novamente mais tarde.</span>');
        return null;
    }
}

async function showDeleteAlunoPopUp(e) { 
    const id = e.target.closest("tr").querySelector("td.td-id").innerText
    const nome = e.target.closest("tr").querySelector("td.td-nome").innerText
    const matricula = e.target.closest("tr").querySelector("td.td-matricula").innerText
    $("#delete-aluno-form #id_aluno").val(id)
    $("#delete-aluno-form #aluno_nome").text(nome); 
    $("#delete-aluno-form #aluno_matricula").text(`(${matricula})`); 
    $("#overlay, #overlay .delete-aluno-modal").show();
}

$(document).ready(function() {
    $.ajax({
        url: '/alunos/getAlunos', 
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            let alunos = data;
            $('#tb-lista').DataTable({
                responsive: true,
                pageLength: 10,
                searching: true,
                lengthChange: false,
                autoWidth: false, // Manter como false para evitar largura fixa
                fixedHeader: true, // Ajusta automaticamente quando rolar
                scrollX: true, // Habilita rolagem horizontal se necessário
                language: { 
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json' 
                },
                processing: true,
                order: [[1, 'asc']],
                data: alunos,
                columns: [
                    { data: 'id', className: "td-id" },
                    { data: 'nome', className: "td-nome" },
                    { data: 'matricula',  className: "td-matricula" },
                    { 
                        data: null,
                        orderable: false, 
                        render: function(data, type, row, meta) {
                        return `
                                <div class="d-flex gap-1 justify-content-end">
                                    <button title="Ver boletim" type="button" class="btn align-items-center gap-1  d-flex btn-sm btn-primary btn-aluno-boletim f-s-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z"/>
                                        </svg>
                                    </button>
                                    <button title="Deletar aluno" type="button" class="btn d-flex btn-sm btn-danger gap-1 align-items-center btn-delete-aluno f-s-10">                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                    </button>
                                </div>
                        `;
                    }}
                ],
                columnDefs: [
                    { targets: '_all', width: 'auto' } // Faz com que todas as colunas tenham largura automática
                ]
            });
            
        },            
        error: function() {
            alert('Erro ao carregar os alunos');
        }
    });

    $("#add-aluno").click(function(){
        $("#overlay, #overlay .add-aluno-modal").show()
    })

    $(document).on('click', '.btn-delete-aluno', async function (e) {
        await showDeleteAlunoPopUp(e);
    });

    $("#overlay").click(function(e) {
        $(this).hide();       
    });

    $(".modal, .modal-dialog, .modal-content").click(function(e) {
        e.stopPropagation();  
    });

    $(".modal-close").click(function() {
        $("#overlay").hide();  
        $(".modal").hide();  
    });

    $("#add-aluno-form").submit(async function (e) {
        e.preventDefault();
        const nome = e.target.elements['nome'].value || '';  
        console.log("🚀 ~ nome:", nome);
        if (nome) {
            const alunos = await addAluno(nome);
            console.log("Lista de alunos:", alunos);
        } else {
            alert("Nome não pode ser vazio.");
        }
    });
        
});