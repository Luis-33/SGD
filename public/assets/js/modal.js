function openModal(modalClass) {
    $('.' + modalClass).css('display', 'block');
}

generarPDF = function (id) {
    console.log(id);
    window.open('generar_pdf.php', '_blank');
}

function closeModal(modalClass) {
    $('.' + modalClass).css('display', 'none');
}