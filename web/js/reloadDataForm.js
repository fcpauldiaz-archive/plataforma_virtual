$('#submitBtn').click(function() {
    if ($('documentbundle_documento_tipoDocumento').val()==1){
        $('#tipo').html('Parcial')
    }
    else{
         $('#tipo').html('Hoja de Trabajo')
    }


    $('#curso').html($('#documentbundle_documento_curso option:selected').text())
    $('#numero').html($('#documentbundle_documento_numeroDocumento').val())
    $('#nombre').html($('#documentbundle_documento_documentFile_file').val().split('\\').pop())
  
  

});

$('#submit').click(function(){
    alert('submitting');
    $('#formfield').submit();
});