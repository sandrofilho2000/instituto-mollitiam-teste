$(document).ready(function() {
    $.ajax({
        url: '/home/getAlunos', 
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            let alunos = data;
            console.log("🚀 ~ $ ~ alunos:", alunos)
            $('#tb-lista').DataTable({
                responsive: true,  // Ativa o modo responsivo
                pageLength: 10,  
                searching: true,
                lengthChange: false, 
                language: { 
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json' 
                },
                processing: true, 
                order: [[1, 'asc']], 
                data: alunos, 
                columns: [
                    { data: 'id' }, 
                    { data: 'nome' }, 
                    { data: 'matricula' } 
                ],
            });
        },            
        error: function() {
            alert('Erro ao carregar os alunos');
        }
    });

    $("#add-aluno").click(function(){
        $("#overlay, #overlay .modal").show()
    })

    $("#overlay").click(function(e) {
        $(this).hide();       
    });

    $(".modal, .modal-dialog, .modal-content").click(function(e) {
        e.stopPropagation();  
    });

    $(".modal-close").click(function() {
        $("#overlay").hide();  
    });

    $("#add-aluno-form").submit(function(e){
        e.preventDefault()
        console.log(e.target)
    })

});