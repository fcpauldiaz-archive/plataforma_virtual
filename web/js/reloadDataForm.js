$('#submitBtn').click(function() {
  
    $('#tipo').html($('#documentbundle_documento_tipoDocumento option:selected').text())
    $('#curso').html($('#documentbundle_documento_curso option:selected').text())
    $('#numero').html($('#documentbundle_documento_numeroDocumento option:selected').text())
    $('#nombre').html($('#documentbundle_documento_documentFile_file').val().split('\\').pop())
  
  

});

$('#submit').click(function(){
    alert('submitting');
    $('#formfield').submit();
});