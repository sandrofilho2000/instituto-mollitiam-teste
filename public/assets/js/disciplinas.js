async function addDisciplina(nome) { 
    $("body").addClass("loading")

    try {
        const data = await $.ajax({
            url: '/disciplinas/addDisciplina',
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
                                                   Disciplina adicionada com sucesso!
                                                </div>`);
                    location.href = '/disciplinas'; 
                }
            }
        });
        return data;
    } catch (error) {
        console.error("Erro ao carregar os disciplinas", error);
        // Caso haja um erro na requisição, você pode exibir uma mensagem geral
        $(".form-errors").html('<span class="badge bg-danger">Erro ao processar a requisição. Tente novamente mais tarde.</span>');
        $("body").removeClass("loading")
        return null;
    }
}

async function deleteDisciplina() { 
    const id = $("#id_disciplina_delete").val();
    $("body").addClass("loading")

    if (!id) {
        console.error("ID do disciplina não informado.");
        return;
    }

    try {
        const data = await $.ajax({
            url: `/disciplinas/deleteDisciplina/${id}`, // Passando o ID na URL
            method: 'DELETE',
            dataType: 'json',
            statusCode: {
                400: function (response) {
                    $(".form-messages").html(`<div class="alert alert-danger">${response.error || "Erro desconhecido"}</div>`);
                },
                200: function () {
                    console.log("sucesso: ")
                    $(".form-messages").html(`<div class="alert alert-success">Disciplina(a) deletada com sucesso!</div>`);
                    location.href = '/disciplinas', 3000;
                }
            }
        });

        return data;
    } catch (error) {
        console.error("Erro ao processar a requisição", error);
        $(".form-errors").html('<span class="badge bg-danger">Erro ao processar a requisição.</span>');
        $("body").removeClass("loading")
        return null;
    }
}

async function showDeleteDisciplinaPopUp(e) { 
    const id = e.target.closest("tr").querySelector("td.td-id").innerText
    const nome = e.target.closest("tr").querySelector("td.td-nome").innerText
    $("#delete-disciplina-form #id_disciplina_delete").val(id)
    $("#delete-disciplina-form #disciplina_nome").text(nome); 
    $("#overlay, #overlay .delete-disciplina-modal").show();
}

$(document).ready(function() {
    $("#overlay_loading").addClass("d-flex")
    $.ajax({
        url: '/disciplinas/getDisciplinas', 
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log("🚀 ~ $ ~ data:", data)
            let disciplinas = data;
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
                data: disciplinas,
                columns: [
                    { data: 'id', className: "td-id" },
                    { data: 'nome', className: "td-nome" },
                    { 
                        data: null,
                        orderable: false, 
                        render: function(data, type, row, meta) {
                        return `
                                <div class="d-flex gap-1 justify-content-end">
                                    <button title="Deletar disciplina" type="button" class="btn d-flex btn-sm btn-danger gap-1 align-items-center btn-delete-disciplina f-s-10">                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
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
            
            $("#overlay_loading").removeClass("d-flex").addClass("d-none")
        },            
        error: function() {
            alert('Erro ao carregar os disciplinas');
            $("#overlay_loading").removeClass("d-flex").addClass("d-none")
        }
    });


    $("#add-disciplina").click(function(){
        $("#overlay, #overlay .add-disciplina-modal").show()
    })

    $(document).on('click', '.btn-delete-disciplina', async function (e) {
        await showDeleteDisciplinaPopUp(e);
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

    $("#add-disciplina-form").submit(async function (e) {
        e.preventDefault();
        const nome = e.target.elements['nome'].value || '';  
        if (nome) {
            const disciplinas = await addDisciplina(nome);
            console.log("Lista de disciplinas:", disciplinas);
        } else {
            alert("Nome não pode ser vazio.");
        }
    });

    $("#delete-disciplina-form").submit(async function (e) {
        e.preventDefault();
        await deleteDisciplina();
    });
        
});