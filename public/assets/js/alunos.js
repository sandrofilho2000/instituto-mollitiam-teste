async function addAluno(nome) { 
    $("body").addClass("loading")

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
                        location.href = '/alunos'; 
                }
            }
        });
        return data;
    } catch (error) {
        console.error("Erro ao carregar os alunos", error);
        // Caso haja um erro na requisição, você pode exibir uma mensagem geral
        $(".form-errors").html('<span class="badge bg-danger">Erro ao processar a requisição. Tente novamente mais tarde.</span>');
        $("body").removeClass("loading")
        return null;
    }
}

function showAlunoInputFields(e){
    e.target.closest("tr").classList.toggle("edit")
}

async function deleteAluno() { 
    const id = $("#id_aluno_delete").val();
    $("body").addClass("loading")

    if (!id) {
        console.error("ID do aluno não informado.");
        return;
    }

    try {
        const data = await $.ajax({
            url: `/alunos/deleteAluno/${id}`, // Passando o ID na URL
            method: 'DELETE',
            dataType: 'json',
            statusCode: {
                400: function (response) {
                    $(".form-messages").html(`<div class="alert alert-danger">${response.error || "Erro desconhecido"}</div>`);
                },
                200: function () {
                    $(".form-messages").html(`<div class="alert alert-success">Aluno(a) deletado com sucesso!</div>`);
                    location.href = '/alunos';
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

async function showDeleteAlunoPopUp(e) { 
    const id = e.target.closest("tr").querySelector("td.td-id").innerText
    const nome = e.target.closest("tr").querySelector("td.td-nome").innerText
    const matricula = e.target.closest("tr").querySelector("td.td-matricula").innerText
    $("#delete-aluno-form #id_aluno_delete").val(id)
    $("#delete-aluno-form #aluno_nome").text(nome); 
    $("#delete-aluno-form #aluno_matricula").text(`(${matricula})`); 
    $("#overlay, #overlay .delete-aluno-modal").show();
}

function slugify(string) {
    const map = {
        'á': 'a', 'à': 'a', 'â': 'a', 'ã': 'a', 'ä': 'a',
        'é': 'e', 'è': 'e', 'ê': 'e', 'ë': 'e',
        'í': 'i', 'ì': 'i', 'î': 'i', 'ï': 'i',
        'ó': 'o', 'ò': 'o', 'ô': 'o', 'õ': 'o', 'ö': 'o',
        'ú': 'u', 'ù': 'u', 'û': 'u', 'ü': 'u',
        'ç': 'c',
        'ñ': 'n',
        'Á': 'A', 'À': 'A', 'Â': 'A', 'Ã': 'A', 'Ä': 'A',
        'É': 'E', 'È': 'E', 'Ê': 'E', 'Ë': 'E',
        'Í': 'I', 'Ì': 'I', 'Î': 'I', 'Ï': 'I',
        'Ó': 'O', 'Ò': 'O', 'Ô': 'O', 'Õ': 'O', 'Ö': 'O',
        'Ú': 'U', 'Ù': 'U', 'Û': 'U', 'Ü': 'U',
        'Ç': 'C',
        'Ñ': 'N'
    };
    string = string.replace(/[^\u0000-\u007E]/g, char => map[char] || char);
    string = string.toLowerCase();
    string = string.replace(/[^a-z0-9]+/g, '-');
    string = string.replace(/^-+|-+$/g, '');

    return string;
}

function handleNota(e){
    let aluno_id = e.target.getAttribute("aluno-id")
    let disciplina_id = e.target.getAttribute("disciplina-id")
    let nota_inicial = Number(e.target.getAttribute("initial-value"))
    let nota_nova = Number(e.target.value)

    e.target.closest("td").querySelector(".td-value").innerText = nota_nova
    
    if(nota_inicial !== nota_nova && e.target.value ){
        $("#overlay_loading").removeClass("d-none").addClass("d-flex")
        $.ajax({
            url: '/notas/handleNota', 
            method: 'POST',
            dataType: 'json',
            data: { aluno_id: aluno_id, disciplina_id: disciplina_id, nota: nota_nova,  },
            success: function(response) {
                $("#overlay_loading").removeClass("d-flex").addClass("d-none");
                e.target.setAttribute("initial-value", nota_nova)
            },  

            error: function(e) {
                $("#overlay_loading").removeClass("d-flex").addClass("d-none");
                alert('Erro ao carregar os alunos');
                console.log("error: ", e)
            }
        });
    }
}

$(document).ready(function() {
    $("#overlay_loading").addClass("d-flex")
    $.ajax({
        url: '/alunos/getAlunos', 
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            let alunos = response.alunos;
            let disciplinas = response.disciplinas;
            console.log("🚀 ~ $ ~ disciplinas:", disciplinas)
            let dynamicColumns = [];
            if (alunos.length > 0) {
                let firstRow = alunos[0];
                const fixedColumns = ['id', 'aluno', 'matricula']; 
                for (let key in firstRow) {
                    if (!fixedColumns.includes(key)) { 
                        let disciplina_nome = disciplinas.filter(item => item.alias === key)[0].nome
                        dynamicColumns.push({
                            data: key, 
                            title: disciplina_nome, 
                            className: "td-disciplina",
                            render: function(data, type, row, meta){
                                let disciplina_id = disciplinas.filter(item => item.alias === key)[0].id
                                return `
                                        <input type="number" min="0" disciplina-id='${disciplina_id}' aluno-id='${row.id}' initial-value='${row[key]}' class="form-control td-input td-input-matricula" max="10" placeholder="Nota" value='${row[key]}' aria-label="Nora" aria-describedby="basic-addon1"/>
                                        <span class="td-value td-aluno">${row[key]}</span>
        
                                `
                            }
                        });
                    }
                }
            }

            // Configurar o DataTable
            $('#tb-lista').DataTable({
                responsive: true,
                pageLength: 10,
                searching: true,
                lengthChange: false,
                autoWidth: true, 
                fixedHeader: true, 
                scrollX: true, 
                language: { 
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json' 
                },
                processing: true,
                order: [[1, 'asc']],
                data: alunos,
                columns: [
                    { data: 'id', title: 'ID', className: "td-id" },
                    { data: 'aluno', title: 'Aluno', className: "td-aluno"},
                    { data: 'matricula', title: 'Matrícula', className: "td-matricula" },
                    ...dynamicColumns, // Adicionar colunas dinâmicas
                    { 
                        data: null,
                        title: 'Ações',
                        orderable: false, 
                        render: function(data, type, row, meta) {
                            return `
                                <div class="d-flex gap-1 justify-content-end">
                                    <button title="Editar Aluno" type="button" class="btn align-items-center gap-1  d-flex btn-sm btn-success btn-aluno-edit f-s-10">
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><g id="Edit"><g><path d="M3.548,20.938h16.9a.5.5,0,0,0,0-1H3.548a.5.5,0,0,0,0,1Z"></path><path d="M9.71,17.18a2.587,2.587,0,0,0,1.12-.65l9.54-9.54a1.75,1.75,0,0,0,0-2.47l-.94-.93a1.788,1.788,0,0,0-2.47,0L7.42,13.12a2.473,2.473,0,0,0-.64,1.12L6.04,17a.737.737,0,0,0,.19.72.767.767,0,0,0,.53.22Zm.41-1.36a1.468,1.468,0,0,1-.67.39l-.97.26-1-1,.26-.97a1.521,1.521,0,0,1,.39-.67l.38-.37,1.99,1.99Zm1.09-1.08L9.22,12.75l6.73-6.73,1.99,1.99Zm8.45-8.45L18.65,7.3,16.66,5.31l1.01-1.02a.748.748,0,0,1,1.06,0l.93.94A.754.754,0,0,1,19.66,6.29Z"></path></g></g></svg>
                                    </button>
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
                        }
                    }
                ],
                columnDefs: [
                    { targets: '_all', width: 'auto' } // Faz com que todas as colunas tenham largura automática
                ]
            });
            
            $("#overlay_loading").removeClass("d-flex").addClass("d-none");
        },            
        error: function() {
            alert('Erro ao carregar os alunos');
            $("#overlay_loading").removeClass("d-flex").addClass("d-none");
        }
    });


    $("#add-aluno").click(function(){
        $("#overlay, #overlay .add-aluno-modal").show()
    })

    $(document).on('click', '.btn-delete-aluno', async function (e) {
        await showDeleteAlunoPopUp(e);
    });

    $(document).on('blur', '.td-input-matricula', async function (e) {
        await handleNota(e)
    });

    $(document).on('click', '.btn-aluno-edit', async function (e) {
        showAlunoInputFields(e);
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
        if (nome) {
            await addAluno(nome);
        } else {
            alert("Nome não pode ser vazio.");
        }
    });

    $("#delete-aluno-form").submit(async function (e) {
        e.preventDefault();
        await deleteAluno();
    });
        
});